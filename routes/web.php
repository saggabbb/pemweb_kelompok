
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
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $role = auth()->user()->role->role_name;

    return match ($role) {
        'admin' => redirect('/admin'),
        'seller' => redirect('/seller'),
        'buyer' => redirect('/buyer'),
        'courier' => redirect('/courier'),
        default => redirect('/'),
    };
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->get('/explore', \App\Http\Controllers\Public\ExploreController::class)->name('explore');

Route::get('/auth/{provider}', [\App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [\App\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('social.callback');

Route::middleware(['role:admin'])
    ->get('/admin', [AdminDashboard::class, 'index'])
    ->name('admin.dashboard');

Route::middleware(['role:seller'])
    ->get('/seller', [SellerDashboard::class, 'index'])
    ->name('seller.dashboard');

Route::middleware(['role:buyer'])
    ->get('/buyer', [BuyerDashboard::class, 'index'])
    ->name('buyer.dashboard');

Route::middleware(['role:courier'])
    ->get('/courier', [CourierDashboard::class, 'index'])
    ->name('courier.dashboard');

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
        Route::get('/', [BuyerDashboard::class, 'index'])->name('dashboard');
        
        // Orders
        Route::resource('orders', BuyerOrderController::class);

        // Cart
        Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    });

Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Orders
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

        // Categories (CRUD with Modal)
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show', 'create', 'edit']); 
        // Note: create/edit are handled via modal in index, so we strictly don't need separate routes for them, 
        // but 'resource' creates them anyway. We can except them to keep it clean.
        
        // Users (Full CRUD)
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });

Route::middleware(['role:courier'])
    ->prefix('courier')
    ->name('courier.')
    ->group(function () {
        Route::get('orders', [CourierOrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}/complete', [CourierOrderController::class, 'complete'])->name('orders.complete');
    });

require __DIR__.'/auth.php';
