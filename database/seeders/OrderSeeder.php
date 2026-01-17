<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $buyers = User::whereHas('role', fn ($q) => $q->where('role_name', 'buyer'))->get();
        $sellers = User::whereHas('role', fn ($q) => $q->where('role_name', 'seller'))->get();
        $couriers = User::whereHas('role', fn ($q) => $q->where('role_name', 'courier'))->get();

        if ($buyers->isEmpty() || $sellers->isEmpty()) {
            return;
        }

        foreach (range(1, 10) as $i) {
            Order::create([
                'buyer_id'   => $buyers->random()->id,
                'seller_id'  => $sellers->random()->id,
                'courier_id' => $couriers->isNotEmpty() ? $couriers->random()->id : null,
                'order_date' => Carbon::now()->subDays(rand(0, 7)),
                'total_price'=> rand(50_000, 1_000_000),
                'status'     => 'pending',
            ]);
        }
    }
}
