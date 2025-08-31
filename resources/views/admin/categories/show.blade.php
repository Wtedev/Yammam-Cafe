<x-layout.admin-layout title="عرض التصنيف">
    <div class="max-w-4xl mx-auto py-8 px-2 md:px-6 font-[Cairo,Tajawal,Segoe UI,Arial,sans-serif]">

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle ml-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-green-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-green-400"></span>
                تفاصيل التصنيف
            </h1>
            <div class="flex flex-row gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-edit"></i> تعديل
                </a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>

                <script>
                    function confirmDelete() {
                        @if($category - > products - > count() > 0)
                        return confirm('⚠️ تحذير!\n\nهذا التصنيف يحتوي على {{ $category->products->count() }} منتج.\n\nعند الحذف:\n✓ سيتم حذف التصنيف نهائياً\n✓ سيتم إزالة ارتباط المنتجات بهذا التصنيف\n✓ المنتجات ستبقى موجودة لكن بدون تصنيف\n\nهل أنت متأكد من المتابعة؟');
                        @else
                        return confirm('هل أنت متأكد من حذف هذا التصنيف؟\n\nهذا الإجراء لا يمكن التراجع عنه.');
                        @endif
                    }

                </script>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-arrow-right"></i> العودة للقائمة
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Category Icon -->
            <div class="md:col-span-1">
                <div class="bg-white/90 rounded-2xl shadow-sm border border-green-50 p-6 flex flex-col items-center">
                    <h3 class="text-lg font-bold text-green-900 mb-4">أيقونة التصنيف</h3>
                    <div class="w-full h-64 bg-green-50 rounded-xl flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tag text-white text-4xl"></i>
                            </div>
                            <p class="text-green-600 font-bold text-lg">{{ $category->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Details -->
            <div class="md:col-span-2">
                <div class="bg-white/90 rounded-2xl shadow-sm border border-green-50 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-6">
                        <h2 class="text-2xl font-bold text-green-900">{{ $category->name }}</h2>
                        <div class="flex flex-wrap gap-2">
                            @if($category->products->count() > 0)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center gap-1"><i class="fas fa-check"></i> يحتوي على منتجات</span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 flex items-center gap-1"><i class="fas fa-times"></i> فارغ</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-green-900 mb-3">معلومات التصنيف</h3>
                        <p class="text-gray-700 leading-relaxed text-base">هذا التصنيف يحتوي على {{ $category->products->count() }} منتج، منها {{ $category->products->where('is_available', true)->count() }} منتج متوفر حالياً.</p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Products in this Category -->
        @if($category->products->count() > 0)
        <div class="mt-8 bg-white/90 rounded-2xl shadow-sm border border-green-50 p-6">
            <h2 class="text-xl font-bold text-green-900 mb-6 flex items-center gap-2">
                <i class="fas fa-list"></i>
                منتجات هذا التصنيف
            </h2>

            <!-- Mobile Cards -->
            <div class="block md:hidden space-y-4">
                @foreach($category->products as $product)
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-cube text-green-500 text-lg"></i>
                            <span class="font-bold text-gray-900">{{ $product->name }}</span>
                        </div>
                        <a href="{{ route('admin.products.show', $product) }}" class="text-green-600 hover:text-green-900 p-2">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-green-900 text-lg">{{ number_format($product->price, 2) }} ر.س</span>
                        <div class="flex gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $product->type === 'weekly' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ $product->type === 'weekly' ? 'أسبوعي' : 'ثابت' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_available ? 'متوفر' : 'غير متوفر' }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                اسم المنتج
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                السعر
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                النوع
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($category->products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-cube text-green-500 ml-3"></i>
                                    <span class="text-sm font-bold text-gray-900">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                {{ number_format($product->price, 2) }} ر.س
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $product->type === 'weekly' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $product->type === 'weekly' ? 'أسبوعي' : 'ثابت' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_available ? 'متوفر' : 'غير متوفر' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('admin.products.show', $product) }}" class="text-green-600 hover:text-green-900 p-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="mt-8 bg-white/90 rounded-2xl shadow-sm border border-green-50 p-8 text-center">
            <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-3">لا توجد منتجات في هذا التصنيف</h3>
            <p class="text-gray-500">لم يتم إضافة أي منتجات لهذا التصنيف بعد</p>
        </div>
        @endif
    </div>
</x-layout.admin-layout>
