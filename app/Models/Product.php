<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'category',
        'category_id',
        'type',
        'calories',
        'walking_time',
        'preparation_time',
        'start_date',
        'end_date',
        'image',
        'order_count',
        'stock_quantity',
        'is_available',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'calories' => 'integer',
        'walking_time' => 'integer',
        'order_count' => 'integer',
        'stock_quantity' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the category name - custom accessor
     */
    public function getCategoryNameAttribute()
    {
        if ($this->category_id && $this->relationLoaded('category') && is_object($this->category)) {
            return $this->category->name;
        }

        return $this->category;
    }

    // العلاقات
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        // إذا كان المعرف رقمي، نستعلم بناءً على معرف القسم
        if (is_numeric($category)) {
            return $query->where('category_id', $category);
        }
        // دعم السلوك القديم (اسم القسم كنص)
        else {
            // نحاول العثور على القسم أولاً
            $categoryModel = Category::where('name', $category)
                ->orWhere('slug', $category)
                ->first();

            if ($categoryModel) {
                return $query->where('category_id', $categoryModel->id);
            }

            // إذا لم نجد، نعود للسلوك القديم
            return $query->where('category', $category);
        }
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/products/' . $this->image)
            : asset('images/default-product.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ريال';
    }

    public function getCalculatedWalkingTimeAttribute()
    {
        // Calculate walking time based on calories (1 calorie = 0.25 minutes)
        return $this->calories ? round($this->calories * 0.25) : 0;
    }

    /**
     * Check if product is currently available based on stock and dates
     */
    public function getIsCurrentlyAvailableAttribute()
    {
        // Check stock quantity
        if ($this->stock_quantity <= 0) {
            return false;
        }

        // Check date range for weekly products
        if ($this->type === 'weekly') {
            $now = now();

            if ($this->start_date && $now->lt($this->start_date)) {
                return false;
            }

            if ($this->end_date && $now->gt($this->end_date)) {
                return false;
            }
        }

        return $this->is_available;
    }

    /**
     * Get availability status text
     */
    public function getAvailabilityStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'نفد المخزون';
        }

        if ($this->type === 'weekly') {
            $now = now();

            if ($this->start_date && $now->lt($this->start_date)) {
                return 'لم يبدأ بعد';
            }

            if ($this->end_date && $now->gt($this->end_date)) {
                return 'انتهت المدة';
            }
        }

        return $this->is_available ? 'متوفر' : 'غير متوفر';
    }

    /**
     * Get the appropriate icon class for the product type
     */
    public function getIconClass()
    {
        switch (strtolower($this->type)) {
            case 'coffee':
            case 'قهوة':
                return 'coffee';
            case 'tea':
            case 'شاي':
                return 'leaf';
            case 'cold_drink':
            case 'مشروب بارد':
                return 'glass-whiskey';
            case 'dessert':
            case 'حلوى':
                return 'birthday-cake';
            case 'pastry':
            case 'معجنات':
                return 'bread-slice';
            case 'ice_cream':
            case 'آيس كريم':
                return 'ice-cream';
            default:
                return 'utensils';
        }
    }
}
