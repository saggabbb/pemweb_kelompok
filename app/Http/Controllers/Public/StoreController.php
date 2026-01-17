<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display store profile and product catalog
     */
    public function show(User $seller)
    {
        // Ensure the user is actually a seller
        if ($seller->role->role_name !== 'seller') {
            abort(404, 'Store not found');
        }
        
        // Get all products from this seller with pagination
        $products = Product::where('seller_id', $seller->id)
            ->with('category')
            ->paginate(12);
        
        return view('public.store.show', compact('seller', 'products'));
    }
}
