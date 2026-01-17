<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        Role::insert([
            [
                'role_name' => 'admin',
                'description' => 'Administrator sistem',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_name' => 'buyer',
                'description' => 'Pembeli produk',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_name' => 'seller',
                'description' => 'Penjual produk',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_name' => 'courier',
                'description' => 'Kurir pengiriman',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
