<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua order buyer ini
        $orders = Order::where('buyer_id', $user->id)
            ->with(['details.product', 'payment', 'courier'])
            ->latest()
            ->get();

        // Hitung Statistik
        $totalOrders = $orders->count();
        
        // Menghitung total belanja hanya dari order yang statusnya 'completed' atau 'success'
        // Sesuaikan 'completed' dengan nama status di database kamu
        $totalSpent = $orders->where('status', 'completed')->sum('total_price');

        return view('buyer.dashboard', compact('orders', 'totalOrders', 'totalSpent', 'user'));
    }
}