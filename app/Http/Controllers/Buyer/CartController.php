<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.seller']) 
            ->get();
            
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
             return back()->with('error', 'Stok produk tidak mencukupi!');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
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
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product.seller')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            // Kelompokkan belanjaan per Penjual
            $ordersBySeller = $cartItems->groupBy('product.seller_id');

            foreach ($ordersBySeller as $sellerId => $items) {
                $totalPrice = $items->sum(fn($item) => $item->product->price * $item->quantity);
                $shippingFee = 10000; 
                $grandTotal = $totalPrice + $shippingFee;

                // --- 1. SKIP POTONG SALDO (Pindah ke Confirm Payment) ---
                // Balance check moved to OrderController::confirmPayment
                
                // --- 2. SKIP TAMBAH SALDO SELLER ---
                // Moved to OrderController::confirmPayment

                // --- 3. SIMPAN DATA ORDER ---
                $order = Order::create([
                    'buyer_id'       => $user->id, // Ganti dari user_id ke buyer_id
                    'seller_id'      => $sellerId,
                    'total_price'    => $grandTotal,
                    'payment_method' => $request->payment_method ?? 'transfer',
                    'status'         => 'pending', // Status awal pending sampai dikonfirmasi
                    'order_date'     => now(), // Tambahkan ini untuk mengisi order_date
                ]);
                
                // --- 4. SIMPAN DETAIL & KURANGI STOK ---
                foreach ($items as $item) {
                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'price'      => $item->product->price,
                        'subtotal'   => $item->quantity * $item->product->price,
                    ]);

                    // Stok 52 jadi 50
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();

            DB::commit();
            return redirect()->route('buyer.dashboard')->with('success', 'Checkout Berhasil! Saldo Rp 5jt Anda telah terpotong.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('buyer.cart.index')->with('error', $e->getMessage());
        }
    }
}