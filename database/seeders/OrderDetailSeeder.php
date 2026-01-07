<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        if ($orders->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($orders as $order) {
            $total = 0;

            $items = $products->random(rand(1, 3));

            foreach ($items as $product) {
                $qty = rand(1, 5);
                $subtotal = $product->price * $qty;

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->price,
                    'subtotal'   => $subtotal,
                ]);

                $total += $subtotal;
            }

            // update total harga order dari detail
            $order->update([
                'total_price' => $total,
            ]);
        }
    }
}
