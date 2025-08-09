<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على الأقسام
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('يجب إنشاء الأقسام أولاً! قم بتشغيل php artisan db:seed --class=CategorySeeder');
            return;
        }

        // تخزين الأقسام في مصفوفة للوصول السريع
        $categoriesMap = [];
        foreach ($categories as $category) {
            $categoriesMap[$category->name] = $category->id;
        }

        // تنظيف المنتجات الموجودة (بدلاً من truncate)
        // لا نستطيع استخدام truncate بسبب وجود علاقات خارجية
        // سنقوم بحذف المنتجات واحدة تلو الأخرى للحفاظ على سلامة البيانات

        // يمكن تعطيل فحص العلاقات الخارجية مؤقتاً
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // مصفوفة المنتجات حسب القسم
        $products = [
            // مشروبات ساخنة
            'مشروبات ساخنة' => [
                [
                    'name' => 'إسبريسو',
                    'description' => 'قهوة إسبريسو قوية ومركزة بنكهة غنية',
                    'price' => 12.00,
                    'type' => 'عادي',
                    'calories' => 5,
                    'walking_time' => 3,
                    'is_featured' => true,
                ],
                [
                    'name' => 'أمريكانو',
                    'description' => 'إسبريسو ممزوج بالماء الساخن',
                    'price' => 15.00,
                    'type' => 'عادي',
                    'calories' => 10,
                    'walking_time' => 5,
                ],
                [
                    'name' => 'كابتشينو',
                    'description' => 'إسبريسو مع الحليب المبخر والرغوة',
                    'price' => 18.00,
                    'type' => 'مميز',
                    'calories' => 120,
                    'walking_time' => 18,
                    'is_featured' => true,
                ],
                [
                    'name' => 'لاتيه',
                    'description' => 'إسبريسو مع الحليب الساخن والقليل من رغوة الحليب',
                    'price' => 18.00,
                    'type' => 'عادي',
                    'calories' => 150,
                    'walking_time' => 22,
                ],
            ],

            // مشروبات باردة
            'مشروبات باردة' => [
                [
                    'name' => 'أيس كوفي',
                    'description' => 'قهوة باردة منعشة مع مكعبات الثلج',
                    'price' => 18.00,
                    'type' => 'صيفي',
                    'calories' => 90,
                    'walking_time' => 15,
                    'is_featured' => true,
                ],
                [
                    'name' => 'فرابتشينو',
                    'description' => 'مشروب قهوة مخلوط بالثلج والكريمة',
                    'price' => 22.00,
                    'type' => 'أسبوعي',
                    'calories' => 230,
                    'walking_time' => 35,
                ],
                [
                    'name' => 'عصير برتقال طازج',
                    'description' => 'عصير برتقال طازج 100%',
                    'price' => 16.00,
                    'type' => 'صحي',
                    'calories' => 120,
                    'walking_time' => 18,
                ],
                [
                    'name' => 'موكا فرابيه',
                    'description' => 'مزيج غني من القهوة والشوكولاتة والحليب المثلج',
                    'price' => 24.00,
                    'type' => 'أسبوعي',
                    'calories' => 320,
                    'walking_time' => 45,
                    'is_featured' => true,
                ],
            ],

            // قهوة مختصة
            'قهوة مختصة' => [
                [
                    'name' => 'فلتر V60',
                    'description' => 'قهوة مفلترة بطريقة V60 لمذاق نقي وصافي',
                    'price' => 20.00,
                    'type' => 'مختص',
                    'calories' => 5,
                    'walking_time' => 3,
                ],
                [
                    'name' => 'قهوة كولد برو',
                    'description' => 'قهوة مخمرة على البارد لمدة 24 ساعة',
                    'price' => 25.00,
                    'type' => 'مختص',
                    'calories' => 15,
                    'walking_time' => 8,
                    'is_featured' => true,
                ],
                [
                    'name' => 'قهوة كمكس',
                    'description' => 'قهوة محضرة بطريقة كمكس للحصول على نكهة متوازنة',
                    'price' => 22.00,
                    'type' => 'مختص',
                    'calories' => 10,
                    'walking_time' => 5,
                ],
            ],

            // مأكولات خفيفة
            'مأكولات خفيفة' => [
                [
                    'name' => 'كرواسون بالجبنة',
                    'description' => 'كرواسون طازج محشو بالجبنة',
                    'price' => 15.00,
                    'type' => 'فطور',
                    'calories' => 320,
                    'walking_time' => 45,
                ],
                [
                    'name' => 'سندويش تونة',
                    'description' => 'سندويش تونة طازج مع الخس والخضروات',
                    'price' => 22.00,
                    'type' => 'غداء',
                    'calories' => 350,
                    'walking_time' => 50,
                    'is_featured' => true,
                ],
                [
                    'name' => 'سلطة سيزر',
                    'description' => 'سلطة سيزر مع الدجاج المشوي وصلصة سيزر المميزة',
                    'price' => 28.00,
                    'type' => 'صحي',
                    'calories' => 280,
                    'walking_time' => 40,
                ],
            ],

            // حلويات
            'حلويات' => [
                [
                    'name' => 'كوكيز شوكولاتة',
                    'description' => 'كوكيز طازج بالشوكولاتة والمكسرات',
                    'price' => 12.00,
                    'type' => 'أسبوعي',
                    'calories' => 230,
                    'walking_time' => 35,
                ],
                [
                    'name' => 'شيز كيك',
                    'description' => 'قطعة شيز كيك كريمية مع صلصة التوت',
                    'price' => 25.00,
                    'type' => 'خاص',
                    'calories' => 400,
                    'walking_time' => 60,
                ],
                [
                    'name' => 'براونيز',
                    'description' => 'براونيز شوكولاتة مع آيس كريم الفانيليا',
                    'price' => 22.00,
                    'type' => 'أسبوعي',
                    'calories' => 450,
                    'walking_time' => 65,
                    'is_featured' => true,
                ],
            ],

            // مثلجات
            'مثلجات' => [
                [
                    'name' => 'آيس كريم فانيليا',
                    'description' => 'آيس كريم فانيليا كلاسيكي',
                    'price' => 15.00,
                    'type' => 'عادي',
                    'calories' => 200,
                    'walking_time' => 30,
                ],
                [
                    'name' => 'سوربيه الليمون',
                    'description' => 'سوربيه ليمون منعش',
                    'price' => 16.00,
                    'type' => 'صحي',
                    'calories' => 120,
                    'walking_time' => 18,
                ],
                [
                    'name' => 'آيس كريم نوتيلا',
                    'description' => 'آيس كريم غني بنكهة النوتيلا والبندق',
                    'price' => 22.00,
                    'type' => 'أسبوعي',
                    'calories' => 380,
                    'walking_time' => 55,
                    'is_featured' => true,
                ],
            ],
        ];

        // إنشاء المنتجات
        foreach ($products as $categoryName => $categoryProducts) {
            $categoryId = $categoriesMap[$categoryName] ?? null;

            if (!$categoryId) {
                $this->command->warn("لم يتم العثور على قسم: $categoryName");
                continue;
            }

            foreach ($categoryProducts as $productData) {
                $slug = Str::slug($productData['name'] . '-' . uniqid());

                Product::create([
                    'name' => $productData['name'],
                    'slug' => $slug,
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'category' => $categoryName, // الحقل القديم
                    'category_id' => $categoryId, // الحقل الجديد
                    'type' => $productData['type'],
                    'calories' => $productData['calories'] ?? null,
                    'walking_time' => $productData['walking_time'] ?? null,
                    'image' => null, // يمكن إضافة صور لاحقاً
                    'order_count' => rand(0, 100), // عدد عشوائي للطلبات
                    'is_available' => true,
                    'is_featured' => $productData['is_featured'] ?? false,
                ]);
            }
        }

        $this->command->info('تم إنشاء ' . Product::count() . ' منتج بنجاح.');
    }
}
