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
            ->whereIn('status', ['completed', 'shipped', 'confirmed', 'delivered', 'received'])
            ->sum('total_price');
        
        // Recent orders (only for this seller)
        $recentOrders = Order::where('seller_id', $sellerId)
            ->with(['buyer'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly Sales for Chart (Line Chart Data)
        $monthlySales = Order::selectRaw('SUM(total_price) as total, DATE_FORMAT(created_at, "%Y-%m") as month_year, DATE_FORMAT(created_at, "%b") as month_name')
            ->where('seller_id', $sellerId)
            ->whereIn('status', ['completed', 'delivered', 'received'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month_year', 'month_name')
            ->orderBy('month_year', 'asc')
            ->get();

        return view('seller.dashboard', compact('totalOrders', 'totalRevenue', 'recentOrders', 'monthlySales'));
    }
}
