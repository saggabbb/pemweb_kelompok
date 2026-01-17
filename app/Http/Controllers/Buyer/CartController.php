<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.seller']) // Eager load seller functionality if needed
            ->get();
            
        // Group items by Seller (since we create 1 order per seller)
        $groupedItems = $cartItems->groupBy(function($item) {
            return $item->product->seller_id;
        });

        return view('buyer.cart.index', compact('cartItems', 'groupedItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
             return back()->with('error', 'Produk tidak mencukupi stok!');
        }

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity)
            ]
        );

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        // Add update logic if needed (qty change)
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }
        $cart->delete();
        return back()->with('success', 'Item dihapus!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,cod',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Group by Seller
        $groupedItems = $cartItems->groupBy(function($item) {
            return $item->product->seller_id;
        });

        DB::transaction(function () use ($groupedItems, $user, $request) {
            
            foreach ($groupedItems as $sellerId => $items) {
                $totalPrice = 0;
                
                // 1. Create Order Skeleton
                $order = Order::create([
                    'buyer_id'       => $user->id,
                    'seller_id'      => $sellerId,
                    'order_date'     => now(),
                    'total_price'    => 0,
                    'status'         => 'pending',
                    'payment_method' => $request->payment_method,
                ]);

                foreach ($items as $item) {
                    $product = $item->product;
                    
                    // Stock Check
                    if ($product->stock < $item->quantity) {
                        throw new \Exception("Stok produk {$product->product_name} habis!");
                    }

                    // Decrement Stock
                    $product->decrement('stock', $item->quantity);

                    // Create Detail
                    $subtotal = $product->price * $item->quantity;
                    $order->details()->create([
                        'product_id' => $product->id,
                        'quantity'   => $item->quantity,
                        'price'      => $product->price,
                        'subtotal'   => $subtotal,
                    ]);

                    $totalPrice += $subtotal;
                }

                // Update Total
                $order->update(['total_price' => $totalPrice]);
            }

            // Clear Cart
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('buyer.orders.index')->with('success', 'Checkout berhasil! Pesanan dibuat.');
    }
}
