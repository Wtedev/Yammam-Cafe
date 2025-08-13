<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // مشروبات ساخنة
            [
                'name' => 'قهوة عربية',
                'slug' => 'arabic-coffee',
                'description' => 'قهوة عربية أصيلة بطعم مميز',
                'price' => 15.00,
                'category' => 'مشروبات ساخنة',
                'type' => 'fixed',
                'calories' => 50,
                'walking_time' => 5,
                'stock_quantity' => 100,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'شاي أحمر',
                'slug' => 'red-tea',
                'description' => 'شاي أحمر طازج ومنعش',
                'price' => 8.00,
                'category' => 'مشروبات ساخنة',
                'type' => 'fixed',
                'calories' => 30,
                'walking_time' => 3,
                'stock_quantity' => 150,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'كابتشينو',
                'slug' => 'cappuccino',
                'description' => 'كابتشينو إيطالي كلاسيكي',
                'price' => 18.00,
                'category' => 'مشروبات ساخنة',
                'type' => 'fixed',
                'calories' => 120,
                'walking_time' => 8,
                'stock_quantity' => 80,
                'is_available' => true,
                'is_featured' => true,
            ],

            // مشروبات باردة
            [
                'name' => 'عصير برتقال طبيعي',
                'slug' => 'natural-orange-juice',
                'description' => 'عصير برتقال طازج 100%',
                'price' => 12.00,
                'category' => 'مشروبات باردة',
                'type' => 'fixed',
                'calories' => 80,
                'walking_time' => 5,
                'stock_quantity' => 50,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'آيس كوفي',
                'slug' => 'iced-coffee',
                'description' => 'قهوة مثلجة منعشة',
                'price' => 20.00,
                'category' => 'مشروبات باردة',
                'type' => 'fixed',
                'calories' => 100,
                'walking_time' => 10,
                'stock_quantity' => 60,
                'is_available' => true,
                'is_featured' => true,
            ],

            // وجبات خفيفة
            [
                'name' => 'ساندويش جبن',
                'slug' => 'cheese-sandwich',
                'description' => 'ساندويش جبن مشوي لذيذ',
                'price' => 25.00,
                'category' => 'وجبات خفيفة',
                'type' => 'fixed',
                'calories' => 300,
                'walking_time' => 15,
                'stock_quantity' => 30,
                'is_available' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'كروسان بالشوكولاتة',
                'slug' => 'chocolate-croissant',
                'description' => 'كروسان طازج محشو بالشوكولاتة',
                'price' => 22.00,
                'category' => 'وجبات خفيفة',
                'type' => 'fixed',
                'calories' => 250,
                'walking_time' => 10,
                'stock_quantity' => 40,
                'is_available' => true,
                'is_featured' => true,
            ],

            // حلويات
            [
                'name' => 'كيك الشوكولاتة',
                'slug' => 'chocolate-cake',
                'description' => 'قطعة كيك شوكولاتة غنية ولذيذة',
                'price' => 28.00,
                'category' => 'حلويات',
                'type' => 'fixed',
                'calories' => 400,
                'walking_time' => 5,
                'stock_quantity' => 20,
                'is_available' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'تشيز كيك',
                'slug' => 'cheesecake',
                'description' => 'تشيز كيك كريمي بطعم الفانيليا',
                'price' => 32.00,
                'category' => 'حلويات',
                'type' => 'weekly',
                'calories' => 350,
                'walking_time' => 5,
                'stock_quantity' => 15,
                'is_available' => true,
                'is_featured' => false,
            ],

            // منتج نفدت كميته للاختبار
            [
                'name' => 'قهوة مختصة',
                'slug' => 'specialty-coffee',
                'description' => 'قهوة مختصة من أجود أنواع البن',
                'price' => 35.00,
                'category' => 'مشروبات ساخنة',
                'type' => 'fixed',
                'calories' => 60,
                'walking_time' => 12,
                'stock_quantity' => 0, // نفدت الكمية
                'is_available' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
