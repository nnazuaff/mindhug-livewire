<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Livewire\Admin\Categories;
use App\Http\Livewire\Admin\Curhats\Index as CurhatsIndex;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Orders;
use App\Http\Livewire\Admin\PaymentMethods;
use App\Http\Livewire\Admin\Products\Index as ProductsIndex;
use App\Http\Livewire\Admin\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {

        // Dashboard - bisa diakses semua role
        Route::get('/', Dashboard::class)->name('dashboard');

        // Orders - hanya dev & admin
        Route::middleware('admin.role:dev,admin')->group(function () {
            Route::get('/users', UsersIndex::class)->name('users');
            Route::get('/orders', Orders::class)->name('orders');
            Route::get('/curhats', CurhatsIndex::class)->name('curhats');
            Route::get('/products', ProductsIndex::class)->name('products');
            Route::get('/categories', Categories::class)->name('categories');
            Route::get('/payment-methods', PaymentMethods::class)->name('payment-methods');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

});
