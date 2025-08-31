<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سلة المشتريات - يمام كافيه</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-arabic" x-data="cartData()">

    <x-user-layout title="سلة المشتريات">
        <!-- Cart Wrapper -->
        <div class="max-w-6xl mx-auto space-y-4 sm:space-y-6" x-data="cartPage()">
            @if(count($cartItems) > 0)
            <!-- Items List -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-3 py-3 sm:px-4 sm:py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm sm:text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-cart-shopping text-blue-500"></i>
                        <span id="products-header-count">المنتجات ({{ $totalQuantity }})</span>
                    </h2>
                    <button onclick="clearCart()" class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1">
                        <i class="fas fa-trash"></i>
                        إفراغ السلة
                    </button>
                </div>
                <!-- Grid Container -->
                <div id="cart-items-wrapper" class="p-3 sm:p-4 space-y-3 sm:space-y-4">
                    @foreach($cartItems as $item)
                    @php($p = $item['product'])
                    <div id="cart-item-{{ $p->id }}" class="relative flex items-center gap-3 sm:gap-4 bg-white border border-gray-100 rounded-2xl p-3 sm:p-4 hover:border-blue-200 hover:shadow-md transition-all duration-200">
                        <!-- Image -->
                        <div class="relative w-16 h-16 sm:w-24 sm:h-24 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                            @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-mug-hot text-xl text-gray-400"></i>
                            </div>
                            @endif
                            @if(!$p->is_available)
                            <div class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                                <span class="text-[10px] font-bold text-red-600 bg-white px-2 py-1 rounded-md">غير متاح</span>
                            </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <!-- Product Info -->
                            <div class="mb-2 sm:mb-3">
                                <h3 class="font-bold text-gray-900 text-sm sm:text-base mb-1 line-clamp-1">{{ $p->name }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500">{{ number_format($p->price, 2) }} ر.س للقطعة</p>
                            </div>

                            <!-- Controls -->
                            <div class="flex flex-row sm:items-center justify-between gap-2 sm:gap-3">
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-2 sm:gap-3 bg-gray-50 rounded-xl p-1">
                                    <button onclick="changeQuantity({{ $p->id }}, -1, this)" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white hover:bg-gray-100 text-gray-600 hover:text-gray-800 flex items-center justify-center text-sm shadow-sm transition" aria-label="تنقيص الكمية">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span id="quantity-{{ $p->id }}" class="w-9 sm:w-10 text-center font-bold text-sm">{{ $item['quantity'] }}</span>
                                    <button onclick="changeQuantity({{ $p->id }}, 1, this)" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white hover:bg-gray-100 text-gray-600 hover:text-gray-800 flex items-center justify-center text-sm shadow-sm transition" aria-label="زيادة الكمية">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Price & Remove -->
                                <div class="flex items-center gap-3 sm:gap-4 p-1">
                                    <span id="subtotal-{{ $p->id }}" class="text-base sm:text-lg font-extrabold text-green-600 ml-2 sm:ml-3">{{ number_format($item['subtotal'], 2) }} ر.س</span>
                                    <button onclick="removeItem({{ $p->id }})" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-600 flex items-center justify-center text-sm transition group">
                                        <i class="fas fa-trash group-hover:scale-110 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary (Desktop + Sticky Mobile) -->
            <div class="lg:grid lg:grid-cols-3 lg:gap-6">
                <div class="lg:col-span-2"></div>
                <div class="lg:col-span-1">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 sm:p-5 space-y-4 sticky bottom-0 lg:static" id="cart-summary">
                        <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-receipt text-green-500"></i>
                            ملخص الطلب
                        </h3>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500">المجموع الفرعي</span>
                                <span id="subtotal-amount" class="font-bold text-gray-800">{{ number_format($total, 2) }} ر.س</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">التوصيل</span>
                                <span class="font-bold text-green-600">مجاني</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-sm">
                                <span class="font-extrabold">الإجمالي</span>
                                <span id="total-amount" class="font-extrabold text-green-600">{{ number_format($total, 2) }} ر.س</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <button onclick="clearCart()" class="w-full py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs flex items-center justify-center gap-1">
                                <i class="fas fa-trash"></i>
                                إفراغ السلة
                            </button>
                            <a href="{{ route('checkout.index') }}" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-sm flex items-center justify-center gap-2">
                                <i class="fas fa-credit-card"></i>
                                المتابعة للدفع
                            </a>
                            <a href="{{ route('menu.index') }}" class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs flex items-center justify-center gap-1">
                                <i class="fas fa-arrow-right"></i>
                                متابعة التسوق
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white border border-dashed border-gray-300 rounded-2xl shadow-sm p-8 sm:p-10 text-center max-w-md mx-auto">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-cart-shopping text-3xl text-gray-400"></i>
                </div>
                <h2 class="text-lg font-extrabold text-gray-800 mb-2">سلة المشتريات فارغة</h2>
                <p class="text-sm text-gray-500 mb-6">أضف منتجات من قائمة المقهى وستظهر هنا</p>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-sm">
                    <i class="fas fa-mug-hot"></i>
                    استعراض المنتجات
                </a>
            </div>
            @endif
        </div>
    </x-user-layout>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="fixed top-4 left-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 left-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
        {{ session('error') }}
    </div>
    @endif

    <script>
        function cartData() {
            return {
                loading: false
            }
        }

        function cartPage() {
            return {}
        };

        function updateQuantity(productId, newQuantity, btn = null) {
            if (newQuantity < 0 || newQuantity > 10) return; // حدود الكمية

            // استخدام الزر الممرر بدل الاعتماد على event
            const button = btn || null;
            let originalHTML = '';

            if (button) {
                originalHTML = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            fetch(`/cart/update/${productId}`, {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        , 'Accept': 'application/json'
                        , 'X-Requested-With': 'XMLHttpRequest'
                    }
                    , body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                .then(r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(data => {
                    if (data.success) {
                        if (newQuantity === 0) {
                            const li = document.getElementById(`cart-item-${productId}`);
                            if (li) {
                                li.style.opacity = '0';
                                li.style.transform = 'translateX(20px)';
                                li.style.transition = 'all 0.3s ease';
                                setTimeout(() => {
                                    li.remove();
                                    if (data.totalQuantity === 0) showEmptyCart();
                                }, 300);
                            }
                        } else {
                            document.getElementById(`quantity-${productId}`).textContent = newQuantity;
                            const subtotalEl = document.getElementById(`subtotal-${productId}`);
                            subtotalEl.textContent = (data.product_price * newQuantity).toFixed(2) + ' ر.س';
                            subtotalEl.classList.add('text-blue-600');
                            setTimeout(() => subtotalEl.classList.remove('text-blue-600'), 400);
                        }
                        document.getElementById('subtotal-amount').textContent = data.totalPrice.toFixed(2) + ' ر.س';
                        document.getElementById('total-amount').textContent = data.totalPrice.toFixed(2) + ' ر.س';

                        // تحديث عنوان عدد المنتجات
                        updateProductsHeaderCount();

                        updateHeaderCartBadge();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('خطأ في التحديث: ' + err.message);
                })
                .finally(() => {
                    if (button) {
                        button.innerHTML = originalHTML;
                        button.disabled = false;
                    }
                });
        }

        function changeQuantity(productId, delta, el) {
            const qtyEl = document.getElementById(`quantity-${productId}`);
            if (!qtyEl) return;
            const current = parseInt(qtyEl.textContent.trim()) || 0;
            const newQty = current + delta;
            updateQuantity(productId, newQty, el);
        }

        function removeItem(productId) {
            if (!confirm('هل أنت متأكد من حذف هذا المنتج؟')) return;

            // تخزين مرجع للزر قبل عرض مؤشر التحميل
            const button = event ? event.target.closest('button') : null;
            let originalHTML = '';

            if (button) {
                originalHTML = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
            }

            fetch(`/cart/remove/${productId}`, {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        , 'Accept': 'application/json'
                        , 'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text().then(text => {
                        console.log('Raw response:', text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('JSON parse error:', e);
                            console.error('Response text:', text);
                            throw new Error('Response is not valid JSON: ' + text.substring(0, 100));
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        // إزالة العنصر بتأثير بصري
                        const li = document.getElementById(`cart-item-${productId}`);
                        if (li) {
                            li.style.opacity = '0';
                            li.style.transform = 'translateX(20px)';
                            li.style.transition = 'all 0.3s ease';

                            setTimeout(() => {
                                // حذف العنصر فعلياً من DOM
                                if (li.parentNode) li.parentNode.removeChild(li);

                                // تحديث ملخص السلة
                                document.getElementById('subtotal-amount').textContent = data.totalPrice.toFixed(2) + ' ر.س';
                                document.getElementById('total-amount').textContent = data.totalPrice.toFixed(2) + ' ر.س';

                                // فحص عدد العناصر المتبقية
                                const remainingItems = document.querySelectorAll('#cart-items-wrapper > div').length;
                                if (remainingItems === 0 || data.totalQuantity === 0) {
                                    showEmptyCart();
                                } else {
                                    // تحديث عنوان عدد المنتجات
                                    updateProductsHeaderCount();
                                }

                                // استعادة الزر بعد إتمام العملية
                                if (button) {
                                    button.innerHTML = originalHTML;
                                    button.disabled = false;
                                }

                                // تحديث شارة السلة في الهيدر
                                updateHeaderCartBadge();
                            }, 300);
                        } else {
                            // استعادة الزر في حالة عدم وجود العنصر
                            if (button) {
                                button.innerHTML = originalHTML;
                                button.disabled = false;
                            }
                        }
                    } else {
                        // استعادة الزر إذا كان هناك خطأ
                        if (button) {
                            button.innerHTML = originalHTML;
                            button.disabled = false;
                        }
                        console.error('Error:', data.message);
                        alert(data.message || 'حدث خطأ أثناء حذف المنتج');
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
                    console.error('Error message:', error.message);
                    console.error('Product ID:', productId);

                    // استعادة الزر
                    if (button) {
                        button.innerHTML = originalHTML;
                        button.disabled = false;
                    }
                    // عرض رسالة خطأ واضحة
                    alert('حدث خطأ أثناء محاولة حذف المنتج: ' + error.message);
                });
        }

        function clearCart() {
            if (!confirm('هل أنت متأكد من إفراغ السلة بالكامل؟')) return;

            const clearButton = event ? event.target.closest('button') : null;
            let originalHTML = '';

            if (clearButton) {
                originalHTML = clearButton.innerHTML;
                clearButton.innerHTML = '<i class="fas fa-spinner fa-spin ml-1"></i> جاري الإفراغ...';
                clearButton.disabled = true;
            }

            fetch('/cart/clear', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        , 'Accept': 'application/json'
                        , 'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // تأثير بصري قبل عرض حالة السلة الفارغة
                        const itemsContainer = document.getElementById('cart-items-wrapper');
                        const cartSummary = document.getElementById('cart-summary');

                        if (itemsContainer) {
                            itemsContainer.style.opacity = '0';
                            itemsContainer.style.transition = 'opacity 0.5s ease';
                        }

                        if (cartSummary) {
                            cartSummary.style.opacity = '0';
                            cartSummary.style.transition = 'opacity 0.5s ease';
                        }

                        setTimeout(() => {
                            showEmptyCart();

                            // استعادة الزر بعد إظهار السلة الفارغة (للتأكيد البصري للمستخدم)
                            if (clearButton) {
                                clearButton.innerHTML = originalHTML;
                                clearButton.disabled = false;
                            }

                            // تحديث شارة السلة في الهيدر
                            updateHeaderCartBadge();
                        }, 500);
                    } else {
                        // استعادة الزر إذا كان هناك خطأ
                        if (clearButton) {
                            clearButton.innerHTML = originalHTML;
                            clearButton.disabled = false;
                        }
                        alert(data.message || 'حدث خطأ أثناء إفراغ السلة');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // استعادة الزر
                    if (clearButton) {
                        clearButton.innerHTML = originalHTML;
                        clearButton.disabled = false;
                    }

                    alert('حدث خطأ أثناء محاولة إفراغ السلة: ' + error.message);
                });
        }

        function updateHeaderCartBadge() {
            fetch('/cart/count', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                }
            }).then(r => r.json()).then(data => {
                const badge = document.querySelector('.cart-badge');
                if (badge) badge.textContent = data.count;
            });
        }

        // دالة لتحديث عدد المنتجات في العنوان
        function updateProductsHeaderCount() {
            // حساب إجمالي الكمية من جميع المنتجات الظاهرة
            let totalQuantity = 0;
            document.querySelectorAll('[id^="quantity-"]').forEach(el => {
                const qty = parseInt(el.textContent.trim()) || 0;
                totalQuantity += qty;
            });

            // تحديث النص في العنوان
            const headerElement = document.getElementById('products-header-count');
            if (headerElement) {
                headerElement.textContent = `المنتجات (${totalQuantity})`;
            }
        }

        // دالة لعرض حالة السلة الفارغة بدون إعادة تحميل الصفحة
        function showEmptyCart() {
            // الحصول على العناصر المطلوبة
            const cartContainer = document.querySelector('.max-w-6xl.mx-auto.space-y-6');
            if (!cartContainer) return;

            // إنشاء حالة السلة الفارغة
            const emptyCartHTML = `
                <div class="bg-white border border-dashed border-gray-300 rounded-2xl shadow-sm p-10 text-center max-w-md mx-auto">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-cart-shopping text-3xl text-gray-400"></i>
                    </div>
                    <h2 class="text-lg font-extrabold text-gray-800 mb-2">سلة المشتريات فارغة</h2>
                    <p class="text-sm text-gray-500 mb-6">أضف منتجات من قائمة المقهى وستظهر هنا</p>
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-sm">
                        <i class="fas fa-mug-hot"></i>
                        استعراض المنتجات
                    </a>
                </div>
            `;

            // إخفاء محتوى السلة الحالي
            cartContainer.innerHTML = '';

            // إضافة حالة السلة الفارغة مع تأثير تدريجي
            const emptyCartDiv = document.createElement('div');
            emptyCartDiv.innerHTML = emptyCartHTML;
            emptyCartDiv.style.opacity = '0';
            emptyCartDiv.style.transition = 'opacity 0.5s ease';

            cartContainer.appendChild(emptyCartDiv);

            // إظهار حالة السلة الفارغة بتأثير تدريجي
            setTimeout(() => {
                emptyCartDiv.style.opacity = '1';
            }, 100);
        }

    </script>

</body>
</html>
