<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Http\Requests\StockTransferRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $warehouseId = $request->input('warehouse_id');
        $warehouses = Warehouse::orderBy('name')->get();

        $stocks = collect();

        if ($warehouseId) {
            $warehouse = Warehouse::with(['products' => function($query) {
                $query->orderBy('name');
            }])->find($warehouseId);
            
            if ($warehouse) {
                $stocks = $warehouse->products;
            }
        } else {
            // Tampilkan semua stok dari semua gudang jika tidak ada filter
            $stocks = Product::with(['warehouses', 'category'])
                ->whereHas('warehouses')
                ->orderBy('name')
                ->get();
        }

        return view('stock.index', compact('stocks', 'warehouses', 'warehouseId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::with('category')->orderBy('name')->get();

        return view('stock.transfer', compact('warehouses', 'products'));
    }

    /**
     * Transfer stock between warehouses.
     */
    public function store(StockTransferRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $quantityDelta = (int) $validated['quantity_delta'];

        try {
            DB::beginTransaction();

            $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
            $product = Product::findOrFail($validated['product_id']);
            
            // Check if the product-warehouse relationship exists
            $productWarehouse = ProductWarehouse::where([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
            ])->first();
            
            // If the relationship doesn't exist and delta is negative, reject
            if (!$productWarehouse && $quantityDelta < 0) {
                throw new \Exception('Cannot transfer negative stock for a product that does not exist in this warehouse');
            }
            
            // If relationship doesn't exist but delta is positive, create new record
            if (!$productWarehouse) {
                $productWarehouse = ProductWarehouse::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => 0
                ]);
            }
            
            // Calculate the new quantity after the transfer
            $newQuantity = $productWarehouse->quantity + $quantityDelta;

            // Check that the new quantity is not negative
            if ($newQuantity < 0) {
                throw new \Exception('Stock cannot be negative after transfer');
            }

            // Update the quantity
            $productWarehouse->update(['quantity' => $newQuantity]);

            DB::commit();

            $action = $quantityDelta > 0 ? 'added' : 'removed';
            $quantity = abs($quantityDelta);
            
            return redirect()->route('stock.index')
                             ->with('success', "Successfully {$action} {$quantity} units of {$product->name} to {$warehouse->name}.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }
}
