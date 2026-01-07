<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $orders = \App\Models\Order::with(['buyer','courier','payment'])
        ->latest()
        ->get();

    return view('admin.dashboard', compact('orders'));
}
}
