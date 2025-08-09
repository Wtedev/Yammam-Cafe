<x-user-layout title="يمامة كافيه - الصفحة الرئيسية">
    <!-- العنوان الترحيبي -->
    <section class="bg-gradient-to-br from-soft-cream to-soft-beige py-8">
        <div class="max-w-lg mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">مرحباً بك في يمامة كافيه</h1>
            <h2 class="text-xl font-semibold text-soft-brown mb-6">تصفح منتجات الأسبوع الرهيبة!</h2>
        </div>
    </section>

    <!-- منتجات الأسبوع -->
    <section class="py-8 bg-soft-cream">
        <div class="max-w-lg mx-auto px-4">
            @if($weeklyProducts->count() > 0)
            <!-- السلايدر -->
            <div class="weekly-products-slider overflow-x-auto pb-4">
                <div class="flex gap-4" style="width: max-content;">
                    @foreach($weeklyProducts as $product)
                    <div class="w-80 md:w-96 lg:w-[420px]">
                        <x-weekly-product-card :product="$product" />
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- مؤشرات السلايدر -->
            @if($weeklyProducts->count() > 1)
            <div class="flex justify-center mt-4 gap-2">
                @foreach($weeklyProducts as $index => $product)
                <div class="slider-dot w-2 h-2 rounded-full bg-gray-400 transition-all duration-300 cursor-pointer" data-slide="{{ $index }}"></div>
                @endforeach
            </div>
            @endif
            @else
            <div class="text-center py-12">
                <div class="text-6xl text-gray-400 mb-4">⏰</div>
                <p class="text-warm-gray text-lg font-medium">ترقب منتجات الأسبوع</p>
            </div>
            @endif
        </div>
    </section>

    <!-- أقسام الكافيه -->
    @if($categories->count() > 0)
    <section class="py-8 bg-soft-beige">
        <div class="max-w-lg mx-auto px-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">أقسام الكافيه</h3>

            <div class="grid grid-cols-2 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('menu.index') }}?category={{ $category->slug }}" class="group bg-white rounded-2xl overflow-hidden hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center p-4">
                        <div class="text-5xl mb-2 transform group-hover:scale-110 transition-transform duration-300">
                            @switch($category->name)
                            @case('مشروبات ساخنة')
                            <span class="inline-block bg-red-100 p-4 rounded-full">☕</span>
                            @break
                            @case('مشروبات باردة')
                            <span class="inline-block bg-blue-100 p-4 rounded-full">🥤</span>
                            @break
                            @case('قهوة مختصة')
                            <span class="inline-block bg-amber-100 p-4 rounded-full">☕</span>
                            @break
                            @case('مأكولات خفيفة')
                            <span class="inline-block bg-green-100 p-4 rounded-full">🥪</span>
                            @break
                            @case('حلويات')
                            <span class="inline-block bg-pink-100 p-4 rounded-full">🍰</span>
                            @break
                            @case('مثلجات')
                            <span class="inline-block bg-blue-100 p-4 rounded-full">🍦</span>
                            @break
                            @default
                            <span class="inline-block bg-gray-100 p-4 rounded-full">🍽️</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-amber-600 transition-colors">{{ $category->name }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- المنتجات الأكثر طلباً -->
    @if($popularProducts->count() > 0)
    <section class="py-8 bg-soft-cream">
        <div class="max-w-lg mx-auto px-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">المنتجات الأكثر طلباً</h3>

            <div class="space-y-4">
                @foreach($popularProducts as $product)
                <x-popular-product-card :product="$product" />
                @endforeach
            </div>

            <!-- رابط لعرض المزيد -->
            <div class="text-center mt-6">
                <a href="{{ route('menu.index') }}" class="inline-block bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-utensils ml-2"></i>
                    تصفح القائمة كاملة
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Call to Action -->
    @guest
    <section class="py-12 bg-gray-800">
        <div class="max-w-lg mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">جرب تطبيقنا الآن!</h3>
            <p class="text-gray-300 mb-6">اطلب من مكتبك بسهولة واستلم طلبك في الوقت المحدد</p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-gray-800 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-user-plus ml-2"></i>
                سجل الآن
            </a>
        </div>
    </section>
    @endguest

    <!-- تفعيل أزرار إضافة للسلة -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof initializeCartButtons === 'function') {
                initializeCartButtons();
            }

            // تفعيل السلايدر
            initializeWeeklyProductsSlider();
        });

        function initializeWeeklyProductsSlider() {
            const slider = document.querySelector('.weekly-products-slider');
            const dots = document.querySelectorAll('.slider-dot');

            if (!slider || dots.length === 0) return;

            let currentSlide = 0;
            const slides = slider.querySelectorAll('[class*="w-"]');

            // تحديث المؤشرات
            function updateDots() {
                dots.forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            // الانتقال إلى شريحة معينة
            function goToSlide(index) {
                if (slides[index]) {
                    const slideWidth = slides[index].offsetWidth + 16; // العرض + المسافة
                    slider.scrollTo({
                        left: slideWidth * index
                        , behavior: 'smooth'
                    });
                    currentSlide = index;
                    updateDots();
                }
            }

            // إضافة مستمعي الأحداث للمؤشرات
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });

            // تهيئة المؤشر الأول
            updateDots();

            // تمرير تلقائي (اختياري)
            let autoSlideInterval = setInterval(() => {
                const nextSlide = (currentSlide + 1) % slides.length;
                goToSlide(nextSlide);
            }, 5000);

            // إيقاف التمرير التلقائي عند التفاعل
            slider.addEventListener('touchstart', () => clearInterval(autoSlideInterval));
            slider.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));

            // استئناف التمرير التلقائي
            slider.addEventListener('mouseleave', () => {
                autoSlideInterval = setInterval(() => {
                    const nextSlide = (currentSlide + 1) % slides.length;
                    goToSlide(nextSlide);
                }, 5000);
            });
        }

    </script>
</x-user-layout>
