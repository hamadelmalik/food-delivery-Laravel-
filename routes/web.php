<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OptionTypeController;
use App\Http\Controllers\ProductOptionController;

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::get('/fix-image-paths', [ProductController::class, 'fixImagePaths']);
Route::get('/register-form', function () {
    return view('auth.register');
});

Route::get('/product-options/create', [ProductOptionController::class, 'create'])->name('product-options.create');
Route::post('/product-options/store', [ProductOptionController::class, 'store'])->name('product-options.store');
Route::resource('option-types', OptionTypeController::class);
Route::get('/dashboard', function() {
    return view('dashboard'); // this should match the filename
})->name('dashboard');
