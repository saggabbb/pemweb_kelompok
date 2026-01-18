<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
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

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Already in cart, increment quantity
            $cartItem->increment('quantity', $request->quantity);
        } else {
            // New item, create with specified quantity
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

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
        $cartItems = Cart::where('user_id', $user->id)->with('product.seller')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            // Group cart items by seller
            $ordersBySeller = $cartItems->groupBy('product.seller_id');

            foreach ($ordersBySeller as $sellerId => $items) {
                $totalPrice = $items->sum(fn($item) => $item->product->price * $item->quantity);
                $shippingFee = 10000; // Flat shipping fee
                $seller = $items->first()->product->seller;

                // Create order for this seller
                $order = Order::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $sellerId,
                    'courier_id' => null, // Will be assigned by admin later
                    'order_date' => now(),
                    'total_price' => $totalPrice,
                    'shipping_fee' => $shippingFee,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                ]);

                // Create order details
                foreach ($items as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);

                    // Reduce stock
                    $item->product->decrement('stock', $item->quantity);
                }

                // Handle balance transactions
                if ($request->payment_method === 'transfer') {
                    // Check buyer balance
                    if ($user->balance < $totalPrice + $shippingFee) {
                        throw new \Exception('Saldo tidak cukup! Saldo Anda: Rp ' . number_format($user->balance, 0, ',', '.') . ', Total: Rp ' . number_format($totalPrice + $shippingFee, 0, ',', '.'));
                    }

                    // Transfer: Buyer balance → Seller balance
                    $user->decrement('balance', $totalPrice + $shippingFee);
                    $seller->increment('balance', $totalPrice + $shippingFee);
                    
                } elseif ($request->payment_method === 'cod') {
                    // COD: Courier will advance payment to seller when assigned by admin
                    // Balance transaction happens in Admin\OrderController@assignCourier
                }
            }

            // Clear Cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('buyer.orders.index')->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
