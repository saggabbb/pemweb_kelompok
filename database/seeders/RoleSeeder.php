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
        Role::insert([
            [
                'role_name' => 'admin',
                'description' => 'Administrator sistem'
            ],
            [
                'role_name' => 'seller',
                'description' => 'Penjual produk'
            ],
            [
                'role_name' => 'buyer',
                'description' => 'Pembeli produk'
            ],
            [
                'role_name' => 'courier',
                'description' => 'Kurir pengiriman'
            ],
        ]);
    }
}
