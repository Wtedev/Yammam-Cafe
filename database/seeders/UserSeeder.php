<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء حساب الأدمن
        User::create([
            'name' => 'مدير النظام',
            'mobile' => '0501234567',
            'office_number' => 'A001',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // إنشاء مستخدمين عاديين للاختبار
        User::create([
            'name' => 'أحمد محمد',
            'mobile' => '0501111111',
            'office_number' => 'B101',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'فاطمة عبدالله',
            'mobile' => '0502222222',
            'office_number' => 'B102',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'خالد العلي',
            'mobile' => '0503333333',
            'office_number' => 'C201',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'سارة أحمد',
            'mobile' => '0504444444',
            'office_number' => 'C202',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
