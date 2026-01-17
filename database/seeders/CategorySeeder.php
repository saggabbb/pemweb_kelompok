<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $categories = [
            ['category_name' => 'Elektronik', 'description' => 'Peralatan elektronik dan gadget', 'status' => 'active'],
            ['category_name' => 'Fashion', 'description' => 'Pakaian, sepatu, dan aksesori', 'status' => 'active'],
            ['category_name' => 'Kesehatan & Kecantikan', 'description' => 'Produk kesehatan dan perawatan', 'status' => 'active'],
            ['category_name' => 'Rumah Tangga', 'description' => 'Peralatan dan furniture rumah', 'status' => 'active'],
            ['category_name' => 'Olahraga', 'description' => 'Peralatan olahraga dan fitness', 'status' => 'active'],
            ['category_name' => 'Makanan & Minuman', 'description' => 'Makanan, minuman, dan snack', 'status' => 'active'],
            ['category_name' => 'Ibu & Bayi', 'description' => 'Perlengkapan ibu dan bayi', 'status' => 'active'],
            ['category_name' => 'Buku & Alat Tulis', 'description' => 'Buku, majalah, dan alat tulis', 'status' => 'active'],
            ['category_name' => 'Otomotif', 'description' => 'Aksesori kendaraan', 'status' => 'active'],
            ['category_name' => 'Hobi & Koleksi', 'description' => 'Mainan, koleksi, dan hobi', 'status' => 'active'],
        ];

        foreach ($categories as &$category) {
            $category['created_at'] = $now;
            $category['updated_at'] = $now;
        }

        DB::table('categories')->insert($categories);
    }
}
