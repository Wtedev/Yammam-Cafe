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
                'name' => 'مشروبات ساخنة',
                'slug' => 'hot-drinks',
            ],
            [
                'name' => 'مشروبات باردة',
                'slug' => 'cold-drinks',
            ],
            [
                'name' => 'وجبات خفيفة',
                'slug' => 'snacks',
            ],
            [
                'name' => 'حلويات',
                'slug' => 'desserts',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
