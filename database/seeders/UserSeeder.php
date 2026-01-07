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
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Seller One',
            'email' => 'seller1@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Seller Two',
            'email' => 'seller2@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 3,
            'name' => 'Buyer One',
            'email' => 'buyer1@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 3,
            'name' => 'Buyer Two',
            'email' => 'buyer2@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 4,
            'name' => 'Courier',
            'email' => 'courier@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
