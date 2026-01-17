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
        $orders = Order::where('buyer_id', Auth::id())
            ->with(['details.product', 'payment', 'courier'])
            ->latest()
            ->get();

        return view('buyer.dashboard', compact('orders'));
    }
}
