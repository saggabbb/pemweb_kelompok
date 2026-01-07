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
        $sellerId = Auth::id();

        $orders = Order::whereHas('details.product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })
            ->with([
                'buyer',
                'details.product',
                'payment'
            ])
            ->latest()
            ->get();

        return view('seller.dashboard', compact('orders'));
    }
}
