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

        // Generate QR Code containing Order ID or specific URL
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($order->id);

        return view('buyer.orders.show', compact('order', 'qrCode'));
    }

    /**
     * Proses checkout
     */
    public function store(StoreOrderRequest $request)
    {
        $buyerId = auth()->id();

        DB::transaction(function () use ($request, $buyerId) {
            
            // 1. Ambil semua product ID dari request
            $productIds = collect($request->items)->pluck('product_id');
            
            // 2. Ambil data produk sekaligus seller_id
            $products = Product::whereIn('id', $productIds)->get();

            // 3. Grouping items berdasarkan seller_id
            // Map request items ke model Product
            $itemsWithProduct = collect($request->items)->map(function ($item) use ($products) {
                $product = $products->firstWhere('id', $item['product_id']);
                return [
                    'product'  => $product,
                    'quantity' => $item['quantity'],
                    'seller_id'=> $product->seller_id
                ];
            });

            // Group by seller_id
            $groupedItems = $itemsWithProduct->groupBy('seller_id');

            foreach ($groupedItems as $sellerId => $items) {
                $totalPerOrder = 0;

                // Buat Order per Seller
                $order = Order::create([
                    'buyer_id'    => $buyerId,
                    'seller_id'   => $sellerId, // Added seller_id
                    'order_date'  => now(),
                    'total_price' => 0, // diupdate nanti
                    'status'      => 'pending',
                ]);

                foreach ($items as $item) {
                    $product = $item['product'];
                    $qty     = $item['quantity'];

                    // Lock & Check Stock
                    // Note: Idealnya lock dilakukan saat query awal, tp utk simplifikasi kita cek di sini
                    // Atau gunakan lockForUpdate di query $products (tapi butuh logic tambahan)
                    // Kita pakai simple check dulu:
                    if ($product->stock < $qty) {
                        abort(400, "Stok produk {$product->product_name} tidak cukup");
                    }

                    $subtotal = $product->price * $qty;
                    $totalPerOrder += $subtotal;

                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $qty,
                        'price'      => $product->price,
                        'subtotal'   => $subtotal,
                    ]);

                    $product->decrement('stock', $qty);
                }

                // Update total price order ini
                $order->update(['total_price' => $totalPerOrder]);

                // Buat Payment per Order (Asumsi bayar masing-masing / gabungan logic dibalikin ke user nanti)
                Payment::create([
                    'order_id'       => $order->id,
                    'payment_method' => 'qr', // Default sementara
                    'payment_status' => 'pending',
                    'payment_qr'     => null,
                ]);
            }
        });

        return redirect()
            ->route('buyer.dashboard')
            ->with('success', 'Pesanan berhasil dibuat, silakan lakukan pembayaran');
    }
}
