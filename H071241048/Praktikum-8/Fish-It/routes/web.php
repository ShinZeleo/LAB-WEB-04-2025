<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FishController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route for fish management
Route::resource('fishes', FishController::class);

// Redirect the root path to the fishes index page
Route::get('/', function () {
    return redirect()->route('fishes.index');
});
