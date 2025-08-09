<x-user-layout title="إتمام الطلب">
    <div class="max-w-lg mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">إتمام الطلب</h1>
            <p class="text-gray-600">راجع طلبك وأضف تفاصيل التوصيل</p>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">ملخص الطلب</h3>

                @if($cartItems->count() > 0)
                <div class="space-y-3 mb-4">
                    @foreach($cartItems as $item)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $item['product']->name }}</h4>
                            <p class="text-sm text-gray-500">
                                {{ $item['quantity'] }} × {{ number_format($item['product']->price, 2) }} ريال
                            </p>
                        </div>
                        <div class="text-amber-600 font-bold">
                            {{ number_format($item['product']->price * $item['quantity'], 2) }} ريال
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>المجموع الكلي:</span>
                        <span class="text-amber-600">{{ number_format($totalPrice, 2) }} ريال</span>
                    </div>
                </div>
                @else
                <p class="text-center text-gray-500">السلة فارغة</p>
                @endif
            </div>

            @if($cartItems->count() > 0)
            <!-- Delivery Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">تفاصيل التوصيل</h3>

                <div class="space-y-4">
                    <!-- User Info (Auto-filled) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الاسم</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                        <input type="text" value="{{ auth()->user()->phone }}" readonly class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-600">
                    </div>

                    <!-- Delivery Address -->
                    <div>
                        <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                            عنوان التوصيل <span class="text-red-500">*</span>
                        </label>
                        <textarea id="delivery_address" name="delivery_address" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500 @error('delivery_address') border-red-500 @enderror" placeholder="أدخل عنوان التوصيل بالتفصيل...">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Delivery Time -->
                    <div>
                        <label for="delivery_time" class="block text-sm font-medium text-gray-700 mb-2">
                            وقت التوصيل المفضل
                        </label>
                        <select id="delivery_time" name="delivery_time" class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                            <option value="">في أقرب وقت ممكن</option>
                            <option value="morning" {{ old('delivery_time') == 'morning' ? 'selected' : '' }}>صباحاً (8 ص - 12 ظ)</option>
                            <option value="afternoon" {{ old('delivery_time') == 'afternoon' ? 'selected' : '' }}>بعد الظهر (12 ظ - 4 م)</option>
                            <option value="evening" {{ old('delivery_time') == 'evening' ? 'selected' : '' }}>مساءً (4 م - 8 م)</option>
                            <option value="night" {{ old('delivery_time') == 'night' ? 'selected' : '' }}>ليلاً (8 م - 11 م)</option>
                        </select>
                    </div>

                    <!-- Special Instructions -->
                    <div>
                        <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                            ملاحظات خاصة
                        </label>
                        <textarea id="special_instructions" name="special_instructions" rows="2" class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" placeholder="أي طلبات خاصة أو ملاحظات...">{{ old('special_instructions') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">طريقة الدفع</h3>

                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="cash" checked class="text-amber-600 focus:ring-amber-500">
                        <div class="mr-3">
                            <i class="fas fa-money-bill-wave text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">دفع عند الاستلام</div>
                            <div class="text-sm text-gray-500">ادفع نقداً عند وصول الطلب</div>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 opacity-50">
                        <input type="radio" name="payment_method" value="card" disabled class="text-amber-600 focus:ring-amber-500">
                        <div class="mr-3">
                            <i class="fas fa-credit-card text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">الدفع الإلكتروني</div>
                            <div class="text-sm text-gray-500">قريباً...</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Order Buttons -->
            <div class="space-y-3">
                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-6 rounded-xl transition-colors duration-200">
                    <i class="fas fa-check ml-2"></i>
                    تأكيد الطلب
                </button>

                <a href="{{ route('cart.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-center block transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة للسلة
                </a>
            </div>
            @else
            <!-- Empty Cart Message -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا يمكن إتمام الطلب</h3>
                <p class="text-gray-600 mb-6">سلة التسوق فارغة</p>

                <a href="{{ route('menu.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-xl transition-colors duration-200">
                    <i class="fas fa-utensils ml-2"></i>
                    تصفح القائمة
                </a>
            </div>
            @endif
        </form>
    </div>
</x-user-layout>
