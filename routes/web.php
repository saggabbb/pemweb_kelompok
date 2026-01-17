
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboard;
use App\Http\Controllers\Courier\DashboardController as CourierDashboard;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Buyer\ProductController as BuyerProductController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\Courier\OrderController as CourierOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    return 'Home';
});

Route::get('/auth/{provider}', [\App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [\App\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('social.callback');

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
        Route::resource('orders', \App\Http\Controllers\Seller\OrderController::class)->only(['index', 'show', 'update']);
    });

Route::middleware(['role:buyer'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::post('orders', [BuyerOrderController::class, 'store']);
        Route::get('orders', [BuyerOrderController::class, 'index']);
        Route::get('orders/{order}', [BuyerOrderController::class, 'show']);
    });

Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.update-status');

        Route::post('orders/{order}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])
            ->name('orders.confirm-payment');

        Route::post('orders/{order}/assign-courier', [AdminOrderController::class, 'assignCourier'])
            ->name('orders.assign-courier');
    });

Route::middleware(['role:courier'])
    ->prefix('courier')
    ->name('courier.')
    ->group(function () {
        Route::get('orders', [CourierOrderController::class, 'index']);
        Route::post('orders/{order}/complete', [CourierOrderController::class, 'complete']);
    });
