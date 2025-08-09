<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // استدعاء سيدر الأدمن
        $this->call(AdminUserSeeder::class);

        // إنشاء مستخدم تجريبي
        User::create([
            'name' => 'أحمد محمد',
            'mobile' => '0507654321',
            'office_number' => '15',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // إنشاء 20 مستخدم عادي
        User::factory(20)->create();

        // إنشاء 3 مدراء إضافيين
        User::factory(3)->admin()->create();

        // تشغيل باقي الـ Seeders
        $this->call([
            CategorySeeder::class,    // أولاً نقوم بإنشاء الأقسام
            ProductSeeder::class,     // ثم المنتجات التي تعتمد على الأقسام
            OrderSeeder::class,
            SuggestionSeeder::class,
        ]);
    }
}
