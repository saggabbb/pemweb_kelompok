<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Seller\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan semua produk milik seller
     */
    public function index()
    {
        $products = Product::where('seller_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::all();

        return view('seller.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $data['seller_id'] = auth()->id();
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Manual storage to bypass "Path cannot be empty" error on Windows/Temp
            $filename = $file->hashName();
            try {
                // Try standard store first (it might work on other envs)
                $data['image'] = $file->store('products', 'public');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Image Store Standard Failed, trying fallback: ' . $e->getMessage());
                
                if ($file->isValid()) {
                    $path = 'products/' . $filename;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($file->getPathname()));
                    $data['image'] = $path;
                } else {
                    throw $e;
                }
            }
        }

        Product::create($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form edit produk
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update produk
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorizeProduct($product);

        $data = $request->validated();

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

    /**
     * Hapus produk
     */
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Helper authorization
     */
    private function authorizeProduct(Product $product)
    {
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }
    }
}
