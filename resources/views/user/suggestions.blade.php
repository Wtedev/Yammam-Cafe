<x-user-layout title="اقتراحاتي">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">اقتراحاتي</h1>
                    <p class="text-gray-600 mt-1">شاركنا آرائك واقتراحاتك لتحسين الخدمة</p>
                </div>
                <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة اقتراح جديد
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <x-user.search-bar page="suggestions" />

        <!-- Suggestion Types -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 space-x-reverse px-6" aria-label="Tabs">
                    <button class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        جميع الاقتراحات
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        اقتراحات
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        شكاوى
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        استفسارات
                    </button>
                </nav>
            </div>
        </div>

        <!-- Empty Content Area -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-lightbulb text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">لا توجد اقتراحات بعد</h2>
                <p class="text-gray-500 mb-6">ساعدنا في تطوير خدماتنا من خلال مشاركة اقتراحاتك وآرائك</p>
                <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-comment-alt ml-2"></i>
                    إضافة اقتراح
                </button>
            </div>
        </div>
    </div>
</x-user-layout>
