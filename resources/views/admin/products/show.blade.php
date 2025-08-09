<x-admin-layout title="عرض المنتج">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">تفاصيل المنتج</h1>
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Product Image -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">صورة المنتج</h3>
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg shadow-sm">
                    @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">لا توجد صورة</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
                            <div class="flex items-center space-x-4 space-x-reverse mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $product->category }}
                                </span>
                                @if($product->is_available)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check ml-1"></i>
                                    متوفر
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times ml-1"></i>
                                    غير متوفر
                                </span>
                                @endif
                                @if($product->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-star ml-1"></i>
                                    مميز
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">الوصف</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-2">معلومات السعر</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">السعر:</span>
                                        <span class="font-medium text-gray-900">{{ number_format($product->price, 2) }} ريال</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-2">معلومات إضافية</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">وقت التحضير:</span>
                                        <span class="font-medium text-gray-900">{{ $product->preparation_time ?? 15 }} دقيقة</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">تاريخ الإنشاء:</span>
                                        <span class="font-medium text-gray-900">{{ $product->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">آخر تحديث:</span>
                                        <span class="font-medium text-gray-900">{{ $product->updated_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2 space-x-reverse">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        <i class="fas fa-edit ml-2"></i>
                                        تعديل المنتج
                                    </a>

                                    <!-- Toggle Availability -->
                                    <form action="{{ route('admin.products.toggle-availability', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($product->is_available)
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200" onclick="return confirm('هل تريد جعل هذا المنتج غير متوفر؟')">
                                            <i class="fas fa-times ml-2"></i>
                                            جعل غير متوفر
                                        </button>
                                        @else
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200" onclick="return confirm('هل تريد جعل هذا المنتج متوفراً؟')">
                                            <i class="fas fa-check ml-2"></i>
                                            جعل متوفر
                                        </button>
                                        @endif
                                    </form>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟ هذا الإجراء لا يمكن التراجع عنه.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        <i class="fas fa-trash ml-2"></i>
                                        حذف المنتج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">مرات الطلب</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $product->orders_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">إجمالي المبيعات</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format(($product->orders_count ?? 0) * $product->price, 2) }} ريال</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-eye text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">المشاهدات</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $product->views_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
