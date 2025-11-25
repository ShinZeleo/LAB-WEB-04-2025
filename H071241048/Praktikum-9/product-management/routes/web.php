<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Category routes
Route::resource('categories', CategoryController::class);

// Warehouse routes
Route::resource('warehouses', WarehouseController::class);

// Product routes
Route::resource('products', ProductController::class);

// Stock routes
Route::get('stock', [StockController::class, 'index'])->name('stock.index');
Route::get('stock/transfer', [StockController::class, 'create'])->name('stock.create');
Route::post('stock', [StockController::class, 'store'])->name('stock.store');


