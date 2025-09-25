<?php

// database/seeders/OrderDemoSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderDemoSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory()->count(10)->create()->each(function ($order) {
            $lines = rand(2, 6);
            $subtotal = 0;

            for ($i=0; $i<$lines; $i++) {
                $qty = rand(1,5);
                $price = rand(1000, 5000) / 100;
                $lineTotal = $qty * $price;
                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'sku'      => 'SKU-'.rand(1000,9999),
                    'name'     => 'Demo Product '.rand(1,99),
                    'qty'      => $qty,
                    'price'    => $price,
                    'total'    => $lineTotal,
                ]);
            }

            // pretend tax is 8%
            $order->update([
                'total' => round($subtotal * 1.08, 2),
            ]);
        });
    }
}
