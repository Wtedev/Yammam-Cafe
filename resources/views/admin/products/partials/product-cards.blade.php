<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($products as $product)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden relative group transition hover:shadow-md h-[500px] max-h-[500px]">
        <div class="relative w-full bg-blue-50/40 aspect-square flex-shrink-0">
            <div class="absolute inset-0 flex items-center justify-center">
                @if($product->image)
                <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                    <i class="fas fa-image text-6xl"></i>
                </div>
                @endif
            </div>
            @if($product->is_currently_available)
            <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-xs font-semibold px-4 py-1 rounded-full border border-green-300 z-10 tracking-wide">
                <i class="fas fa-check-circle mr-1 text-green-500"></i>
                متوفر
            </span>
            @else
            <span class="absolute top-3 right-3 bg-gray-100 text-gray-500 text-xs font-semibold px-4 py-1 rounded-full border border-gray-300 z-10 tracking-wide">
                <i class="fas fa-times-circle mr-1 text-gray-400"></i>
                {{ $product->availability_status }}
            </span>
            @endif
        </div>
        <div class="flex-1 flex flex-col p-4 gap-2 overflow-y-auto">
            <h3 class="text-base font-extrabold text-gray-900 mb-1">{{ $product->name }}</h3>
            <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $product->description }}</p>
            <div class="flex items-center flex-wrap gap-2 mb-1">
                <span class="text-green-700 font-bold text-sm">{{ number_format($product->price, 2) }} ريال</span>
                <span class="text-gray-300 text-xs">•</span>
                <span class="text-blue-700 font-semibold text-xs">المتوفر: {{ $product->stock_quantity ?? 0 }}</span>
            </div>
            <div class="mt-auto flex items-center gap-2 pt-3 flex-shrink-0 border-t border-gray-100">
                <div class="flex w-full gap-2 pt-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-xl font-bold text-xs transition shadow-sm flex items-center justify-center">
                        <i class="fas fa-edit ml-1"></i>
                        تعديل
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center justify-center gap-1 w-auto px-4 h-9 bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-600 rounded-xl text-xs font-bold border border-gray-200 transition focus:outline-none">
                            <i class="fas fa-trash text-base"></i>
                            <span class="hidden sm:inline">حذف</span>
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
