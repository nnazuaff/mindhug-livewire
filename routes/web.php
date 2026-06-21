<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    Route::view('/curhat', 'curhat.index')->name('curhat');
});

Route::get('/shop', function () {
    return view('shop.index');
})->name('shop');

Route::get('/product/{product}', function (Product $product) {
    return view('shop.product-detail', compact('product'));
})->name('product.detail');
