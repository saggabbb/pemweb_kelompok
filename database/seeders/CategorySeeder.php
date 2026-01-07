<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Category::insert([
            [
                'category_name' => 'Elektronik',
                'description' => 'Produk elektronik',
                'status' => 'active',
            ],
            [
                'category_name' => 'Fashion',
                'description' => 'Produk fashion',
                'status' => 'active',
            ],
            [
                'category_name' => 'Makanan',
                'description' => 'Produk makanan',
                'status' => 'active',
            ],
            [
                'category_name' => 'Kesehatan',
                'description' => 'Produk kesehatan',
                'status' => 'active',
            ],
            [
                'category_name' => 'Olahraga',
                'description' => 'Produk olahraga',
                'status' => 'active',
            ],
        ]);
    }
}
