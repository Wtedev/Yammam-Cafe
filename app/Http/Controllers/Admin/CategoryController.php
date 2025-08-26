<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('products')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة التصنيف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('products');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $productCount = $category->products()->count();
        
        // إذا كان التصنيف يحتوي على منتجات، قم بإزالة ارتباطها بالتصنيف
        if ($productCount > 0) {
            // إزالة ارتباط المنتجات بالتصنيف (تعيين category_id إلى null)
            $category->products()->update(['category_id' => null]);
        }

        $categoryName = $category->name;
        $category->delete();

        $message = $productCount > 0 
            ? "تم حذف التصنيف '{$categoryName}' بنجاح وإزالة ارتباطه بـ {$productCount} منتج"
            : "تم حذف التصنيف '{$categoryName}' بنجاح";

        return redirect()->route('admin.categories.index')
            ->with('success', $message);
    }
}
