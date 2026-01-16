<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Daftar order yang ditugaskan ke courier
     */
    public function index()
    {
        $orders = Order::where('courier_id', Auth::id())
            ->where('status', 'shipped')
            ->with(['buyer', 'details.product'])
            ->latest()
            ->get();

        return view('courier.orders.index', compact('orders'));
    }

    /**
     * Konfirmasi order selesai
     */
    public function complete(Order $order)
    {
        if ($order->courier_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'shipped') {
            abort(400, 'Order belum dikirim');
        }

        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Order berhasil diselesaikan');
    }
}
