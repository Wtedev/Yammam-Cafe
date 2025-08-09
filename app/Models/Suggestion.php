<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'suggestion',
        'type',
        'status',
        'admin_response',
        'responded_at',
        'anonymous',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    // Accessors
    public function getTypeTextAttribute()
    {
        $typeTexts = [
            'suggestion' => 'اقتراح',
            'complaint' => 'شكوى',
            'compliment' => 'إطراء'
        ];

        return $typeTexts[$this->type] ?? 'غير معروف';
    }

    public function getStatusTextAttribute()
    {
        $statusTexts = [
            'new' => 'جديد',
            'reviewed' => 'مراجع',
            'responded' => 'مجاب عليه',
            'closed' => 'مغلق'
        ];

        return $statusTexts[$this->status] ?? 'غير معروف';
    }
}
