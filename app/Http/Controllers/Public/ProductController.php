<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product detail page
     */
    public function show(Product $product)
    {
        $product->load(['seller.role', 'category']);
        
        // Get other products from the same seller (related products)
        $relatedProducts = Product::where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        
        return view('public.products.show', compact('product', 'relatedProducts'));
    }
}
