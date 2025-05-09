<?php

namespace Database\Seeders;

use App\Models\order_items;
use App\Models\orders;
use App\Models\products;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Create 3 users
        $users = User::factory()->count(5)->create([
            'password' => Hash::make('password')
        ]);

        // 2. Create 10 products
        $products = products::factory()->count(15)->create();

        $orderItemCount = 0;
        $maxOrderItems = 30;
        $orders = [];

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();

            $orders[$i] = orders::create([
                'users_id' => $user->id,
                'total_price' => 0,
                'status' => 'pending',
                'created_at' => now(),
            ]);
        }

        // Distribute 20 order_items across the 5 orders
        while ($orderItemCount < $maxOrderItems) {
            foreach ($orders as $order) {
                if ($orderItemCount >= $maxOrderItems) break;

                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price * $quantity;

                order_items::create([
                    'orders_id' => $order->id,
                    'products_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                // Update order's total
                $order->total_price += $price;
                $order->save();

                $orderItemCount++;
            }
        }
    }
}
