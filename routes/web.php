<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\MerchantAuthController;
use App\Http\Controllers\MerchantProductController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Show login form
Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login form submission
Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register'])->name('register.submit');

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect('/')->withErrors(['loginemail' => 'Please login first.']);
    }

    $user = Auth::user();
    $products = Product::orderBy('created_at', 'desc')->get(); // semua produk, terbaru dulu

    return view('dashboard', [
        'user' => $user,
        'products' => $products,
    ]);
})->name('dashboard')->middleware('auth');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/search', [ProductController::class, 'search'])->name('search');


Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('password.request');

Route::post('/forgot-password', [UserController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');

Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.update');



// Merchant login/logout
Route::get('/merchant/login', [MerchantAuthController::class, 'showLoginForm'])->name('merchant.login');
Route::post('/merchant/login', [MerchantAuthController::class, 'login'])->name('merchant.login.submit');
Route::post('/merchant/logout', [MerchantAuthController::class, 'logout'])->name('merchant.logout');

// Merchant register
Route::get('/merchant/register', [MerchantAuthController::class, 'showRegisterForm'])->name('merchant.register');
Route::post('/merchant/register', [MerchantAuthController::class, 'register'])->name('merchant.register.submit');

// Merchant forgot password + reset
Route::get('/merchant/forgot-password', [MerchantAuthController::class, 'showForgotPasswordForm'])->name('merchant.password.request');
Route::post('/merchant/forgot-password', [MerchantAuthController::class, 'sendResetLink'])->name('merchant.password.email');
Route::get('/merchant/reset-password/{token}', [MerchantAuthController::class, 'showResetForm'])->name('merchant.password.reset');
Route::post('/merchant/reset-password', [MerchantAuthController::class, 'resetPassword'])->name('merchant.password.update');

// Merchant dashboard
Route::get('/merchant/dashboard', [MerchantAuthController::class, 'dashboard'])
    ->middleware('auth:merchant')
    ->name('merchant.dashboard');

// routes/web.php
Route::post('/merchant/products', [MerchantProductController::class, 'store'])
    ->name('merchant.products.store')
    ->middleware('auth:merchant');


