<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Orders;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/orders', Orders::class)->name('orders');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

});
