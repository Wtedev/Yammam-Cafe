@props(['product'])

<div class="bg-white rounded-2xl overflow-hidden hover:shadow-sm transition-all duration-300 p-4 border border-gray-200">
    <div class="flex items-center gap-4">
        <!-- صورة المنتج -->
        <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-soft-cream">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </div>

        <!-- معلومات المنتج -->
        <div class="flex-1 min-w-0">
            <!-- اسم المنتج -->
            <h4 class="font-bold text-gray-900 truncate">{{ $product->name }}</h4>

            <!-- وصف المنتج -->
            <p class="text-warm-gray text-xs mt-1 line-clamp-1">{{ $product->description }}</p>

            <!-- السعرات ووقت المشي -->
            <div class="flex gap-2 mt-2">
                @if($product->calories)
                <div class="health-badge calories-badge">
                    <i class="fas fa-fire"></i>
                    <span>{{ $product->calories }}</span>
                </div>
                @endif
                @if($product->walking_time)
                <div class="health-badge walking-badge">
                    <i class="fas fa-walking"></i>
                    <span>{{ $product->walking_time }}د</span>
                </div>
                @endif
            </div>
        </div>

        <!-- السعر وزر الإضافة -->
        <div class="text-right flex-shrink-0">
            <!-- السعر -->
            <div class="mb-2">
                <span class="text-lg font-bold text-gray-800">{{ number_format($product->price, 0) }}</span>
                <span class="text-xs text-warm-gray mr-1">ريال</span>
            </div>

            <!-- زر إضافة للسلة -->
            <button class="add-to-cart-btn py-2 px-3 text-sm" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">
                <span class="button-text">
                    <i class="fas fa-cart-plus"></i>
                </span>
                <span class="loading-text hidden">
                    <span class="loading-spinner"></span>
                </span>
            </button>
        </div>
    </div>
</div>
