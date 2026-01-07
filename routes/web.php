<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return 'Home';
});

Route::middleware(['role:admin'])
    ->get('/admin', [DashboardController::class, 'index']);

Route::middleware(['role:seller'])->get('/seller', function () {
    return 'Seller OK';
});

Route::middleware(['role:buyer'])->get('/buyer', function () {
    return 'Buyer OK';
});

Route::middleware(['role:courier'])->get('/courier', function () {
    return 'Courier OK';
});
