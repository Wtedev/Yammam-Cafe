<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_number',
        'status',
        'products',
        'total_price',
        'order_time',
        'delivery_time',
        'payment_method',
        'payment_image_url',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'order_time' => 'datetime',
        'delivery_time' => 'datetime',
        'products' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        $statusTexts = [
            'pending' => 'في الانتظار',
            'processed' => 'قيد المعالجة',
            'delivered' => 'تم التسليم',
            'cancelled' => 'ملغى'
        ];

        return $statusTexts[$this->status] ?? 'غير معروف';
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_price, 2) . ' ريال';
    }

    public function getProductsDataAttribute()
    {
        return is_string($this->products) ? json_decode($this->products, true) : $this->products;
    }
}
