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
        $categoryId = $request->input('category');

        if ($search || $categoryId) {
            // Search or filter mode
            $query = Product::with(['category', 'seller'])
                ->where('status', 'active');

            if ($search) {
                $query->where('product_name', 'like', '%' . $search . '%')
                      ->orWhereHas('category', function($q) use ($search) {
                          $q->where('category_name', 'like', '%' . $search . '%');
                      });
            }

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            $products = $query->paginate(12);
            
            return view('public.explore', [
                'products' => $products,
                'mode' => 'search',
                'search' => $search ?? 'category filter',
                'categories' => Category::withCount('products')->get()
            ]);
        }

        // Browse mode - show categories
        $categories = Category::withCount('products')
            ->with(['products' => function($query) {
                $query->where('status', 'active')->limit(1);
            }])
            ->get();

        return view('public.explore', [
            'categories' => $categories,
            'mode' => 'browse'
        ]);
    }

    /**
     * Index method (alias for __invoke)
     */
    public function index(Request $request)
    {
        return $this->__invoke($request);
    }
}
