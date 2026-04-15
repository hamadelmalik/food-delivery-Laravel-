<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OptionTypeController;

// ====================================
// Routes محمية بالمصادقة (Sanctum)
// ====================================
Route::middleware('auth:sanctum')->group(function () {

    // 🟢 بيانات المستخدم
    Route::get('/user', fn(Request $request) => $request->user());

    // 🟢 Profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);

    // 🟢 Orders
    Route::post('/orders', [OrderController::class, 'store']); // حفظ طلب جديد
    Route::get('/orders', [OrderController::class, 'index']);  // كل الطلبات الخاصة بالمستخدم
    Route::get('/orders/{id}', [OrderController::class, 'show']); // تفاصيل طلب معين

    // 🟢 Cart
     Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update/{id}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::delete('/cart/clear', [CartController::class, 'clear']);

    // 🟢 Product Options
    Route::post('/options', [ProductOptionController::class, 'store']);

    // 🟢 Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// ====================================
// Public Routes (غير محمية)
// ====================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/ping', fn () => 'API OK');

// 🟢 Products
Route::apiResource('products', ProductController::class)->only(['index', 'store']);

// 🟢 Options
Route::get('/option-types-new', [OptionTypeController::class, 'indexnew']);
Route::get('/options', [ProductOptionController::class, 'getOptions']);
Route::get('/options-new', [ProductOptionController::class, 'getOptionsnew']);
