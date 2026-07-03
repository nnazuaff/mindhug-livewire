<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/kontak', 'kontak.index')->name('kontak');

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
    Route::view('/account/profile', 'account.profile')->name('account.profile');
    Route::view('/account/security', 'account.security')->name('account.security');
    Route::view('/account/addresses', 'account.addresses')->name('account.addresses');
    Route::view('/checkout', 'checkout.index')->name('checkout');
});

Route::get('/shop', function () {
    return view('shop.index');
})->name('shop');

Route::get('/product/{product}', function (Product $product) {
    return view('shop.product-detail', compact('product'));
})->name('product.detail');
