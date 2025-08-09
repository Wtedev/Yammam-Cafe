<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء مستخدم بصلاحيات الأدمن
        User::create([
            'name' => 'Admin',
            'mobile' => '0500000000', // رقم الجوال للأدمن
            'office_number' => '123', // رقم المكتب (اختياري)
            'password' => Hash::make('admin123'), // كلمة المرور
            'role' => 'admin', // نوع الصلاحية: أدمن
        ]);

        $this->command->info('تم إنشاء مستخدم الأدمن بنجاح!');
    }
}
