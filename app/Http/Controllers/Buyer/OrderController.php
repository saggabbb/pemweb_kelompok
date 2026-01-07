<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Request\Buyer\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request)
    {
        $buyerId = auth()->id();

        return DB::transaction(function () use ($request, $buyerId) {

            $total = 0;

            // 1. Buat order
            $order = Order::create([
                'buyer_id'    => $buyerId,
                'order_date'  => now(),
                'total_price' => 0,
                'status'      => 'pending',
            ]);

            // 2. Loop item
            foreach ($request->items as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    abort(400, "Stok produk {$product->product_name} tidak cukup");
                }

                $subtotal = $product->price * $item['quantity'];

                OrderDetail::create([
                    'order_id'  => $order->id,
                    'product_id'=> $product->id,
                    'quantity'  => $item['quantity'],
                    'price'     => $product->price,
                    'subtotal'  => $subtotal,
                ]);

                // kurangi stok
                $product->decrement('stock', $item['quantity']);

                $total += $subtotal;
            }

            // 3. Update total harga
            $order->update([
                'total_price' => $total,
            ]);

            return response()->json([
                'message' => 'Order berhasil dibuat',
                'order'   => $order->load('details.product'),
            ], 201);
        });
    }
}
