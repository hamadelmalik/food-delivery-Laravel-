<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OptionTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductOptionController;
use App\Http\Controllers\BackupController;

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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    //backup---
    Route::get('/backup',
[BackupController::class,'index'])
->name('backup.index');


Route::post('/backup/create',
[BackupController::class,'create'])
->name('backup.create');

Route::get('/test-payment', function () {
    return view('payment.test-payment');
});
