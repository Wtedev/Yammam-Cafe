<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        // طلبات جديدة (غير مفتوحة) لاختبار النظام
        $newOrders = [
            [
                'user_id' => $users->random()->id,
                'office_number' => 'B101',
                'status' => 'pending',
                'products' => [
                    [
                        'id' => $products->random()->id,
                        'name' => 'قهوة عربية',
                        'price' => 15.00,
                        'quantity' => 2,
                    ],
                    [
                        'id' => $products->random()->id,
                        'name' => 'كروسان بالشوكولاتة',
                        'price' => 22.00,
                        'quantity' => 1,
                    ]
                ],
                'total_price' => 52.00,
                'order_time' => now()->subMinutes(10),
                'delivery_time' => null,
                'payment_method' => 'network',
                'payment_image_url' => null,
                'first_viewed_at' => null, // طلب جديد
                'first_viewed_by' => null,
                'created_at' => now()->subMinutes(10),
            ],
            [
                'user_id' => $users->random()->id,
                'office_number' => 'C202',
                'status' => 'pending',
                'products' => [
                    [
                        'id' => $products->random()->id,
                        'name' => 'كابتشينو',
                        'price' => 18.00,
                        'quantity' => 1,
                    ],
                    [
                        'id' => $products->random()->id,
                        'name' => 'كيك الشوكولاتة',
                        'price' => 28.00,
                        'quantity' => 1,
                    ]
                ],
                'total_price' => 46.00,
                'order_time' => now()->subMinutes(25),
                'delivery_time' => null,
                'payment_method' => 'bank_transfer',
                'payment_image_url' => 'transfers/transfer_001.jpg',
                'first_viewed_at' => null, // طلب جديد
                'first_viewed_by' => null,
                'created_at' => now()->subMinutes(25),
            ],
            [
                'user_id' => $users->random()->id,
                'office_number' => 'B102',
                'status' => 'pending',
                'products' => [
                    [
                        'id' => $products->random()->id,
                        'name' => 'آيس كوفي',
                        'price' => 20.00,
                        'quantity' => 2,
                    ]
                ],
                'total_price' => 40.00,
                'order_time' => now()->subHour(),
                'delivery_time' => null,
                'payment_method' => 'cash',
                'payment_image_url' => null,
                'first_viewed_at' => null, // طلب جديد
                'first_viewed_by' => null,
                'created_at' => now()->subHour(),
            ],
        ];

        // طلبات قديمة (تم فتحها من قبل) لاختبار التباين
        $viewedOrders = [
            [
                'user_id' => $users->random()->id,
                'office_number' => 'C201',
                'status' => 'processed',
                'products' => [
                    [
                        'id' => $products->random()->id,
                        'name' => 'عصير برتقال طبيعي',
                        'price' => 12.00,
                        'quantity' => 1,
                    ],
                    [
                        'id' => $products->random()->id,
                        'name' => 'ساندويش جبن',
                        'price' => 25.00,
                        'quantity' => 1,
                    ]
                ],
                'total_price' => 37.00,
                'order_time' => now()->subHours(2),
                'delivery_time' => now()->addHour(),
                'payment_method' => 'network',
                'payment_image_url' => null,
                'first_viewed_at' => now()->subHours(2)->addMinutes(5), // تم فتحه
                'first_viewed_by' => 1, // الأدمن
                'created_at' => now()->subHours(2),
            ],
            [
                'user_id' => $users->random()->id,
                'office_number' => 'B101',
                'status' => 'delivered',
                'products' => [
                    [
                        'id' => $products->random()->id,
                        'name' => 'شاي أحمر',
                        'price' => 8.00,
                        'quantity' => 3,
                    ]
                ],
                'total_price' => 24.00,
                'order_time' => now()->subHours(4),
                'delivery_time' => now()->subHours(3),
                'payment_method' => 'cash',
                'payment_image_url' => null,
                'first_viewed_at' => now()->subHours(4)->addMinutes(2), // تم فتحه
                'first_viewed_by' => 1, // الأدمن
                'created_at' => now()->subHours(4),
            ],
        ];

        // إدراج الطلبات الجديدة
        foreach ($newOrders as $order) {
            Order::create($order);
        }

        // إدراج الطلبات المفتوحة
        foreach ($viewedOrders as $order) {
            Order::create($order);
        }
    }
}
