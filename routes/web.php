<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboard;
use App\Http\Controllers\Courier\DashboardController as CourierDashboard;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Buyer\ProductController as BuyerProductController;

Route::get('/', function () {
    return 'Home';
});

Route::middleware(['role:admin'])
    ->get('/admin', [AdminDashboard::class, 'index']);

Route::middleware(['role:seller'])
    ->get('/seller', [SellerDashboard::class, 'index']);

Route::middleware(['role:buyer'])
    ->get('/buyer', [BuyerDashboard::class, 'index']);

Route::middleware(['role:courier'])
    ->get('/courier', [CourierDashboard::class, 'index']);

Route::middleware(['role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::resource('products', ProductController::class);
    });

    Route::middleware(['role:buyer'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::get('products', [BuyerProductController::class, 'index']);
        Route::get('products/{product}', [BuyerProductController::class, 'show']);
    });
