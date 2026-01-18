<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();
        
        // Total orders for this seller
        $totalOrders = Order::where('seller_id', $sellerId)->count();
        
        // Total revenue for this seller
        $totalRevenue = Order::where('seller_id', $sellerId)
            ->whereIn('status', ['completed', 'shipped', 'confirmed'])
            ->sum('total_price');
        
        // Recent orders (only for this seller)
        $recentOrders = Order::where('seller_id', $sellerId)
            ->with(['buyer'])
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('totalOrders', 'totalRevenue', 'recentOrders'));
    }
}
