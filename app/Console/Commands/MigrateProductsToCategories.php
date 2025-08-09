<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrateProductsToCategories extends Command
{
    protected $signature = 'app:migrate-products-to-categories';
    protected $description = 'ترحيل منتجات من النظام القديم إلى نظام الفئات الجديد';

    public function handle()
    {
        $this->info('بدء ترحيل المنتجات إلى نظام الفئات الجديد...');

        // التأكد من وجود فئات مسبقة
        $categoryCount = Category::count();
        if ($categoryCount === 0) {
            $this->info('إنشاء الفئات الافتراضية...');
            $categories = [
                'مشروبات ساخنة',
                'مشروبات باردة',
                'قهوة مختصة',
                'مأكولات خفيفة',
                'حلويات',
                'مثلجات',
            ];

            foreach ($categories as $categoryName) {
                Category::create([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                ]);
            }
            $this->info('تم إنشاء ' . count($categories) . ' فئات.');
        }

        // الحصول على جميع الفئات
        $categories = Category::all()->pluck('id', 'name')->toArray();

        // ترحيل المنتجات
        $products = Product::whereNull('category_id')->get();
        $this->info('ترحيل ' . count($products) . ' منتج...');

        $updated = 0;

        foreach ($products as $product) {
            $categoryName = $product->category;

            // البحث عن الفئة المطابقة
            $categoryId = null;
            foreach ($categories as $name => $id) {
                if (Str::contains($categoryName, $name) || Str::contains($name, $categoryName)) {
                    $categoryId = $id;
                    break;
                }
            }

            // إذا لم يتم العثور على فئة، اختر فئة افتراضية
            if (!$categoryId && count($categories) > 0) {
                $this->warn('لم يتم العثور على فئة مطابقة لـ "' . $categoryName . '". استخدام أول فئة متاحة.');
                $categoryId = array_values($categories)[0];
            }

            if ($categoryId) {
                $product->category_id = $categoryId;
                $product->save();
                $updated++;
            }
        }

        $this->info('تم ترحيل ' . $updated . ' منتج بنجاح.');
        $this->info('اكتمل الترحيل!');

        return Command::SUCCESS;
    }
}
