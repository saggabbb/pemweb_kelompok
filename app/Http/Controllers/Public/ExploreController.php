<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            // Logic SEARCH: Tampilkan Produk relevan
            $products = Product::where('product_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->with(['seller', 'category'])
                ->latest()
                ->paginate(12)
                ->withQueryString();

            return view('public.explore', [
                'mode' => 'search',
                'products' => $products,
                'search' => $search
            ]);
        } else {
            // Logic DEFAULT: Tampilkan Kategori dengan gambar sampul random dari produknya
            $categories = Category::whereHas('products')
                ->with(['products' => function($q) {
                    $q->inRandomOrder()->limit(1); // Ambil 1 produk acak utk cover
                }])
                ->get();

            return view('public.explore', [
                'mode' => 'categories',
                'categories' => $categories
            ]);
        }
    }
}
