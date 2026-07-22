<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Livewire\Admin\Admins\Index as AdminsIndex;
use App\Http\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Http\Livewire\Admin\Curhats\Index as CurhatsIndex;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\IncomeExpenses\Index as IncomeExpensesIndex;
use App\Http\Livewire\Admin\Orders;
use App\Http\Livewire\Admin\Products\Index as ProductsIndex;
use App\Http\Livewire\Admin\Promotions\Index as PromotionsIndex;
use App\Http\Livewire\Admin\SubscriptionOrders\Index as SubscriptionOrdersIndex;
use App\Http\Livewire\Admin\SubscriptionPlans\Index as SubscriptionPlansIndex;
use App\Http\Livewire\Admin\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'admin.session'])->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');

        Route::middleware('admin.role:dev')->group(function () {
            Route::get('/admins', AdminsIndex::class)->name('admins');
        });

        Route::middleware('admin.role:dev,admin')->group(function () {
            Route::get('/users', UsersIndex::class)->name('users');
            Route::get('/orders', Orders::class)->name('orders');
            Route::get('/curhats', CurhatsIndex::class)->name('curhats');
            Route::get('/products', ProductsIndex::class)->name('products');
            Route::get('/income-expenses', IncomeExpensesIndex::class)->name('income-expenses');
            Route::get('/categories', CategoriesIndex::class)->name('categories');
            Route::get('/promotions', PromotionsIndex::class)->name('promotions');
            Route::get('/subscription-orders', SubscriptionOrdersIndex::class)->name('subscription-orders');
            Route::get('/subscription-plans', SubscriptionPlansIndex::class)->name('subscription-plans');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
