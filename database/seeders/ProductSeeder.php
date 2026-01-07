<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categories = Category::all();
        $sellers = User::whereHas('role', fn ($q) => $q->where('role_name', 'seller'))->get();

        if ($categories->isEmpty() || $sellers->isEmpty()) {
            return;
        }

        foreach (range(1, 15) as $i) {
            Product::create([
                'category_id'   => $categories->random()->id,
                'seller_id'     => $sellers->random()->id,
                'product_name'  => "Produk Dummy {$i}",
                'description'   => "Deskripsi produk dummy ke-{$i}",
                'price'         => rand(10_000, 500_000),
                'stock'         => rand(1, 100),
                'status'        => 'active',
            ]);
        }
    }
}
