<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('courier_id', Auth::id())
            ->with(['buyer', 'details.product', 'payment'])
            ->latest()
            ->get();

        return view('courier.dashboard', compact('orders'));
    }
}
