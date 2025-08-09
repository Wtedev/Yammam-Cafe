<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['مشروبات ساخنة', 'مشروبات باردة', 'مأكولات خفيفة', 'حلويات', 'مثلجات', 'وجبات أسبوعية'];
        $types = [
            'مشروبات ساخنة' => ['قهوة', 'شاي', 'شوكولاتة ساخنة'],
            'مشروبات باردة' => ['عصائر طبيعية', 'قهوة مثلجة', 'مشروبات منعشة'],
            'مأكولات خفيفة' => ['معجنات', 'ساندويش', 'سلطات'],
            'حلويات' => ['كيك', 'حلويات إيطالية', 'بسكويت'],
            'مثلجات' => ['آيس كريم', 'فرابيه'],
            'وجبات أسبوعية' => ['وجبات رئيسية', 'بيتزا']
        ];

        $category = $this->faker->randomElement($categories);
        $type = $this->faker->randomElement($types[$category]);
        $name = $this->generateProductName($category, $type);

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . $this->faker->unique()->randomNumber(4)),
            'description' => $this->faker->text(200),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'category' => $category,
            'type' => $type,
            'calories' => $this->faker->numberBetween(10, 500),
            'walking_time' => $this->faker->numberBetween(1, 60),
            'image' => null,
            'order_count' => $this->faker->numberBetween(0, 100),
            'is_available' => $this->faker->boolean(85), // 85% متاح
            'is_featured' => $this->faker->boolean(30), // 30% مميز
        ];
    }

    private function generateProductName($category, $type)
    {
        $names = [
            'قهوة' => ['قهوة عربية', 'إسبريسو', 'كابتشينو', 'لاتيه', 'أمريكانو', 'موكا'],
            'شاي' => ['شاي أحمر', 'شاي أخضر', 'شاي بالنعناع', 'شاي بالليمون', 'شاي كرك'],
            'عصائر طبيعية' => ['عصير برتقال', 'عصير تفاح', 'عصير مانجو', 'عصير فراولة', 'عصير أناناس'],
            'قهوة مثلجة' => ['آيس كوفي', 'فرابيه', 'آيس لاتيه', 'آيس موكا'],
            'معجنات' => ['كرواسون', 'دونات', 'مافن', 'بان كيك'],
            'ساندويش' => ['ساندويش تونة', 'ساندويش دجاج', 'ساندويش جبن', 'ساندويش لحم'],
            'كيك' => ['تشيز كيك', 'شوكولاتة كيك', 'فانيليا كيك', 'ريد فيلفت'],
            'آيس كريم' => ['فانيليا', 'شوكولاتة', 'فراولة', 'كراميل'],
            'وجبات رئيسية' => ['برجر لحم', 'برجر دجاج', 'شاورما', 'فلافل']
        ];

        return $this->faker->randomElement($names[$type] ?? ['منتج ' . $type]);
    }
}
