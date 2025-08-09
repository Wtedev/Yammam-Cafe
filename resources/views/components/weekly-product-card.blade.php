@props(['product'])

<style>
  .price-col { text-align: right !important; }
</style>

<div class="bg-white rounded-2xl overflow-hidden hover:shadow-sm transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 min-w-0 flex-shrink-0">
    <!-- صورة المنتج -->
    <div class="w-full bg-soft-cream overflow-hidden" style="aspect-ratio: 4/3;">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
    </div>

    <!-- محتوى الكارد -->
    <div class="p-4 bg-white">
        <!-- اسم المنتج -->
        <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-1">{{ $product->name }}</h3>

        <!-- وصف المنتج -->
        <p class="text-warm-gray text-sm mb-3 line-clamp-2">{{ $product->description }}</p>

        <!-- السعر والسعرات الحرارية -->
        <div class="grid grid-cols-2 items-end mb-4" style="direction:ltr;">
            <!-- يسار: السعرات الحرارية ووقت المشي -->
            <div class="weekly-health-side flex flex-row gap-4 items-center justify-start">
                @if($product->calories)
                <div class="flex flex-col items-center min-w-[56px]">
                    <i class="fas fa-fire text-2xl text-orange-500 mb-1 weekly-product-icon fire-icon"></i>
                    <span class="text-xs text-warm-gray">{{ $product->calories }} سعرة</span>
                </div>
                @endif
                @if($product->walking_time)
                <div class="flex flex-col items-center min-w-[56px]">
                    <i class="fas fa-walking text-2xl text-green-500 mb-1 weekly-product-icon walking-icon"></i>
                    <span class="text-xs text-warm-gray">{{ $product->walking_time }} دقيقة</span>
                </div>
                @endif
            </div>
            <!-- السعر بأسفل اليمين -->
            <div class="col-start-2 w-full price-col">
                <div class="w-full flex justify-end">
                    <div class="inline-flex flex-row-reverse items-baseline gap-1">
                        <span class="text-xl font-bold text-gray-800">{{ number_format($product->price, 0) }}</span>
                        <span class="text-sm text-warm-gray">ريال</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- زر إضافة للسلة -->
        <button class="add-to-cart-btn w-full py-3 px-4 text-sm font-medium" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">
            <span class="button-text">
                <i class="fas fa-cart-plus ml-2"></i>
                إضافة للسلة
            </span>
            <span class="loading-text hidden">
                <span class="loading-spinner ml-2"></span>
                جارٍ الإضافة...
            </span>
        </button>
    </div>
</div>
