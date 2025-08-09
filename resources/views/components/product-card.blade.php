@props(['product'])

<div class="bg-white rounded-2xl hover:shadow-sm transition-all duration-300 overflow-hidden group relative border border-gray-200">
    <!-- صورة المنتج -->
    <div class="relative h-44 bg-soft-cream flex items-center justify-center">
        @if($product->image)
        <img src="{{ $product->image_url ?? Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
        <div class="flex items-center justify-center h-full w-full">
            <i class="fas fa-coffee text-5xl text-gray-400"></i>
        </div>
        @endif

        <!-- شارة المنتج المميز -->
        @if($product->is_featured)
        <span class="absolute top-3 right-3 bg-gray-800 text-white text-xs px-3 py-1 rounded-full font-bold flex items-center">
            <i class="fas fa-star ml-1 text-yellow-400"></i>مميز
        </span>
        @endif

        <!-- حالة التوفر -->
        @unless($product->is_available)
        <span class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-white text-lg font-bold rounded-2xl">غير متوفر</span>
        @endunless
    </div>

    <!-- محتوى المنتج -->
    <div class="p-4 flex flex-col gap-2 bg-white">
        <!-- اسم المنتج -->
        <h3 class="font-bold text-lg text-gray-900 mb-1 truncate">{{ $product->name }}</h3>

        <!-- الوصف -->
        @if($product->description)
        <p class="text-warm-gray text-xs mb-1 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
        @endif

        <!-- الفئة -->
        <span class="inline-block bg-soft-brown text-soft-brown text-xs px-2 py-0.5 rounded mb-2">{{ $product->category }}</span>

        <!-- السعر وزر السلة -->
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-1">
                <span class="text-xl font-bold text-gray-800">{{ number_format($product->price, 2) }}</span>
                <span class="text-xs text-warm-gray">ريال</span>
            </div>
            <button class="add-to-cart-btn py-2 px-4 text-sm font-medium" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" @if(!$product->is_available) disabled style="opacity:0.5;cursor:not-allowed" @endif>
                @if($product->is_available)
                <span class="button-text">
                    <i class="fas fa-cart-plus ml-1"></i>
                    أضف
                </span>
                <span class="loading-text hidden">
                    <span class="loading-spinner ml-1"></span>
                    جارٍ...
                </span>
                @else
                <i class="fas fa-times ml-1"></i>
                <span>غير متوفر</span>
                @endif
            </button>
        </div>
    </div>
</div>
@if($product->order_count > 0)
<div class="text-center mt-2 text-xs text-warm-gray">
    تم طلبه {{ $product->order_count }} مرة
</div>
@endif
