<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
     public function index()
    {
        $products = Product::where('status', 'active')
            ->with(['category', 'seller'])
            ->latest()
            ->get();

        return response()->json($products);
    }

    public function show(Product $product)
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        return response()->json(
            $product->load(['category', 'seller'])
        );
    }
}
