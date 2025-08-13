<x-layout.admin-layout title="عرض المنتج">
    <div class="max-w-4xl mx-auto py-8 px-2 md:px-6 font-[Cairo,Tajawal,Segoe UI,Arial,sans-serif]">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-blue-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-blue-400"></span>
                تفاصيل المنتج
            </h1>
            <div class="flex flex-row gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-edit"></i> تعديل
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟ هذا الإجراء لا يمكن التراجع عنه.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-arrow-right"></i> العودة للقائمة
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Product Image -->
            <div class="md:col-span-1">
                <div class="bg-white/90 rounded-2xl shadow-sm border border-blue-50 p-4 flex flex-col items-center">
                    <h3 class="text-base font-bold text-blue-900 mb-3">صورة المنتج</h3>
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover rounded-xl shadow-sm border border-blue-50">
                    @else
                    <div class="w-full h-56 bg-blue-50 rounded-xl flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-image text-4xl text-blue-200 mb-2"></i>
                            <p class="text-blue-400">لا توجد صورة</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="md:col-span-2">
                <div class="bg-white/90 rounded-2xl shadow-sm border border-blue-50 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">
                        <h2 class="text-xl font-bold text-blue-900">{{ $product->name }}</h2>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ $product->category }}</span>
                            @if($product->is_available)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center gap-1"><i class="fas fa-check"></i> متوفر</span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 flex items-center gap-1"><i class="fas fa-times"></i> غير متوفر</span>
                            @endif
                            @if($product->is_featured)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 flex items-center gap-1"><i class="fas fa-star"></i> مميز</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-base font-bold text-blue-900 mb-1">الوصف</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                            <span class="text-xs text-blue-700 font-bold mb-1">السعر</span>
                            <span class="text-lg font-extrabold text-blue-900">{{ number_format($product->price, 2) }} <span class="text-base text-blue-400 font-normal">ر.س</span></span>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                            <span class="text-xs text-blue-700 font-bold mb-1">وقت التحضير</span>
                            <span class="text-lg font-extrabold text-blue-900">{{ $product->preparation_time ?? 15 }} دقيقة</span>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                            <span class="text-xs text-blue-700 font-bold mb-1">تاريخ الإنشاء</span>
                            <span class="text-base text-blue-900">{{ $product->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                            <span class="text-xs text-blue-700 font-bold mb-1">آخر تحديث</span>
                            <span class="text-base text-blue-900">{{ $product->updated_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/90 rounded-2xl shadow-sm p-6 border border-blue-50 flex flex-col items-center">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-blue-700 font-bold">مرات الطلب</p>
                        <p class="text-2xl font-extrabold text-blue-900">{{ $product->orders_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/90 rounded-2xl shadow-sm p-6 border border-blue-50 flex flex-col items-center">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-blue-700 font-bold">إجمالي المبيعات</p>
                        <p class="text-2xl font-extrabold text-blue-900">{{ number_format(($product->orders_count ?? 0) * $product->price, 2) }} ريال</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/90 rounded-2xl shadow-sm p-6 border border-blue-50 flex flex-col items-center">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-eye text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-blue-700 font-bold">المشاهدات</p>
                        <p class="text-2xl font-extrabold text-blue-900">{{ $product->views_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.admin-layout>
