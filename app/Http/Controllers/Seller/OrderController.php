<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Tampilkan semua order masuk untuk seller ini
     */
    public function index()
    {
        $sellerId = auth()->id();

        $orders = Order::where('seller_id', $sellerId)
            ->with(['buyer', 'details.product', 'payment'])
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Seller confirms handover to courier
     */
    public function handoverToCourier(Order $order)
    {
        // Verify this is seller's order
        if ($order->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Must be confirmed and have courier assigned
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Order harus berstatus confirmed!');
        }

        if (!$order->courier_id) {
            return back()->with('error', 'Kurir belum ditugaskan!');
        }

        // Mark as shipped (handed over to courier)
        $order->update(['status' => 'shipped']);

        return back()->with('success', 'Barang berhasil diserahkan ke kurir!');
    }
    /**
     * Tampilkan detail order
     */
    public function show(Order $order)
    {
        // Pastikan order ini milik seller yang sedang login
        if ($order->seller_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['buyer', 'details.product', 'payment', 'courier']);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Update status order (Pending -> Processing -> Shipped)
     */
    public function update(Request $request, Order $order)
    {
        if ($order->seller_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:processing,shipped,cancelled',
        ]);

        // If cancelling, delete order and rollback balance
        if ($request->status === 'cancelled') {
            return $this->cancelAndDelete($order);
        }

        $order->status = $request->status;
        $order->save();

        return redirect()
            ->route('seller.orders.show', $order)
            ->with('success', 'Status order berhasil diperbarui');
    }

    /**
     * Cancel order and delete it, rollback balance if needed
     */
    private function cancelAndDelete(Order $order)
    {
        // Rollback balance if transfer payment already processed
        if ($order->payment_method === 'transfer') {
            $buyer = $order->buyer;
            $seller = $order->seller;
            
            // Return money to buyer, deduct from seller
            $buyer->increment('balance', $order->total_price);
            $seller->decrement('balance', $order->total_price);
        }
        
        // Rollback balance if COD and courier already advanced payment
        if ($order->payment_method === 'cod' && $order->courier_id) {
            $courier = $order->courier;
            $seller = $order->seller;
            
            // Return money to courier, deduct from seller
            $courier->increment('balance', $order->total_price);
            $seller->decrement('balance', $order->total_price);
        }

        // Restore product stock
        foreach ($order->details as $detail) {
            if ($detail->product) {
                $detail->product->increment('stock', $detail->quantity);
            }
        }

        // Delete order details first (foreign key)
        $order->details()->delete();
        
        // Delete order
        $order->delete();

        return redirect()
            ->route('seller.orders.index')
            ->with('success', 'Order berhasil dibatalkan dan dihapus!');
    }
}
