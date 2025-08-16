<x-user-layout title="الرئيسية">
    <div class="max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-600 to-purple-700 rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            <div class="relative px-6 py-12 md:py-16 text-center text-white">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-3xl md:text-5xl font-bold mb-4">
                        مرحباً بك في
                        <span class="text-yellow-300">يمام كافيه</span>
                    </h1>
                    <p class="text-lg md:text-xl mb-6 text-blue-100">
                        استمتع بأفضل المشروبات والحلويات المُحضرة بعناية فائقة
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('menu.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-colors shadow-sm">
                            <i class="fas fa-coffee ml-2"></i>
                            تصفح المنيو
                        </a>
                        @auth
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-white text-blue-600 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                            <i class="fas fa-shopping-cart ml-2"></i>
                            السلة
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-white text-blue-600 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                            <i class="fas fa-sign-in-alt ml-2"></i>
                            تسجيل الدخول
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        @if($weeklyProducts->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">منتجات الأسبوع</h2>
                <a href="{{ route('menu.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
                    مشاهدة الكل
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($weeklyProducts as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-purple-50 overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="relative aspect-square bg-purple-50">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-purple-300 bg-gradient-to-br from-purple-100 to-purple-200">
                            <i class="fas fa-{{ $product->getIconClass() }} text-5xl"></i>
                        </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="bg-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                <i class="fas fa-star mr-1"></i>
                                مميز
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 font-bold text-lg">{{ number_format($product->price, 2) }} ر.س</span>
                            @auth
                            <button onclick="addToCart({{ $product->id }}, event)" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                                إضافة
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="bg-gray-400 text-white px-3 py-1 rounded-lg text-sm">
                                تسجيل دخول
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Popular Products Section -->
        @if($popularProducts->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">الأكثر طلباً</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($popularProducts as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-orange-50 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-orange-50 rounded-xl flex-shrink-0 flex items-center justify-center">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                            @else
                            <i class="fas fa-{{ $product->getIconClass() }} text-orange-500 text-2xl"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 50) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-green-600 font-bold">{{ number_format($product->price, 2) }} ر.س</span>
                                <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded-full">
                                    {{ $product->order_count }} طلب
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Categories Tabs (like menu) -->
        @if($categories->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-900">تصفح حسب الفئة</h2>
                <a href="{{ route('menu.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
                    عرض المنيو
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>

            <!-- Tabs rail -->
            <div class="bg-gray-50 rounded-full px-3 py-2 overflow-x-auto scrollbar-hide">
                <div class="flex gap-2 min-w-max">
                    <a href="{{ route('home') }}" class="px-6 py-3 rounded-full text-sm font-medium {{ !request('category') ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }}">الكل</a>
                    @foreach($categories as $category)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $category->id]) }}" class="px-6 py-3 rounded-full text-sm font-medium {{ request('category') == $category->id ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

            @php
                $showProducts = true; // always show grid
                $productsToShow = request('category') ? $categoryProducts : $allProducts;
            @endphp

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($productsToShow as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="relative aspect-square bg-blue-50/40">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gradient-to-br from-blue-400 to-blue-600">
                            <i class="fas fa-{{ $product->getIconClass() }} text-white text-5xl"></i>
                        </div>
                        @endif
                        @if($product->type === 'weekly')
                        <span class="absolute top-3 left-3 bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full border border-purple-300">منتج الأسبوع</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                        @if($product->description)
                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-green-700 font-bold">{{ number_format($product->price, 2) }} ر.س</span>
                            @auth
                            <button onclick="addToCart({{ $product->id }}, event)" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">إضافة</button>
                            @else
                            <a href="{{ route('login') }}" class="bg-gray-400 text-white px-3 py-1 rounded-lg text-sm">تسجيل دخول</a>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                        <p class="text-gray-600">لا توجد منتجات ضمن هذه الفئة حالياً</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @auth
            <div class="bg-white rounded-2xl shadow-sm border border-green-50 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-clock text-green-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">طلباتي الحالية</h3>
                        <p class="text-gray-600 text-sm">تابع حالة طلباتك الجارية</p>
                    </div>
                    <a href="{{ route('my-orders') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors shadow-sm">
                        مشاهدة
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-6 hover:shadow-md transition-shadow group">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-comment-alt text-blue-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">شاركنا رأيك</h3>
                        <p class="text-gray-600 text-sm">ساعدنا في تحسين خدماتنا</p>
                    </div>
                    <a href="{{ route('suggestions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors shadow-sm">
                        اقتراح
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-sm border border-purple-50 p-8 hover:shadow-md transition-shadow col-span-full">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">انضم إلينا اليوم</h3>
                    <p class="text-gray-600 mb-6">سجل حساباً جديداً واستمتع بتجربة طلب مميزة</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600 transition-colors shadow-sm">
                            <i class="fas fa-user-plus ml-2"></i>
                            إنشاء حساب جديد
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-purple-300 text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-colors">
                            <i class="fas fa-sign-in-alt ml-2"></i>
                            تسجيل الدخول
                        </a>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>

    @auth
    <script>
        function addToCart(productId, event) {
            event.preventDefault();

            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                button.innerHTML = originalText;
                button.disabled = false;
                return;
            }

            fetch(`/cart/add/${productId}`, {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        , 'Accept': 'application/json'
                        , 'X-Requested-With': 'XMLHttpRequest'
                    }
                    , body: JSON.stringify({
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    button.innerHTML = originalText;
                    button.disabled = false;

                    if (data.success) {
                        // Update cart count
                        const cartBadge = document.querySelector('.cart-badge');
                        if (cartBadge) {
                            cartBadge.textContent = data.cart_count;
                            cartBadge.classList.add('animate-pulse');
                            setTimeout(() => cartBadge.classList.remove('animate-pulse'), 600);
                        }

                        // Show success message
                        showToast(`تم إضافة ${data.product_name} إلى السلة`, 'success');
                    } else {
                        showToast(data.message || 'حدث خطأ', 'error');
                    }
                })
                .catch(error => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showToast('حدث خطأ أثناء إضافة المنتج', 'error');
                });
        }

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : 'times'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

    </script>
    @endauth
</x-user-layout>
