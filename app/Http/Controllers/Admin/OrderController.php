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
        $order->load(['buyer', 'seller', 'courier', 'details.product', 'payment']);
        
        // Get all couriers for assignment dropdown
        $couriers = User::whereHas('role', function($q) {
            $q->where('role_name', 'courier');
        })->get();

        return view('admin.orders.show', compact('order', 'couriers'));
    }

    /**
     * Update status order & Auto-assign courier
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,shipped,completed,cancelled'
        ]);

        $newStatus = $request->status;

        // If confirming order, auto-assign available courier
        if ($newStatus === 'confirmed' && !$order->courier_id) {
            // Find courier with no active deliveries (not having orders with status 'shipped')
            $availableCourier = User::whereHas('role', function($q) {
                $q->where('role_name', 'courier');
            })
            ->whereDoesntHave('courierOrders', function($q) {
                $q->where('status', 'shipped');
            })
            ->first();

            if (!$availableCourier) {
                return back()->with('error', 'Tidak ada kurir yang tersedia saat ini!');
            }

            // If COD, courier advances payment to seller
            if ($order->payment_method === 'cod') {
                $seller = User::findOrFail($order->seller_id);
                
                // Courier advances payment to seller (balance can go negative)
                $availableCourier->decrement('balance', $order->total_price);
                $seller->increment('balance', $order->total_price);
            }

            // Assign courier
            $order->courier_id = $availableCourier->id;
            $order->status = 'confirmed'; // Seller will mark as 'shipped' when handing over to courier
            $order->save();

            return redirect()
                ->back()
                ->with('success', 'Order dikonfirmasi dan kurir ' . $availableCourier->name . ' berhasil ditugaskan! Menunggu penjual menyerahkan barang ke kurir.');
        }

        $order->update([
            'status' => $newStatus
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
        'courier_id' => 'required|exists:users,id',
    ]);

    // Verify the selected user is actually a courier
    $courier = User::findOrFail($request->courier_id);
    if ($courier->role->role_name !== 'courier') {
        return back()->with('error', 'User yang dipilih bukan kurir!');
    }

    if ($order->status !== 'pending') {
        return back()->with('error', 'Order harus berstatus pending untuk assign kurir!');
    }

    // If COD, courier advances payment to seller
    if ($order->payment_method === 'cod') {
        $seller = User::findOrFail($order->seller_id);
        
        // Courier advances payment to seller (balance can go negative)
        $courier->decrement('balance', $order->total_price);
        $seller->increment('balance', $order->total_price);
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
