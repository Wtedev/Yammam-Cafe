<x-user-layout title="طلباتي">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">طلباتي</h1>
                    <p class="text-gray-600 mt-1">تابع حالة طلباتك الحالية والسابقة</p>
                </div>
                <div class="flex items-center space-x-4 space-x-reverse">
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        <i class="fas fa-shopping-bag mr-1"></i>
                        0 طلبات نشطة
                    </span>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <x-user.search-bar page="orders" />

        <!-- Order Status Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 space-x-reverse px-6" aria-label="Tabs">
                    <button class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        جميع الطلبات
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        قيد التحضير
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        مكتملة
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        ملغية
                    </button>
                </nav>
            </div>
        </div>

        <!-- Empty Content Area -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">لا توجد طلبات حالياً</h2>
                <p class="text-gray-500 mb-6">ابدأ بتصفح المنيو وإضافة المنتجات إلى سلة التسوق</p>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    تصفح المنيو
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>
        </div>
    </div>
</x-user-layout>
