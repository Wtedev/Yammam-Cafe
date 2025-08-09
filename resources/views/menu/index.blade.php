<x-user-layout title="المنيو الكامل">
    <!-- Search Bar -->
    <div class="px-4 pt-6 pb-4">
        <form action="{{ route('menu.index') }}" method="GET" class="relative">
            <!-- البحث دائماً يكون في كل المنتجات بغض النظر عن القسم المحدد -->

            <div class="relative">
                <input type="text" name="search" placeholder="ابحث عن المنتجات في جميع الأقسام..." value="{{ request('search') }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">

                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-amber-500 hover:text-amber-600">
                    <i class="fas fa-search"></i>
                </button>

                @if(request('search'))
                <a href="{{ request()->url() }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </a>
                @else
                <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                @endif
            </div>
            <div class="text-xs text-gray-500 mt-1 text-center">
                البحث يتم في جميع الأقسام بغض النظر عن القسم المحدد
            </div>
        </form>
    </div>

    <!-- Categories Tabs -->
    <div class="px-4 pb-4" x-data="{ activeTab: window.location.search.includes('category=') ? new URLSearchParams(window.location.search).get('category') : 'all' }">
        @if(!request('search'))
        <div class="flex space-x-2 space-x-reverse overflow-x-auto pb-2 scrollbar-hide">
            <button @click="activeTab = 'all'; window.location.href = '{{ route('menu.index') }}'" :class="activeTab === 'all' || !activeTab ? 'bg-amber-500 text-white' : 'bg-white text-gray-700'" class="px-6 py-2 rounded-full font-medium whitespace-nowrap transition-colors duration-200 flex-shrink-0">
                الكل
            </button>

            @foreach($categories as $category)
            <button @click="activeTab = '{{ $category->slug }}'; window.location.href = '{{ route('menu.index') }}?category={{ $category->slug }}'" :class="activeTab === '{{ $category->slug }}' ? 'bg-amber-500 text-white' : 'bg-white text-gray-700'" class="px-6 py-2 rounded-full font-medium whitespace-nowrap transition-colors duration-200 flex-shrink-0">
                {{ $category->name }}
            </button>
            @endforeach
        </div>
        @else
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">نتائج البحث في جميع الأقسام</h2>
            <a href="{{ request()->url() }}" class="text-amber-500 hover:text-amber-600">
                <i class="fas fa-times-circle ml-1"></i>
                إلغاء البحث
            </a>
        </div>
        @endif

        <div class="space-y-4 mt-4">
            @if(request('search'))
            <div class="bg-amber-50 p-3 rounded-lg mb-3 text-center">
                <p class="text-amber-800">
                    @if($products->total() > 0)
                    <i class="fas fa-search-plus ml-1"></i>
                    تم العثور على {{ $products->total() }} {{ $products->total() == 1 ? 'منتج' : 'منتجات' }} تطابق "{{ request('search') }}"
                    @else
                    <i class="fas fa-search-minus ml-1"></i>
                    لم يتم العثور على منتجات تطابق "{{ request('search') }}"
                    @endif
                </p>
            </div>
            @endif

            @forelse($products as $product)
            <x-popular-product-card :product="$product" />
            @empty
            <div class="text-center py-12 bg-white rounded-xl">
                <div class="text-6xl text-gray-400 mb-4">🔍</div>
                @if(request('search'))
                <p class="text-warm-gray text-lg font-medium mb-2">لم يتم العثور على منتجات تطابق "{{ request('search') }}"</p>
                <p class="text-gray-500 text-sm mb-4">جرب البحث بكلمات أخرى أو تصفح الأقسام المختلفة</p>
                <a href="{{ route('menu.index') }}" class="inline-block bg-amber-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-1"></i>
                    عرض كل المنتجات
                </a>
                @elseif(request('category'))
                <p class="text-warm-gray text-lg font-medium mb-2">لا توجد منتجات متاحة في هذا القسم</p>
                <a href="{{ route('menu.index') }}" class="inline-block bg-amber-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-1"></i>
                    عرض كل المنتجات
                </a>
                @else
                <p class="text-warm-gray text-lg font-medium">لا توجد منتجات متاحة</p>
                @endif
            </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- تفعيل أزرار إضافة للسلة -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof initializeCartButtons === 'function') {
                initializeCartButtons();
            }
        });

    </script>
</x-user-layout>
