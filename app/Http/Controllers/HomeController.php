<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // منتجات الأسبوع (المنتجات الأسبوعية المتاحة حالياً)
        $weeklyProducts = Product::where('is_available', true)
            ->where('type', 'weekly')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // أقسام الكافيه من قاعدة البيانات
        $categories = Category::all();

        // المنتجات الأكثر طلباً
        $popularProducts = Product::where('is_available', true)
            ->where('order_count', '>', 0)
            ->orderBy('order_count', 'desc')
            ->take(3)
            ->get();

        return view('home', compact('weeklyProducts', 'categories', 'popularProducts'));
    }
}
