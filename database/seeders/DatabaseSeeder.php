<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            // ProductSeeder::class, // Disabled - using RealisticProductSeeder instead
            // OrderSeeder::class, // Disabled - will be created by users
            // OrderDetailSeeder::class, // Disabled - will be created with orders
            // PaymentSeeder::class, // Disabled - will be created with orders
            RealisticProductSeeder::class, // Use this for realistic data
        ]);
    }
}
