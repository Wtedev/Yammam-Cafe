<x-admin-layout title="إدارة المنتجات">
    <div class="container mx-auto px-4 py-6">
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
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">إدارة المنتجات</h1>
            <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-plus ml-2"></i>
                إضافة منتج جديد
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">إجمالي المنتجات</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $products->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">متوفر</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $products->where('is_available', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">غير متوفر</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $products->where('is_available', false)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600">مميز</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $products->where('is_featured', true)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
            <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث عن منتج..." class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الفئة</label>
                    <select name="category" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">جميع الفئات</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متوفر</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>غير متوفر</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>مميز</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-search ml-2"></i>
                        بحث
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 flex flex-col overflow-hidden relative group aspect-square transition hover:shadow-lg">
                <div class="relative w-full" style="height:60%;min-height:120px;">
                    <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                        @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center rounded-t-2xl">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-image text-6xl"></i>
                        </div>
                        @endif
                    </div>
                    {{-- تم حذف ليبل مميز بناءً على طلب المستخدم --}}
                    @if($product->is_available)
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded shadow z-10">متوفر</span>
                    @endif
                </div>
                <div class="flex-1 flex flex-col p-4 gap-2">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-0.5 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mb-1 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex flex-wrap gap-2 mb-1">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $product->category }}</span>
                        <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $product->type }}</span>
                    </div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-green-600 font-bold text-lg">{{ number_format($product->price, 2) }} ريال</span>
                        <span class="text-xs text-gray-400">{{ $product->calories ? $product->calories.' سعرة' : '--' }}</span>
                    </div>
                    <div class="mt-auto flex items-center gap-2 pt-2">
                        <div class="flex w-full gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-bold text-base transition shadow flex items-center justify-center">تعديل</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')" class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-12 h-12 bg-red-500 hover:bg-red-600 text-white rounded-lg text-base font-bold transition flex items-center justify-center shadow">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">لا توجد منتجات</div>
            @endforelse
        </div>
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
