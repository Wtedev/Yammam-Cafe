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
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-xl shadow transition-colors duration-200">
                    <i class="fas fa-plus"></i>
                    <span>إضافة منتج جديد</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-xl shadow transition-colors duration-200">
                    <i class="fas fa-list"></i>
                    <span>إدارة التصنيفات</span>
                </a>
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
