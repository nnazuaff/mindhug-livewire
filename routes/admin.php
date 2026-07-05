<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Livewire\Admin\Curhats;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Orders;
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
            Route::get('/orders', Orders::class)->name('orders');
            Route::get('/curhats', Curhats::class)->name('curhats');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

});
