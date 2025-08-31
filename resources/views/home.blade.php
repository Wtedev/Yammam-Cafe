<x-user-layout title="الرئيسية">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">مرحباً بك في يمام كافيه</h1>
                <p class="text-gray-600">استمتع بأفضل المشروبات والحلويات</p>
            </div>
        </div>

        <!-- Quick Action Cards -->
        <div class="flex flex-col gap-6 lg:gap-6">
            <!-- Browse Menu Card -->
            <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-700 transition-colors">
                        <i class="fas fa-coffee text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">تصفح المنيو</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">اكتشف مجموعة واسعة من المشروبات الساخنة والباردة</p>
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                        <span>تصفح الآن</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Weekly Products Slider -->
        @if($weeklyProducts && $weeklyProducts->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6" x-data="weeklySlider()">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">منتجات الأسبوع</h2>
                <!-- Slider Controls - All screens -->
                <div class="flex items-center gap-2">
                    <button @click="previousSlide()" :disabled="isPrevDisabled()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors" :class="{ 'opacity-50 cursor-not-allowed': isPrevDisabled() }">
                        <i class="fas fa-chevron-right text-gray-600"></i>
                    </button>
                    <span class="text-sm text-gray-500 px-2 lg:hidden" x-text="`${currentSlide + 1} من ${totalSlides}`"></span>
                    <span class="text-sm text-gray-500 px-2 hidden lg:block" x-text="`صفحة ${currentSlide === 0 ? 1 : 2} من ${totalSlides > 4 ? 2 : 1}`"></span>
                    <button @click="nextSlide()" :disabled="isNextDisabled()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors" :class="{ 'opacity-50 cursor-not-allowed': isNextDisabled() }">
                        <i class="fas fa-chevron-left text-gray-600"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Slider View -->
            <div class="flex justify-center lg:hidden">
                <div class="w-full max-w-sm">
                    @foreach($weeklyProducts as $index => $product)
                    <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-10" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-10" class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden relative group transition hover:shadow-md h-auto">

                        <!-- Product Image -->
                        <div class="relative w-full bg-blue-50/40 aspect-square flex-shrink-0">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gradient-to-br from-blue-400 to-blue-600">
                                <i class="fas fa-{{ $product->getIconClass() ?? 'mug-hot' }} text-white text-6xl"></i>
                            </div>
                            @endif

                            <!-- Tags Container (Top Left) -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2 z-10">
                                <!-- Weekly Product Badge -->
                                @if($product->type === 'weekly')
                                <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full border border-purple-300">
                                    <i class="fas fa-star mr-1"></i>
                                    منتج الأسبوع
                                </span>
                                @endif

                                <!-- Low Stock Badge -->
                                @if($product->stock_quantity <= 3 && $product->stock_quantity > 0)
                                    <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full border border-orange-300">
                                        <i class="fas fa-exclamation-triangle mr-1 text-orange-500"></i>
                                        قرب يخلّص
                                    </span>
                                    @endif
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="flex-1 flex flex-col p-4 gap-2 overflow-visible">
                            <h3 class="text-base font-extrabold text-gray-900 mb-1">{{ $product->name }}</h3>

                            @if($product->description)
                            <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                            @endif

                            <!-- Price Info -->
                            <div class="flex items-center flex-wrap gap-2 mb-1">
                                <span class="text-green-700 font-bold text-lg">{{ number_format($product->price, 2) }} ر.س</span>
                            </div>

                            <!-- Calories and Walking Time -->
                            @if($product->calories || $product->walking_time)
                            <div class="flex items-center gap-4 mb-2">
                                @if($product->calories)
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-fire text-orange-500 text-sm"></i>
                                    <span class="text-xs text-gray-600">{{ $product->calories }} سعرة</span>
                                </div>
                                @endif

                                @if($product->walking_time)
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-walking text-blue-500 text-sm"></i>
                                    <span class="text-xs text-gray-600">{{ $product->walking_time }} دقيقة مشي</span>
                                </div>
                                @endif
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-auto flex items-center gap-2 pt-3 flex-shrink-0 border-t border-gray-100">
                                <div class="flex w-full pt-2">
                                    @auth
                                    <button onclick="addToCart({{ $product->id }}, event)" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-xl font-bold text-xs transition shadow-sm flex items-center justify-center">
                                        <i class="fas fa-cart-plus ml-1"></i>
                                        إضافة للسلة
                                    </button>
                                    @else
                                    <a href="{{ route('login') }}" class="w-full bg-gray-400 hover:bg-gray-500 text-white text-center py-2 rounded-xl font-bold text-xs transition shadow-sm flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt ml-1"></i>
                                        تسجيل دخول
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Desktop Grid View -->
            <div class="hidden lg:grid lg:grid-cols-4 gap-6">
                @foreach($weeklyProducts as $index => $product)
                <div x-show="(currentSlide === 0 && {{ $index }} < 4) || (currentSlide > 0 && {{ $index }} >= 4)" class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden relative group transition hover:shadow-md h-auto">
                    <!-- Product Image -->
                    <div class="relative w-full bg-blue-50/40 aspect-square flex-shrink-0">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gradient-to-br from-blue-400 to-blue-600">
                            <i class="fas fa-{{ $product->getIconClass() ?? 'mug-hot' }} text-white text-6xl"></i>
                        </div>
                        @endif

                        <!-- Tags Container (Top Left) -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2 z-10">
                            <!-- Weekly Product Badge -->
                            @if($product->type === 'weekly')
                            <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full border border-purple-300">
                                <i class="fas fa-star mr-1"></i>
                                منتج الأسبوع
                            </span>
                            @endif

                            <!-- Low Stock Badge -->
                            @if($product->stock_quantity <= 3 && $product->stock_quantity > 0)
                                <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full border border-orange-300">
                                    <i class="fas fa-exclamation-triangle mr-1 text-orange-500"></i>
                                    قرب يخلّص
                                </span>
                                @endif
                        </div>
                    </div>

                    <!-- Product Content -->
                    <div class="flex-1 flex flex-col p-4 gap-2 overflow-visible">
                        <h3 class="text-base font-extrabold text-gray-900 mb-1">{{ $product->name }}</h3>

                        @if($product->description)
                        <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                        @endif

                        <!-- Price Info -->
                        <div class="flex items-center flex-wrap gap-2 mb-1">
                            <span class="text-green-700 font-bold text-lg">{{ number_format($product->price, 2) }} ر.س</span>
                        </div>

                        <!-- Calories and Walking Time -->
                        @if($product->calories || $product->walking_time)
                        <div class="flex items-center gap-4 mb-2">
                            @if($product->calories)
                            <div class="flex items-center gap-1">
                                <i class="fas fa-fire text-orange-500 text-sm"></i>
                                <span class="text-xs text-gray-600">{{ $product->calories }} سعرة</span>
                            </div>
                            @endif

                            @if($product->walking_time)
                            <div class="flex items-center gap-1">
                                <i class="fas fa-walking text-blue-500 text-sm"></i>
                                <span class="text-xs text-gray-600">{{ $product->walking_time }} دقيقة مشي</span>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mt-auto flex items-center gap-2 pt-3 flex-shrink-0 border-t border-gray-100">
                            <div class="flex w-full pt-2">
                                @auth
                                <button onclick="addToCart({{ $product->id }}, event)" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-xl font-bold text-xs transition shadow-sm flex items-center justify-center">
                                    <i class="fas fa-cart-plus ml-1"></i>
                                    إضافة للسلة
                                </button>
                                @else
                                <a href="{{ route('login') }}" class="w-full bg-gray-400 hover:bg-gray-500 text-white text-center py-2 rounded-xl font-bold text-xs transition shadow-sm flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt ml-1"></i>
                                    تسجيل دخول
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Dots Indicator - Mobile only -->
            <div class="flex justify-center mt-6 gap-2 lg:hidden">
                @foreach($weeklyProducts as $index => $product)
                <button @click="goToSlide({{ $index }})" class="w-3 h-3 rounded-full transition-colors" :class="currentSlide === {{ $index }} ? 'bg-purple-600' : 'bg-gray-300 hover:bg-gray-400'">
                </button>
                @endforeach
            </div>
        </div>

        <script>
            function weeklySlider() {
                return {
                    currentSlide: 0
                    , totalSlides: {
                        {
                            $weeklyProducts - > count()
                        }
                    },

                    nextSlide() {
                        const isDesktop = window.innerWidth >= 1024;

                        if (isDesktop) {
                            // للديسكتوب: التنقل بـ 4 منتجات
                            if (this.totalSlides > 4 && this.currentSlide === 0) {
                                this.currentSlide = Math.min(4, this.totalSlides - 4);
                            }
                        } else {
                            // للموبايل: التنقل بمنتج واحد
                            if (this.currentSlide < this.totalSlides - 1) {
                                this.currentSlide++;
                            }
                        }
                    },

                    previousSlide() {
                        const isDesktop = window.innerWidth >= 1024;

                        if (isDesktop) {
                            // للديسكتوب: العودة للصفحة الأولى
                            if (this.currentSlide > 0) {
                                this.currentSlide = 0;
                            }
                        } else {
                            // للموبايل: التنقل بمنتج واحد
                            if (this.currentSlide > 0) {
                                this.currentSlide--;
                            }
                        }
                    },

                    goToSlide(index) {
                        this.currentSlide = index;
                    },

                    // Helper method to check if next button should be disabled
                    isNextDisabled() {
                        const isDesktop = window.innerWidth >= 1024;
                        if (isDesktop) {
                            // للديسكتوب: معطل إذا كنا في الصفحة الثانية أو إذا كان عدد المنتجات 4 أو أقل
                            return this.totalSlides <= 4 || this.currentSlide > 0;
                        } else {
                            // للموبايل: معطل إذا كنا في المنتج الأخير
                            return this.currentSlide >= this.totalSlides - 1;
                        }
                    },

                    // Helper method to check if previous button should be disabled
                    isPrevDisabled() {
                        return this.currentSlide <= 0;
                    }
                }
            }

            // Cart functionality for weekly products
            function addToCart(productId, event) {
                event.preventDefault();

                // Show loading indicator on button
                const button = event.target.closest('button');
                if (!button) return;

                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin ml-1"></i> جاري الإضافة...';
                button.disabled = true;

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    showMessage('خطأ في الأمان: توكن CSRF غير موجود', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                    return;
                }

                console.log('Adding product to cart:', productId);

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
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            return response.json().then(data => {
                                console.error('Server error:', data);
                                throw new Error(data.message || `HTTP error! Status: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Cart add response:', data);

                        // Restore button
                        setTimeout(() => {
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }, 500);

                        if (data.success) {
                            // Update cart count with server response
                            updateCartBadge(data.cart_count);

                            // Show success message
                            showMessage(`تم إضافة ${data.product_name} إلى السلة`, 'success');

                            // Add animation effect to the cart icon in header
                            animateCartIcon();
                        } else {
                            showMessage(data.message || 'حدث خطأ أثناء إضافة المنتج', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error adding to cart:', error);
                        showMessage(error.message || 'حدث خطأ أثناء إضافة المنتج للسلة', 'error');

                        // Restore button
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
            }

            // Update cart badge with exact count
            function updateCartBadge(count) {
                console.log('Updating cart badge to:', count);

                // Try multiple selectors to find the cart badge
                const cartBadgeSelectors = [
                    '.cart-badge'
                    , '[data-cart-count]'
                    , '.cart-count'
                    , '#cart-count'
                    , '.badge-cart'
                    , '.header-cart-count'
                ];

                let cartBadge = null;
                for (const selector of cartBadgeSelectors) {
                    cartBadge = document.querySelector(selector);
                    if (cartBadge) {
                        console.log('Found cart badge with selector:', selector);
                        break;
                    }
                }

                if (!cartBadge) {
                    console.error('Cart badge element not found. Available elements:', document.querySelectorAll('[class*="cart"], [class*="badge"]'));
                    return;
                }

                cartBadge.textContent = count;
                cartBadge.classList.add('animate-pulse');
                setTimeout(() => cartBadge.classList.remove('animate-pulse'), 600);
            }

            function animateCartIcon() {
                const cartIcon = document.querySelector('.fa-shopping-cart, .fa-cart-shopping');
                if (cartIcon) {
                    cartIcon.classList.add('animate-bounce');
                    setTimeout(() => cartIcon.classList.remove('animate-bounce'), 1000);
                }
            }

            function showMessage(message, type) {
                console.log('Showing message:', message, type);

                // Remove any existing messages first
                const existingMessages = document.querySelectorAll('.toast-message');
                existingMessages.forEach(msg => msg.remove());

                const messageDiv = document.createElement('div');
                messageDiv.className = `toast-message fixed top-4 left-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white p-4 rounded-lg shadow-lg z-50 flex items-center justify-between mx-auto max-w-md`;

                // Add icon based on message type
                const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
                messageDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${icon} mr-2 text-xl"></i>
                    <span>${message}</span>
                </div>
                <button class="text-white hover:text-gray-200 mr-2" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

                document.body.appendChild(messageDiv);

                // Auto-hide after 3 seconds
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        messageDiv.remove();
                    }
                }, 3000);
            }

        </script>
        @endif

        <!-- User Action Cards - After Weekly Products -->
        @auth
        <div class="flex flex-col gap-6 w-full mt-6">
            <!-- My Orders Card (Simple Horizontal) -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-shadow w-full">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">طلباتي</h3>
                            <p class="text-sm text-gray-500">تابع حالة طلباتك</p>
                        </div>
                    </div>
                    <a href="{{ route('my-orders') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                        <span>عرض</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>

            <!-- My Suggestions Card (Simple Horizontal) -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition-shadow w-full">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-lightbulb text-yellow-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">اقتراحاتي</h3>
                            <p class="text-sm text-gray-500">شاركنا آرائك</p>
                        </div>
                    </div>
                    <a href="{{ route('my-suggestions') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                        <span>إضافة</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        @endauth

        <!-- Contact Developer Link -->
        <div class="max-w-7xl mx-auto mt-6 text-center">
            <a href="{{ route('contact.developer') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                <i class="fas fa-code text-sm"></i>
                <span class="text-sm">تواصل مع المطور</span>
            </a>
        </div>
    </div>
</x-user-layout>
