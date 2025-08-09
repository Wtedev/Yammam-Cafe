<?php

namespace Database\Seeders;

use App\Models\Suggestion;
use Illuminate\Database\Seeder;

class SuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء اقتراحات بأنواع مختلفة
        Suggestion::factory(10)->state(['type' => 'suggestion', 'status' => 'new'])->create();
        Suggestion::factory(5)->state(['type' => 'suggestion', 'status' => 'reviewing'])->create();
        Suggestion::factory(8)->state(['type' => 'suggestion', 'status' => 'approved'])->create();
        Suggestion::factory(3)->state(['type' => 'suggestion', 'status' => 'rejected'])->create();
        Suggestion::factory(4)->state(['type' => 'suggestion', 'status' => 'implemented'])->create();

        // إنشاء شكاوى بحالات مختلفة
        Suggestion::factory(8)->state(['type' => 'complaint', 'status' => 'new'])->create();
        Suggestion::factory(6)->state(['type' => 'complaint', 'status' => 'reviewing'])->create();
        Suggestion::factory(5)->state(['type' => 'complaint', 'status' => 'approved'])->create();
        Suggestion::factory(4)->state(['type' => 'complaint', 'status' => 'rejected'])->create();
        Suggestion::factory(2)->state(['type' => 'complaint', 'status' => 'implemented'])->create();

        // إنشاء ملاحظات إيجابية
        Suggestion::factory(7)->state(['type' => 'compliment', 'status' => 'new'])->create();
        Suggestion::factory(4)->state(['type' => 'compliment', 'status' => 'reviewing'])->create();
        Suggestion::factory(6)->state(['type' => 'compliment', 'status' => 'approved'])->create();

        // إنشاء اقتراحات مجهولة
        Suggestion::factory(10)->anonymous()->create();
    }
}
