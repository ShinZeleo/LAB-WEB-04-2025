<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                             ->orWhereHas('category', function ($subQuery) use ($search) {
                                 $subQuery->where('name', 'like', '%' . $search . '%');
                             });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Extract product detail fields
        $productDetailData = [
            'description' => $validated['description'] ?? null,
            'weight' => $validated['weight'],
            'size' => $validated['size'] ?? null,
        ];
        
        unset($validated['description'], $validated['weight'], $validated['size']);
        
        // Create the product
        $product = Product::create($validated);
        
        // Create the product detail
        $product->productDetail()->create($productDetailData);
        
        return redirect()->route('products.index')
                         ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'productDetail']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $product->load(['category', 'productDetail']);
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();
        
        // Extract product detail fields
        $productDetailData = [
            'description' => $validated['description'] ?? null,
            'weight' => $validated['weight'],
            'size' => $validated['size'] ?? null,
        ];
        
        unset($validated['description'], $validated['weight'], $validated['size']);
        
        // Update the product
        $product->update($validated);
        
        // Update or create the product detail
        $product->productDetail()->updateOrCreate([], $productDetailData);
        
        return redirect()->route('products.index')
                         ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully.');
    }
}
