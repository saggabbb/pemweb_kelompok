<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $orders = Order::all();

        if ($orders->isEmpty()) {
            return;
        }

        foreach ($orders as $order) {

            $status = collect(['paid', 'pending'])->random();

            Payment::create([
                'order_id'        => $order->id,
                'payment_method'  => collect(['transfer', 'e-wallet', 'cod'])->random(),
                'payment_status'  => $status,
                'payment_qr'      => $status === 'paid'
                                    ? 'qr/payments/order_' . $order->id . '.png'
                                    : null,
                'paid_at'         => $status === 'paid'
                                    ? Carbon::now()->subDays(rand(0, 5))
                                    : null,
            ]);
        }
    }
}
