<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::where('is_available', true)->get();

        // إنشاء 50 طلب
        for ($i = 0; $i < 50; $i++) {
            // اختيار منتجات عشوائية
            $orderProducts = $products->random(rand(1, 4));
            $totalPrice = 0;
            $productsData = [];

            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;
                $totalPrice += $subtotal;

                $productsData[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ];

                // تحديث عداد الطلبات للمنتج
                $product->increment('order_count', $quantity);
            }

            Order::create([
                'user_id' => $users->random()->id,
                'office_number' => fake()->optional(0.7)->numerify('##'),
                'status' => fake()->randomElement(['pending', 'processed', 'delivered', 'cancelled']),
                'products' => json_encode($productsData),
                'total_price' => $totalPrice,
                'order_time' => fake()->dateTimeBetween('-1 month', 'now'),
                'delivery_time' => fake()->optional(0.5)->dateTimeBetween('now', '+2 hours'),
                'payment_method' => fake()->randomElement(['network', 'bank_transfer', 'cash']),
                'payment_image_url' => fake()->optional(0.3)->imageUrl(400, 300, 'business'),
                'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}
