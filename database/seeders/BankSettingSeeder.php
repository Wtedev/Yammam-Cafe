<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankSetting;

class BankSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankSetting::create([
            'bank_name' => 'البنك الأهلي السعودي',
            'account_holder' => 'يمام كافيه',
            'account_number' => 'SA1234567890123456789012',
            'iban' => 'SA1234567890123456789012'
        ]);
    }
}
