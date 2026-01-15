<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Seller\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
     $products = Product::where('seller_id', auth()->id())
        ->latest()
        ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        // Pastikan produk milik seller yang login
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validated();

        // Kalau upload gambar baru
        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return redirect()
         ->route('seller.products.index')
    ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
        ->route('seller.products.index')
        ->with('success', 'Produk berhasil dihapus');
    }
}
