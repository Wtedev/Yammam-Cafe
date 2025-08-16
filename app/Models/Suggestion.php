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
        'anonymous',
        'admin_response',
        'responded_at',
        'first_viewed_at',
        'first_viewed_by',
    ];

    protected $casts = [
        'first_viewed_at' => 'datetime',
        'responded_at' => 'datetime',
        'anonymous' => 'boolean',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function firstViewedBy()
    {
        return $this->belongsTo(User::class, 'first_viewed_by');
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

    public function scopeUnviewed($query)
    {
        return $query->whereNull('first_viewed_at');
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
            'reviewing' => 'قيد المراجعة',
            'approved' => 'موافق عليه',
            'rejected' => 'مرفوض',
            'implemented' => 'تم التنفيذ'
        ];

        return $statusTexts[$this->status] ?? 'غير معروف';
    }

    public function getIsNewViewAttribute()
    {
        return is_null($this->first_viewed_at);
    }
}
