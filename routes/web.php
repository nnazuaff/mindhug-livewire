<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/kontak', 'kontak.index')->name('kontak');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::middleware(['auth', 'user.active'])->group(function () {

    Route::get('/upgrade/checkout/{plan:slug}', function (SubscriptionPlan $plan) {
        return view('upgrade.checkout', compact('plan'));
    })->name('upgrade.checkout');
    Route::view('/upgrade', 'upgrade.index')->name('upgrade');
    Route::post('/logout', function () {
        Auth::logout();

        return redirect('/');
    })->name('logout');

    Route::view('/curhat', 'curhat.index')->name('curhat');
    Route::view('/account/profile', 'account.profile')->name('account.profile');
    Route::view('/account/security', 'account.security')->name('account.security');
    Route::view('/account/addresses', 'account.addresses')->name('account.addresses');
    Route::view('/transactions/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout.index')->name('checkout');

    Route::get('/transactions/orders', function () {
        return view('orders.index');
    })->name('orders.index');

    Route::get('/transactions/orders/{order:invoice_number}', function (Order $order) {
        return view('orders.show', compact('order'));
    })->name('orders.show');

    Route::get('/transactions/orders/{order:invoice_number}/pay', function (Order $order) {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.pay', compact('order'));
    })->name('orders.pay');
});

Route::get('/shop', function () {
    return view('shop.index');
})->name('shop');

Route::get('/product/{product}', function (Product $product) {
    if (! $product->is_active) {
        abort(404);
    }

    return view('shop.product-detail', compact('product'));
})->name('product.detail');
