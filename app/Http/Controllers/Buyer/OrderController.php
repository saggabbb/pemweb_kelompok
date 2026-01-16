<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * List order milik buyer
     */
    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())
            ->with(['details.product', 'payment', 'courier'])
            ->latest()
            ->get();

        return view('buyer.orders.index', compact('orders'));
    }

    /**
     * Detail order milik buyer
     */
    public function show(Order $order)
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['details.product', 'payment', 'courier']);

        return view('buyer.orders.show', compact('order'));
    }

    /**
     * Proses checkout
     */
    public function store(StoreOrderRequest $request)
    {
        $buyerId = auth()->id();

        DB::transaction(function () use ($request, $buyerId) {

            $total = 0;

            $order = Order::create([
                'buyer_id'    => $buyerId,
                'order_date'  => now(),
                'total_price' => 0,
                'status'      => 'pending',
            ]);

            foreach ($request->items as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    abort(400, "Stok produk {$product->product_name} tidak cukup");
                }

                $subtotal = $product->price * $item['quantity'];

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                    'subtotal'   => $subtotal,
                ]);

                $product->decrement('stock', $item['quantity']);
                $total += $subtotal;
            }

            $order->update([
                'total_price' => $total,
            ]);

            Payment::create([
                'order_id'       => $order->id,
                'payment_method' => 'qr',
                'payment_status' => 'pending',
                'payment_qr'     => null,
            ]);
        });

        return redirect()
            ->route('buyer.dashboard')
            ->with('success', 'Pesanan berhasil dibuat, silakan lakukan pembayaran');
    }
}
