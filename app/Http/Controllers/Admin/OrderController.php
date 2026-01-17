<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
     /**
     * Tampilkan daftar semua order
     */
    public function index(Request $request)
    {
        $query = Order::with(['buyer', 'courier', 'payment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('order_date', $request->date);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail satu order
     */
    public function show(Order $order)
    {
        $order->load(['buyer', 'courier', 'details.product', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order (FORM HTML)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status order berhasil diperbarui');
    }

    /**
 * Konfirmasi pembayaran order
 */
    public function confirmPayment(Order $order)
    {
        if (!$order->payment) {
            abort(400, 'Data pembayaran tidak ditemukan');
        }

        if ($order->payment->payment_status !== 'pending') {
            abort(400, 'Pembayaran sudah diproses');
        }

        $order->payment->update([
            'payment_status' => 'paid',
        ]);

        $order->update([
            'status' => 'confirmed',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Pembayaran berhasil dikonfirmasi');
    }

    /**
 * Assign courier ke order
 */
public function assignCourier(Request $request, Order $order)
{
    $request->validate([
        'courier_id' => [
            'required',
            Rule::exists('users', 'id')->where(function ($q) {
                $q->whereHas('role', fn ($r) =>
                    $r->where('role_name', 'courier'));
            }),
        ]
    ]);

    if ($order->status !== 'confirmed') {
        abort(400, 'Order belum dikonfirmasi');
    }

    $order->update([
        'courier_id' => $request->courier_id,
        'status'     => 'shipped',
    ]);

    return redirect()
        ->back()
        ->with('success', 'Kurir berhasil ditugaskan');
}

}
