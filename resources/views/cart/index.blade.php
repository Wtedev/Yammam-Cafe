<x-user-layout title="سلة التسوق">
    <div class="max-w-lg mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">سلة التسوق</h1>
            @if(count($cartItems) > 0)
            <button onclick="clearCart()" class="text-red-600 hover:text-red-700 text-sm font-medium">
                <i class="fas fa-trash ml-1"></i>
                إفراغ السلة
            </button>
            @endif
        </div>

        @if(count($cartItems) > 0)
        <!-- Cart Items -->
        <div class="space-y-4 mb-6 cart-items">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 cart-item" data-cart-item="{{ $item['product']->id }}">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        @if($item['product']->image)
                        <img src="{{ Storage::url($item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-16 h-16 object-cover rounded-lg">
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400"></i>
                        </div>
                        @endif
                    </div>
                    <!-- Product Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $item['product']->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $item['product']->category }}</p>
                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <button type="button" class="quantity-decrement w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600" data-action="decrement" data-product-id="{{ $item['product']->id }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <input type="number" value="{{ $item['quantity'] }}" min="1" max="99" class="quantity-input w-12 h-8 text-center border border-gray-300 rounded text-sm" data-product-id="{{ $item['product']->id }}">
                            <button type="button" class="quantity-increment w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600" data-action="increment" data-product-id="{{ $item['product']->id }}">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Price and Remove -->
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900 mb-2" data-item-total="{{ $item['product']->id }}">
                            {{ number_format($item['product']->price * $item['quantity'], 2) }} ريال
                        </div>
                        <div class="text-xs text-gray-500 mb-2">{{ number_format($item['product']->price, 2) }} ريال / قطعة</div>
                        <button type="button" class="text-red-600 hover:text-red-700 text-sm remove-cart-item" data-product-id="{{ $item['product']->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">ملخص الطلب</h3>

            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">عدد المنتجات:</span>
                    <span class="cart-items-count">{{ $totalQuantity }} منتج</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">المجموع الفرعي:</span>
                    <span class="cart-total">{{ number_format($totalPrice, 2) }} ريال</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">رسوم التوصيل:</span>
                    <span class="text-green-600">مجاني</span>
                </div>
            </div>
            <script>
                // تفعيل أزرار التحكم في الكمية والحذف
                document.addEventListener('DOMContentLoaded', function() {
                    // زر الإنقاص
                    document.querySelectorAll('.quantity-decrement').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const productId = this.getAttribute('data-product-id');
                            const input = document.querySelector(`.quantity-input[data-product-id='${productId}']`);
                            let qty = parseInt(input.value) || 1;
                            if (qty > 1) {
                                updateCartQuantity(productId, qty - 1);
                            }
                        });
                    });
                    // زر الزيادة
                    document.querySelectorAll('.quantity-increment').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const productId = this.getAttribute('data-product-id');
                            const input = document.querySelector(`.quantity-input[data-product-id='${productId}']`);
                            let qty = parseInt(input.value) || 1;
                            if (qty < 99) {
                                updateCartQuantity(productId, qty + 1);
                            }
                        });
                    });
                    // إدخال يدوي
                    document.querySelectorAll('.quantity-input').forEach(input => {
                        input.addEventListener('change', function() {
                            const productId = this.getAttribute('data-product-id');
                            let qty = parseInt(this.value) || 1;
                            if (qty < 1) qty = 1;
                            if (qty > 99) qty = 99;
                            updateCartQuantity(productId, qty);
                        });
                    });
                    // زر الحذف
                    document.querySelectorAll('.remove-cart-item').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const productId = this.getAttribute('data-product-id');
                            removeFromCart(productId);
                        });
                    });
                });

            </script>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between text-lg font-bold">
                    <span>المجموع الكلي:</span>
                    <span class="cart-total text-amber-600">{{ number_format($totalPrice, 2) }} ريال</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-6 rounded-xl text-center block transition-colors duration-200">
                    <i class="fas fa-shopping-bag ml-2"></i>
                    إتمام الطلب
                </button>
            </form>
            <a href="{{ route('menu.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-center block transition-colors duration-200">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة للتسوق
            </a>
        </div>

        @else
        <!-- Empty Cart -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">سلة التسوق فارغة</h3>
            <p class="text-gray-600 mb-6">ابدأ بإضافة بعض المنتجات الرائعة إلى سلتك</p>

            <a href="{{ route('menu.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl transition-colors duration-200">
                <i class="fas fa-utensils ml-2"></i>
                تصفح القائمة
            </a>
        </div>
        @endif
    </div>

    <!-- Include cart JavaScript -->
    <script src="{{ asset('js/cart.js') }}"></script>

    <script>
        // Initialize quantity inputs
        document.addEventListener('DOMContentLoaded', function() {
            initializeQuantityInputs();
        });

    </script>
</x-user-layout>
