<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'قهوة مختصة',
                'slug' => 'specialty-coffee',
            ],
            [
                'name' => 'مشروبات ساخنة',
                'slug' => 'hot-drinks',
            ],
            [
                'name' => 'مشروبات باردة',
                'slug' => 'cold-drinks',
            ],
            [
                'name' => 'حلويات شرقية',
                'slug' => 'eastern-desserts',
            ],
            [
                'name' => 'حلويات غربية',
                'slug' => 'western-desserts',
            ],
            [
                'name' => 'معجنات وفطائر',
                'slug' => 'pastries',
            ],
            [
                'name' => 'وجبات خفيفة',
                'slug' => 'snacks',
            ],
            [
                'name' => 'مثلجات',
                'slug' => 'ice-cream',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
