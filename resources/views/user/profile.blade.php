<x-user-layout title="ملفي الشخصي">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold ml-4">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name ?? 'المستخدم' }}</h1>
                    <p class="text-gray-600">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 space-x-reverse px-6" aria-label="Tabs">
                    <button class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        المعلومات الشخصية
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        إعدادات الحساب
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        العناوين
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        التفضيلات
                    </button>
                </nav>
            </div>
        </div>

        <!-- Profile Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-2xl font-bold text-blue-600">0</div>
                <div class="text-sm text-gray-600">إجمالي الطلبات</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-2xl font-bold text-green-600">0 ر.س</div>
                <div class="text-sm text-gray-600">إجمالي المبلغ</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-2xl font-bold text-yellow-600">0</div>
                <div class="text-sm text-gray-600">الاقتراحات المرسلة</div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <div class="max-w-md mx-auto text-center">
                <i class="fas fa-user-circle text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">الملف الشخصي</h2>
                <p class="text-gray-500 mb-6">إدارة معلوماتك الشخصية وإعدادات الحساب</p>
                <div class="space-y-3">
                    <button class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit ml-2"></i>
                        تعديل المعلومات
                    </button>
                    <button class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-key ml-2"></i>
                        تغيير كلمة المرور
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
