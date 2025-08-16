<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private const IMAGE_MAX_KB = 10240; // 10MB

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:' . self::IMAGE_MAX_KB,
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
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 10MB (الحالي: ' . ini_get('upload_max_filesize') . ' / post_max_size=' . ini_get('post_max_size') . ')',
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
            'end_date',
            'stock_quantity'
        ]);

        // Ensure unique slug
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        $data['category_id'] = $request->category_id;
        $category = \App\Models\Category::find($request->category_id);
        if ($category) {
            $data['category'] = $category->name; // legacy column
        }

        $data['is_available'] = $request->has('is_available');
        $data['is_featured'] = $request->has('is_featured');
        $data['preparation_time'] = $request->preparation_time ?? 15;
        $data['order_count'] = 0;
        $data['walking_time'] = $request->calories ? round($request->calories * 0.25) : 0;

        // تأكد من وجود مجلد التخزين
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }
        $uploadError = null; // لتجميع سبب الفشل إن وجد
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $phpError = $file->getError();
            $errorMap = [
                UPLOAD_ERR_OK => 'تم الرفع بنجاح',
                UPLOAD_ERR_INI_SIZE => 'حجم الملف يتجاوز upload_max_filesize في إعدادات PHP',
                UPLOAD_ERR_FORM_SIZE => 'حجم الملف يتجاوز الحد الأقصى المحدد في النموذج',
                UPLOAD_ERR_PARTIAL => 'تم رفع جزء من الملف فقط (انقطاع اتصال)',
                UPLOAD_ERR_NO_FILE => 'لم يتم اختيار أي ملف',
                UPLOAD_ERR_NO_TMP_DIR => 'المجلد المؤقت مفقود على الخادم (tmp)',
                UPLOAD_ERR_CANT_WRITE => 'تعذر الكتابة على القرص (صلاحيات أو امتلاء)',
                UPLOAD_ERR_EXTENSION => 'تم إيقاف الرفع بواسطة إضافة PHP (extension)'
            ];
            $hints = [
                UPLOAD_ERR_INI_SIZE => 'الحل: زد upload_max_filesize و post_max_size (مثال: 16M) ثم أعد تشغيل PHP. القيمة الحالية: upload_max_filesize=' . ini_get('upload_max_filesize') . ', post_max_size=' . ini_get('post_max_size'),
                UPLOAD_ERR_FORM_SIZE => 'الحل: تحقق من حقل MAX_FILE_SIZE في النموذج أو حد Laravel للملف.',
                UPLOAD_ERR_PARTIAL => 'الحل: أعد المحاولة؛ تحقق من استقرار الاتصال أو من Reverse Proxy.',
                UPLOAD_ERR_NO_FILE => 'اختر ملف صورة (PNG / JPG).',
                UPLOAD_ERR_NO_TMP_DIR => 'الحل: أنشئ مجلد /tmp وأعطه صلاحيات كتابة للمستخدم الذي يشغل PHP.',
                UPLOAD_ERR_CANT_WRITE => 'الحل: تأكد من صلاحيات الكتابة storage و /tmp وعدم امتلاء القرص df -h.',
                UPLOAD_ERR_EXTENSION => 'الحل: افحص إعدادات php.ini وملحقات الأمان مثل imagick/intl أو أي hook يمنع الرفع.'
            ];
            if ($phpError !== UPLOAD_ERR_OK) {
                $base = $errorMap[$phpError] ?? ('خطأ رفع غير معروف (كود: ' . $phpError . ')');
                $uploadError = $base . (isset($hints[$phpError]) ? ' - ' . $hints[$phpError] : '');
                Log::warning('Image upload php error (store)', [
                    'code' => $phpError,
                    'message' => $base,
                    'size_bytes' => $file->getSize(),
                ]);
            } elseif (!$file->isValid()) {
                $uploadError = 'الملف غير صالح أو لم يكتمل رفعه. قد يكون الحجم تعدى 2MB المحددة في التحقق (max:2048) أو نوع MIME غير مطابق.';
            } else {
                try {
                    $path = $file->store('products', 'public');
                    if ($path && Storage::disk('public')->exists($path)) {
                        $data['image'] = $path;
                        Log::info('Product image stored (create)', [
                            'path' => $path,
                            'original' => $file->getClientOriginalName(),
                            'size_kb' => round($file->getSize() / 1024, 2),
                            'mime' => $file->getClientMimeType(),
                        ]);
                    } else {
                        $uploadError = 'فشل الحفظ بعد الرفع. تحقق من صلاحيات storage/app/public/products.';
                    }
                } catch (\Throwable $e) {
                    $uploadError = 'استثناء أثناء الرفع: ' . $e->getMessage();
                    Log::error('Image upload failed (store exception)', ['error' => $e->getMessage()]);
                }
            }
        }
        Product::create($data);
        $redirect = redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
        if ($uploadError) {
            // أسباب محتملة: حجم أكبر من المسموح، نوع غير مدعوم، عدم تنفيذ storage:link، صلاحيات مجلد.
            $redirect->with('warning', 'تم إنشاء المنتج لكن فشل رفع الصورة: ' . $uploadError);
        }
        return $redirect;
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
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:fixed,weekly',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:' . self::IMAGE_MAX_KB,
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
            'category.required' => 'التصنيف مطلوب',
            'category.exists' => 'التصنيف غير موجود',
            'type.required' => 'نوع المنتج مطلوب',
            'type.in' => 'نوع المنتج غير صحيح',
            'stock_quantity.required' => 'الكمية المتوفرة مطلوبة',
            'stock_quantity.numeric' => 'الكمية يجب أن تكون رقم',
            'stock_quantity.min' => 'الكمية لا يمكن أن تكون أقل من صفر',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 10MB (الحالي: ' . ini_get('upload_max_filesize') . ' / post_max_size=' . ini_get('post_max_size') . ')',
            'end_date.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية'
        ]);

        $data = $request->only(['name', 'description', 'price', 'calories', 'preparation_time', 'start_date', 'end_date', 'stock_quantity']);

        // Unique slug (allow same current slug)
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        $categoryId = $request->category ?? $request->category_id;
        $data['category_id'] = $categoryId;
        $category = \App\Models\Category::find($categoryId);
        if ($category) {
            $data['category'] = $category->name; // legacy support
        }

        $type = $request->type;
        if (!$type || !in_array($type, ['fixed', 'weekly'])) {
            $type = 'fixed';
        }
        $data['type'] = $type;

        $data['is_available'] = $request->has('is_available');
        $data['is_featured'] = $request->has('is_featured');

        // Update walking_time if calories changed
        if ($request->filled('calories')) {
            $data['walking_time'] = round($request->calories * 0.25);
        }

        // تأكد من وجود مجلد التخزين
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }
        $uploadError = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $phpError = $file->getError();
            $errorMap = [
                UPLOAD_ERR_OK => 'تم الرفع بنجاح',
                UPLOAD_ERR_INI_SIZE => 'حجم الملف يتجاوز upload_max_filesize في إعدادات PHP',
                UPLOAD_ERR_FORM_SIZE => 'حجم الملف يتجاوز الحد الأقصى المحدد في النموذج',
                UPLOAD_ERR_PARTIAL => 'تم رفع جزء من الملف فقط (انقطاع اتصال)',
                UPLOAD_ERR_NO_FILE => 'لم يتم اختيار أي ملف',
                UPLOAD_ERR_NO_TMP_DIR => 'المجلد المؤقت مفقود على الخادم (tmp)',
                UPLOAD_ERR_CANT_WRITE => 'تعذر الكتابة على القرص (صلاحيات أو امتلاء)',
                UPLOAD_ERR_EXTENSION => 'تم إيقاف الرفع بواسطة إضافة PHP'
            ];
            $hints = [
                UPLOAD_ERR_INI_SIZE => 'الحل: زد upload_max_filesize و post_max_size. القيم الحالية: upload_max_filesize=' . ini_get('upload_max_filesize') . ', post_max_size=' . ini_get('post_max_size'),
                UPLOAD_ERR_FORM_SIZE => 'الحل: تحقّق من MAX_FILE_SIZE في النموذج.',
                UPLOAD_ERR_PARTIAL => 'الحل: أعد المحاولة؛ قد يكون اتصال متقطع.',
                UPLOAD_ERR_NO_FILE => 'اختر ملفاً قبل الحفظ.',
                UPLOAD_ERR_NO_TMP_DIR => 'الحل: اضبط /tmp بصلاحيات مناسبة.',
                UPLOAD_ERR_CANT_WRITE => 'الحل: تأكد من صلاحيات الكتابة storage و مساحة القرص.',
                UPLOAD_ERR_EXTENSION => 'الحل: راجع إضافات PHP الأمنية.'
            ];
            if ($phpError !== UPLOAD_ERR_OK) {
                $base = $errorMap[$phpError] ?? ('خطأ رفع غير معروف (كود: ' . $phpError . ')');
                $uploadError = $base . (isset($hints[$phpError]) ? ' - ' . $hints[$phpError] : '');
                Log::warning('Image upload php error (update)', [
                    'code' => $phpError,
                    'message' => $base,
                    'product_id' => $product->id,
                    'size_bytes' => $file->getSize(),
                ]);
            } elseif (!$file->isValid()) {
                $uploadError = 'الملف غير صالح أو لم يكتمل رفعه. تحقق من الحجم (≤2MB) والامتداد.';
            } else {
                try {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }
                    $path = $file->store('products', 'public');
                    if ($path && Storage::disk('public')->exists($path)) {
                        $data['image'] = $path;
                        Log::info('Product image stored (update)', [
                            'path' => $path,
                            'product_id' => $product->id,
                            'original' => $file->getClientOriginalName(),
                            'size_kb' => round($file->getSize() / 1024, 2),
                            'mime' => $file->getClientMimeType(),
                        ]);
                    } else {
                        $uploadError = 'فشل الحفظ بعد الرفع. تحقق من صلاحيات storage/app/public/products.';
                    }
                } catch (\Throwable $e) {
                    $uploadError = 'استثناء أثناء الرفع: ' . $e->getMessage();
                    Log::error('Image upload failed (update exception)', ['product_id' => $product->id, 'error' => $e->getMessage()]);
                }
            }
        }

        // منطق حذف الصورة بدون رفع جديدة
        if ($request->boolean('remove_image') && !$request->hasFile('image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = null; // تفريغ الحقل
        }

        $product->update($data);
        $redirect = redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح');
        if ($uploadError) {
            $redirect->with('warning', 'تم التحديث لكن فشل رفع الصورة: ' . $uploadError);
        }
        return $redirect;
    }

    public function destroy(Product $product)
    {
        // حذف الصورة
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
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

    // إضافة الميثود المفقود في الراوت
    public function toggleAvailability(Product $product)
    {
        $product->update(['is_available' => !$product->is_available]);
        $status = $product->is_available ? 'متاح' : 'غير متاح';
        return back()->with('success', "تم تغيير توفر المنتج إلى: {$status}");
    }
}
