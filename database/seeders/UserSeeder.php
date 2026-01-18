<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('role_name', 'admin')->first();
        $buyerRole = Role::where('role_name', 'buyer')->first();
        $sellerRole = Role::where('role_name', 'seller')->first();
        $courierRole = Role::where('role_name', 'courier')->first();

        // Admin users (realistic names)
        User::create([
            'name' => 'Admin Belantra',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'balance' => 0,
            'address' => 'Jl. Admin No. 1, Jakarta Pusat',
        ]);

        // Buyer users (realistic Indonesian names)
        $buyers = [
            ['name' => 'Ahmad Yusuf', 'email' => 'ahmad@gmail.com', 'address' => 'Jl. Sudirman No. 123, Jakarta Selatan'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@gmail.com', 'address' => 'Jl. Thamrin No. 45, Jakarta Pusat'],
            ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'address' => 'Jl. Gatot Subroto No. 67, Jakarta Selatan'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@gmail.com', 'address' => 'Jl. Rasuna Said No. 89, Jakarta Selatan'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@gmail.com', 'address' => 'Jl. Kuningan No. 12, Jakarta Selatan'],
        ];

        foreach ($buyers as $buyer) {
            User::create([
                'name' => $buyer['name'],
                'email' => $buyer['email'],
                'password' => Hash::make('password'),
                'role_id' => $buyerRole->id,
                'balance' => rand(1000000, 5000000),
                'address' => $buyer['address'],
            ]);
        }

        // Seller users (realistic store names)
        $sellers = [
            ['name' => 'Toko Elektronik Jaya', 'email' => 'elektronik@belantra.com', 'address' => 'Jl. Mangga Dua No. 123, Jakarta Pusat'],
            ['name' => 'Fashion Store Indo', 'email' => 'fashion@belantra.com', 'address' => 'Jl. Thamrin City No. 45, Jakarta Pusat'],
            ['name' => 'Rumah Furniture', 'email' => 'furniture@belantra.com', 'address' => 'Jl. Pramuka Raya No. 78, Jakarta Timur'],
            ['name' => 'Toko Buku Gramedia', 'email' => 'buku@belantra.com', 'address' => 'Jl. Sudirman No. 56, Jakarta Selatan'],
            ['name' => 'Sport Station', 'email' => 'sport@belantra.com', 'address' => 'Jl. Senayan No. 12, Jakarta Selatan'],
        ];

        foreach ($sellers as $seller) {
            User::create([
                'name' => $seller['name'],
                'email' => $seller['email'],
                'password' => Hash::make('password123'),
                'role_id' => $sellerRole->id,
                'balance' => rand(5000000, 20000000),
                'address' => $seller['address'],
            ]);
        }

        // Courier users (realistic Indonesian names)
        $couriers = [
            ['name' => 'Andi Kurniawan', 'email' => 'andi@courier.com', 'address' => 'Jl. Courier No. 1, Jakarta Timur'],
            ['name' => 'Budi Prasetyo', 'email' => 'budi@courier.com', 'address' => 'Jl. Courier No. 2, Jakarta Barat'],
            ['name' => 'Candra Wijaya', 'email' => 'candra@courier.com', 'address' => 'Jl. Courier No. 3, Jakarta Utara'],
        ];

        foreach ($couriers as $courier) {
            User::create([
                'name' => $courier['name'],
                'email' => $courier['email'],
                'password' => Hash::make('password'),
                'role_id' => $courierRole->id,
                'balance' => rand(500000, 2000000),
                'address' => $courier['address'],
            ]);
        }

        $this->command->info('✅ Realistic users seeded successfully!');
        $this->command->info('👤 Admin: 1');
        $this->command->info('🛍️  Buyers: ' . count($buyers));
        $this->command->info('🏪 Sellers: ' . count($sellers));
        $this->command->info('🚚 Couriers: ' . count($couriers));
    }
}
