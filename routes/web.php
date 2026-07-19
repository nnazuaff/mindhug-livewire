<?php

use App\Http\Livewire\Upgrade\Checkout;
use App\Http\Livewire\Upgrade\Index;
use App\Http\Livewire\Upgrade\OrderDetail;
use App\Http\Livewire\Upgrade\OrderPay;
use App\Http\Livewire\Upgrade\Orders;
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

    // ── Upgrade / Plus ────────────────────────────
    Route::get('/plus', Index::class)->name('plus');

    Route::post('/plus/start', function () {
        $plan = SubscriptionPlan::where('slug', 'plus-bulanan')->firstOrFail();

        session()->put('upgrade_plan', [
            'id' => $plan->id,
            'name' => $plan->name,
            'price' => $plan->price,
            'duration_days' => $plan->duration_days,
        ]);

        return redirect()->route('plus.checkout');
    })->name('plus.start');

    Route::get('/plus/checkout', Checkout::class)->name('plus.checkout');
    Route::get('/plus/orders', Orders::class)->name('plus.orders');

    Route::get('/plus/orders/{order:invoice_number}', OrderDetail::class)
        ->name('plus.orders.show');

    Route::get('/plus/orders/{order:invoice_number}/pay', OrderPay::class)
        ->name('plus.orders.pay');

    // ── Logout ────────────────────────────────────
    Route::post('/logout', function () {
        Auth::logout();

        return redirect('/');
    })->name('logout');

    // ── Curhat ────────────────────────────────────
    Route::view('/curhat', 'curhat.index')->name('curhat');

    // ── Account ───────────────────────────────────
    Route::view('/account/profile', 'account.profile')->name('account.profile');
    Route::view('/account/security', 'account.security')->name('account.security');
    Route::view('/account/addresses', 'account.addresses')->name('account.addresses');

    // ── Transactions ──────────────────────────────
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

// ── Shop (public) ────────────────────────────────
Route::get('/shop', function () {
    return view('shop.index');
})->name('shop');

Route::get('/product/{product}', function (Product $product) {
    if (! $product->is_active) {
        abort(404);
    }

    return view('shop.product-detail', compact('product'));
})->name('product.detail');
