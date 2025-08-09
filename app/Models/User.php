<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'mobile',
        'office_number',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // تحديد اسم المستخدم للمصادقة ليكون رقم الجوال بدلاً من البريد الإلكتروني
    public function username()
    {
        return 'mobile';
    }

    // علاقة مع جدول الطلبات (مستخدم واحد يمكن أن يكون له عدة طلبات)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // علاقة مع جدول الاقتراحات (مستخدم واحد يمكن أن يكون له عدة اقتراحات)
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }

    // فحص الصلاحيات
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}
