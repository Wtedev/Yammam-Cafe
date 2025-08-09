<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_available', true);

        // البحث يأخذ الأولوية على تصفية القسم
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('type', 'like', $searchTerm)
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                        $categoryQuery->where('name', 'like', $searchTerm);
                    });
            });
        }
        // في حالة عدم وجود بحث، قم بتطبيق تصفية القسم
        else if ($request->has('category') && $request->category != '') {
            // إذا كان المعرف رقمي، نستعلم بناءً على معرف القسم
            if (is_numeric($request->category)) {
                $query->where('category_id', $request->category);
            } else {
                // في حالة إذا كان slug أو اسم
                $category = Category::where('slug', $request->category)
                    ->orWhere('name', $request->category)
                    ->first();

                if ($category) {
                    $query->where('category_id', $category->id);
                }
            }
        }

        // تصفية حسب النوع - تطبق فقط في حالة عدم وجود بحث
        if (!$request->has('search') && $request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // ترتيب
        $sortBy = $request->get('sort', 'name');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('order_count', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);

        // الحصول على الفئات المتاحة
        $categories = Category::orderBy('name')->get();

        return view('menu.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (!$product->is_available) {
            abort(404);
        }

        // منتجات مشابهة
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('menu.show', compact('product', 'relatedProducts'));
    }
}
