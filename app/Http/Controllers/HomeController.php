<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // منتجات الأسبوع (المنتجات المميزة)
        $weeklyProducts = Product::where('is_available', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
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
