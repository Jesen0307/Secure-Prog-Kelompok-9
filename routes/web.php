<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\MerchantAuthController;
use App\Http\Controllers\MerchantProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;



Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', function () {
    return view('home');
})->name('login');


Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register'])->name('register.submit');

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect('/')->withErrors(['loginemail' => 'Please login first.']);
    }

    $user = Auth::user();
    $products = Product::where('stock', '>=', 1)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('dashboard', [
        'user' => $user,
        'products' => $products,
    ]);
})->name('dashboard.home')->middleware('auth');


Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/search', [ProductController::class, 'search'])->name('search');


Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('password.request');

Route::post('/forgot-password', [UserController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');

Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.update');




Route::get('/merchant/login', [MerchantAuthController::class, 'showLoginForm'])->name('merchant.login');
Route::post('/merchant/login', [MerchantAuthController::class, 'login'])->name('merchant.login.submit');
Route::post('/merchant/logout', [MerchantAuthController::class, 'logout'])->name('merchant.logout');


Route::get('/merchant/register', [MerchantAuthController::class, 'showRegisterForm'])->name('merchant.register');
Route::post('/merchant/register', [MerchantAuthController::class, 'register'])->name('merchant.register.submit');


Route::get('/merchant/forgot-password', [MerchantAuthController::class, 'showForgotPasswordForm'])->name('merchant.password.request');
Route::post('/merchant/forgot-password', [MerchantAuthController::class, 'sendResetLink'])->name('merchant.password.email');
Route::get('/merchant/reset-password/{token}', [MerchantAuthController::class, 'showResetForm'])->name('merchant.password.reset');
Route::post('/merchant/reset-password', [MerchantAuthController::class, 'resetPassword'])->name('merchant.password.update');


Route::get('/merchant/dashboard', [MerchantAuthController::class, 'dashboard'])
    ->middleware('auth:merchant')
    ->name('merchant.dashboard');

Route::post('/merchant/products', [MerchantProductController::class, 'store'])
    ->name('merchant.products.store')
    ->middleware('auth:merchant');

Route::delete('/merchant/products/{id}', [MerchantProductController::class, 'destroy'])
    ->name('merchant.products.destroy')
    ->middleware('auth:merchant');


Route::get('/product/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')
    ->name('product.show');

Route::middleware('auth')->group(function() {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
});
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.view');

    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



