<x-layout.admin-layout title="إدارة المنتجات">
    <div class="container mx-auto px-4 py-2">
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
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-xl shadow transition-colors duration-200">
                <i class="fas fa-plus"></i>
                <span>إضافة منتج جديد</span>
            </a>
        </div>

        <!-- Stats Cards (Unified like dashboard) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">إجمالي المنتجات</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $products->total() }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">متوفر</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $products->where('is_available', true)->count() }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">غير متوفر</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $products->where('is_available', false)->count() }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">مميز</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $products->where('is_featured', true)->count() }}</span>
            </div>
        </div>

        <!-- المنتجات -->
        <h2 class="text-xl font-bold text-gray-900 mb-4">المنتجات</h2>

        <!-- Include Products Cards from Partial View -->
        @include('admin.products.partials.product-cards')
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</x-layout.admin-layout>
