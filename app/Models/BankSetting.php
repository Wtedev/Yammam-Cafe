<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSetting extends Model
{
    protected $fillable = [
        'bank_name',
        'account_holder', 
        'account_number',
        'iban'
    ];

    /**
     * إحضار الإعدادات البنكية (إنشاء إذا لم تكن موجودة)
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'bank_name' => 'البنك الأهلي السعودي',
                'account_holder' => 'يمام كافيه',
                'account_number' => 'SA1234567890123456789012',
                'iban' => 'SA1234567890123456789012'
            ]);
        }
        
        return $settings;
    }

    /**
     * تحديث الإعدادات البنكية
     */
    public static function updateSettings($data)
    {
        $settings = self::first();
        
        if ($settings) {
            $settings->update($data);
        } else {
            $settings = self::create($data);
        }
        
        return $settings;
    }
}
