<?php

namespace Database\Seeders;

use App\Models\user;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'role_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'balance' => 10000000, // Rp 10 juta
            'address' => 'Jl. Admin No. 1, Jakarta Pusat',
        ]);

        User::create([
            'role_id' => 3, // buyer
            'name' => 'Seller One',
            'email' => 'seller1@mail.com',
            'password' => Hash::make('password'),
            'balance' => 2000000, // Rp 2 juta
            'address' => 'Jl. Seller Satu No. 10, Bandung',
        ]);

        User::create([
            'role_id' => 3, // seller
            'name' => 'Seller Two',
            'email' => 'seller2@mail.com',
            'password' => Hash::make('password'),
            'balance' => 2000000,
            'address' => 'Jl. Seller Dua No. 20, Surabaya',
        ]);

        User::create([
            'role_id' => 2, // buyer
            'name' => 'Buyer One',
            'email' => 'buyer1@mail.com',
            'password' => Hash::make('password'),
            'balance' => 5000000, // Rp 5 juta
            'address' => 'Jl. Buyer Satu No. 5, Jakarta Selatan',
        ]);

        User::create([
            'role_id' => 2, // buyer
            'name' => 'Buyer Two',
            'email' => 'buyer2@mail.com',
            'password' => Hash::make('password'),
            'balance' => 5000000,
            'address' => 'Jl. Buyer Dua No. 15, Tangerang',
        ]);

        User::create([
            'role_id' => 4, // courier
            'name' => 'Courier',
            'email' => 'courier@mail.com',
            'password' => Hash::make('password'),
            'balance' => 500000, // Rp 500 ribu
            'address' => 'Jl. Courier No. 99, Depok',
        ]);
    }
}
