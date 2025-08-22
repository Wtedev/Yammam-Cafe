<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = Product::where('is_available', true)
            ->where(function($q) {
                // إخفاء المنتجات الأسبوعية المنتهية الصلاحية
                $q->where('type', '!=', 'weekly')
                  ->orWhere(function($weeklyQuery) {
                      $weeklyQuery->where('type', 'weekly')
                                 ->where(function($dateQuery) {
                                     $dateQuery->whereNull('end_date')
                                              ->orWhere('end_date', '>=', now()->toDateString());
                                 });
                  });
            });

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $products = $query->take(10)->get(['id', 'name', 'price', 'image', 'category', 'type']);

        return response()->json($products);
    }

    public function categories()
    {
        $categories = Product::where('is_available', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return response()->json($categories);
    }

    public function types(Request $request)
    {
        $query = Product::where('is_available', true);

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $types = $query->distinct()
            ->pluck('type')
            ->filter()
            ->values();

        return response()->json($types);
    }

    public function featured()
    {
        $products = Product::where('is_available', true)
            ->where('is_featured', true)
            ->where(function($q) {
                // إخفاء المنتجات الأسبوعية المنتهية الصلاحية
                $q->where('type', '!=', 'weekly')
                  ->orWhere(function($weeklyQuery) {
                      $weeklyQuery->where('type', 'weekly')
                                 ->where(function($dateQuery) {
                                     $dateQuery->whereNull('end_date')
                                              ->orWhere('end_date', '>=', now()->toDateString());
                                 });
                  });
            })
            ->orderBy('order_count', 'desc')
            ->take(8)
            ->get(['id', 'name', 'price', 'image', 'category']);

        return response()->json($products);
    }

    public function popular()
    {
        $products = Product::where('is_available', true)
            ->where(function($q) {
                // إخفاء المنتجات الأسبوعية المنتهية الصلاحية
                $q->where('type', '!=', 'weekly')
                  ->orWhere(function($weeklyQuery) {
                      $weeklyQuery->where('type', 'weekly')
                                 ->where(function($dateQuery) {
                                     $dateQuery->whereNull('end_date')
                                              ->orWhere('end_date', '>=', now()->toDateString());
                                 });
                  });
            })
            ->orderBy('order_count', 'desc')
            ->take(10)
            ->get(['id', 'name', 'price', 'image', 'order_count']);

        return response()->json($products);
    }
}
