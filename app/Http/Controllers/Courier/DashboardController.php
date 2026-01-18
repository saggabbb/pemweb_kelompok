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
        $courierId = Auth::id();
        
        // Count pending deliveries (status = 'shipped')
        $pendingDeliveries = Order::where('courier_id', $courierId)
            ->where('status', 'shipped')
            ->count();
        
        // Count completed deliveries (status = 'completed')
        $completedDeliveries = Order::where('courier_id', $courierId)
            ->where('status', 'completed')
            ->count();
        
        // Get active delivery orders
        $orders = Order::where('courier_id', $courierId)
            ->where('status', 'shipped')
            ->with(['buyer', 'seller', 'details.product'])
            ->latest()
            ->get();

        return view('courier.dashboard', compact('orders', 'pendingDeliveries', 'completedDeliveries'));
    }
}
