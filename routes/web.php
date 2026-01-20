
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    // If user is logged in, redirect to their role dashboard
    if (Auth::check()) {
        $roleName = Auth::user()->role->role_name;
        return redirect("/$roleName");
    }
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

// Profile Routes (all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/explore', [App\Http\Controllers\Public\ExploreController::class, 'index'])->name('explore');
Route::get('/products/{product}', [App\Http\Controllers\Public\ProductController::class, 'show'])->name('products.show');

Route::get('/auth/{provider}', [\App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [\App\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('social.callback');

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
        Route::post('orders/{order}/handover', [\App\Http\Controllers\Seller\OrderController::class, 'handoverToCourier'])->name('orders.handover');
    });

Route::middleware(['role:buyer'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::get('/', [BuyerDashboard::class, 'index'])->name('dashboard');
        Route::post('/topup', [BuyerDashboard::class, 'topup'])->name('topup');
        
        // Orders
        Route::resource('orders', BuyerOrderController::class);
        Route::post('orders/{order}/pay', [BuyerOrderController::class, 'confirmPayment'])->name('orders.pay');

        // Cart
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    });

Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
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

        // Topups
        Route::get('topups', [\App\Http\Controllers\Admin\TopupController::class, 'index'])->name('topups.index');
        Route::post('topups/{topup}/approve', [\App\Http\Controllers\Admin\TopupController::class, 'approve'])->name('topups.approve');
        Route::post('topups/{topup}/reject', [\App\Http\Controllers\Admin\TopupController::class, 'reject'])->name('topups.reject');
    });

Route::middleware(['role:courier'])
    ->prefix('courier')
    ->name('courier.')
    ->group(function () {
        Route::get('orders', [CourierOrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}/complete', [CourierOrderController::class, 'complete'])->name('orders.complete');
    });

require __DIR__.'/auth.php';
