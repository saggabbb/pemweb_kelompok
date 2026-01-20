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
        
        // Menghitung total belanja hanya dari order yang statusnya 'completed'
        // Cek kembali di database apakah statusnya 'completed' atau 'success'
        $totalSpent = $orders->whereIn('status', ['completed', 'delivered', 'received'])->sum('total_price');

        return view('buyer.dashboard', compact('orders', 'totalOrders', 'totalSpent', 'user'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = Auth::user();
        
        // Create pending topup request
        \App\Models\Topup::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Top-up request submitted! Waiting for admin approval.');
    }
}