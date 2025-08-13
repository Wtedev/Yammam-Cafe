<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->availability) {
            $query->where('is_available', $request->availability === 'available');
        }

        // تحميل علاقة التصنيف مسبقًا لتحسين الأداء وتجنب الأخطاء
        $query->with('category');

        $products = $query->orderBy('created_at', 'desc')->paginate(20);

        // استرجاع التصنيفات من جدول التصنيفات
        $categories = \App\Models\Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:fixed,weekly',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calories' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|numeric|min:1',
            'stock_quantity' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ], [
            'name.required' => 'اسم المنتج مطلوب',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'category_id.required' => 'التصنيف مطلوب',
            'category_id.exists' => 'التصنيف غير موجود',
            'type.required' => 'نوع المنتج مطلوب',
            'type.in' => 'نوع المنتج غير صحيح',
            'stock_quantity.required' => 'الكمية المتوفرة مطلوبة',
            'stock_quantity.numeric' => 'الكمية يجب أن تكون رقم',
            'stock_quantity.min' => 'الكمية لا يمكن أن تكون أقل من صفر',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.max' => 'حجم الصورة كبير جداً',
            'end_date.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية'
        ]);

        $data = $request->only([
            'name',
            'description',
            'price',
            'type',
            'calories',
            'preparation_time',
            'start_date',
            'end_date'
        ]);

        $data['slug'] = Str::slug($request->name);
        $data['category_id'] = $request->category_id;

        // Get category name for backward compatibility
        $category = \App\Models\Category::find($request->category_id);
        if ($category) {
            $data['category'] = $category->name;
        }

        $data['is_available'] = $request->has('is_available');
        $data['is_featured'] = $request->has('is_featured');
        $data['preparation_time'] = $request->preparation_time ?? 15;
        $data['order_count'] = 0;

        // Calculate walking time automatically based on calories
        // Assuming 1 calorie = 0.25 minutes of walking (average)
        $data['walking_time'] = $request->calories ? round($request->calories * 0.25) : 0;

        // رفع الصورة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:fixed,weekly',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'calories' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|numeric|min:1',
            'stock_quantity' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ], [
            'name.required' => 'اسم المنتج مطلوب',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'category_id.required' => 'التصنيف مطلوب',
            'category_id.exists' => 'التصنيف غير موجود',
            'type.required' => 'نوع المنتج مطلوب',
            'type.in' => 'نوع المنتج غير صحيح',
            'stock_quantity.required' => 'الكمية المتوفرة مطلوبة',
            'stock_quantity.numeric' => 'الكمية يجب أن تكون رقم',
            'stock_quantity.min' => 'الكمية لا يمكن أن تكون أقل من صفر',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.max' => 'حجم الصورة كبير جداً',
            'end_date.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية'
        ]);

        $data = $request->only([
            'name',
            'description',
            'price',
            'calories',
            'preparation_time',
            'start_date',
            'end_date'
        ]);

        $data['slug'] = Str::slug($request->name);
        $data['category_id'] = $request->category;

        // Set both category_id and category for backwards compatibility
        $category = \App\Models\Category::find($request->category);
        if ($category) {
            $data['category'] = $category->name;
        }

        // Handle type field - set default if not provided or invalid
        $type = $request->type;
        if (!$type || !in_array($type, ['fixed', 'weekly'])) {
            $type = 'fixed'; // Default to fixed
        }
        $data['type'] = $type;

        $data['is_available'] = $request->has('is_available');
        $data['is_featured'] = $request->has('is_featured');
        $data['preparation_time'] = $request->preparation_time ?? $product->preparation_time ?? 15;

        // رفع الصورة الجديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($product->image) {
                $oldImagePath = storage_path('app/public/products/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/products/');

            // تأكد من وجود المجلد
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // نقل الملف يدوياً
            $moved = $image->move($destinationPath, $imageName);
            $fullPath = $destinationPath . $imageName;

            if ($moved && file_exists($fullPath)) {
                $data['image'] = $imageName;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        // حذف الصورة
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_available' => !$product->is_available]);

        $status = $product->is_available ? 'متاح' : 'غير متاح';
        return back()->with('success', "تم تغيير حالة المنتج إلى: {$status}");
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'مميز' : 'عادي';
        return back()->with('success', "تم تغيير حالة المنتج إلى: {$status}");
    }
}
