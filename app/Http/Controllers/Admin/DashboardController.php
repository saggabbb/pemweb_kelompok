<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats Cards
        $totalOrders = \App\Models\Order::count();
        $completedOrders = \App\Models\Order::whereIn('status', ['completed', 'delivered', 'received'])->count();
        $processingOrders = \App\Models\Order::where('status', 'processing')->count(); // Or 'pending' + 'processing'

        // 2. Recent Transactions (Orders)
        $recentOrders = \App\Models\Order::with('buyer')
            ->latest()
            ->limit(5)
            ->get();

        // 3. Key Metrics (Monthly Sales Chart - Simple implementation)
        // Group by month for the last 6 months
        $monthlySales = \App\Models\Order::selectRaw('SUM(total_price) as total, DATE_FORMAT(created_at, "%Y-%m") as month_year, DATE_FORMAT(created_at, "%b") as month_name')
            ->whereIn('status', ['completed', 'delivered', 'received'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month_year', 'month_name')
            ->orderBy('month_year', 'asc')
            ->get();
            
        return view('admin.dashboard', compact('totalOrders', 'completedOrders', 'processingOrders', 'recentOrders', 'monthlySales'));
    }
}
