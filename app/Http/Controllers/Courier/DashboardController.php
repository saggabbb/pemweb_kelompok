<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Daftar order yang ditugaskan ke courier
     */
    public function index()
    {
        $orders = Order::where('courier_id', Auth::id())
            ->where('status', 'shipped')
            ->with(['buyer', 'seller', 'details.product'])
            ->latest()
            ->get();

        return view('courier.dashboard', compact('orders'));
    }
}
