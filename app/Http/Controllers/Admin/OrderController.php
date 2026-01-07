<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // list semua order
    }

    public function show(Order $order)
    {
        // detail order
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status order berhasil diperbarui'
        ]);
    }
}
