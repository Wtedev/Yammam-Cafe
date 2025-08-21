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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <i class="fas fa-coffee text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">تصفح المنيو</h3>
                <p class="text-gray-600 mb-4">اكتشف مجموعة واسعة من المشروبات الساخنة والباردة</p>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    تصفح الآن
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>

            @auth
            <div class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <i class="fas fa-shopping-bag text-4xl text-green-600 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">طلباتي</h3>
                <p class="text-gray-600 mb-4">تابع حالة طلباتك وتاريخ الطلبات السابقة</p>
                <a href="{{ route('my-orders') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    مشاهدة الطلبات
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <i class="fas fa-lightbulb text-4xl text-yellow-600 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">اقتراحاتي</h3>
                <p class="text-gray-600 mb-4">شاركنا آرائك واقتراحاتك لتحسين الخدمة</p>
                <a href="{{ route('my-suggestions') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    إضافة اقتراح
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>
            @endauth
        </div>

        <!-- Empty Content Area -->
        <div class="bg-white rounded-lg shadow-sm p-8 mt-6 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">مساحة جاهزة للمحتوى</h2>
                <p class="text-gray-500">هذه المساحة فارغة ويمكن إضافة المحتوى المطلوب هنا</p>
            </div>
        </div>
    </div>
</x-user-layout>
