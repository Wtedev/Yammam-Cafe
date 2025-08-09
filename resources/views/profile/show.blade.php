<x-user-layout title="الملف الشخصي">
    <!-- Profile Header -->
    <div class="px-4 pt-6 pb-4">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center space-x-4 space-x-reverse mb-6">
                <div class="relative">
                    <div class="w-20 h-20 bg-amber-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">
                            {{ substr(auth()->user()->name ?? 'م', 0, 1) }}
                        </span>
                    </div>
                    <button class="absolute -bottom-1 -right-1 bg-white border border-gray-200 rounded-full w-7 h-7 flex items-center justify-center">
                        <i class="fas fa-camera text-gray-600 text-xs"></i>
                    </button>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name ?? 'محمد أحمد' }}</h2>
                    <p class="text-gray-600 text-sm">عضو مميز</p>
                    <div class="flex items-center space-x-2 space-x-reverse mt-2">
                        <div class="flex text-amber-400">
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="fas fa-star text-xs"></i>
                            <i class="far fa-star text-xs"></i>
                        </div>
                        <span class="text-xs text-gray-500">125 نقطة</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-amber-600">23</p>
                    <p class="text-xs text-gray-600">طلب مكتمل</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">125</p>
                    <p class="text-xs text-gray-600">نقطة متاحة</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">5</p>
                    <p class="text-xs text-gray-600">كوبون خصم</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4 pb-4">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">الإجراءات السريعة</h3>
            <div class="grid grid-cols-2 gap-3">
                <button class="flex items-center space-x-3 space-x-reverse p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors duration-200">
                    <i class="fas fa-shopping-bag text-amber-600"></i>
                    <span class="text-sm font-medium text-amber-700">طلباتي</span>
                </button>
                <button class="flex items-center space-x-3 space-x-reverse p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                    <i class="fas fa-heart text-blue-600"></i>
                    <span class="text-sm font-medium text-blue-700">المفضلة</span>
                </button>
                <button class="flex items-center space-x-3 space-x-reverse p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                    <i class="fas fa-gift text-green-600"></i>
                    <span class="text-sm font-medium text-green-700">المكافآت</span>
                </button>
                <button class="flex items-center space-x-3 space-x-reverse p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200">
                    <i class="fas fa-cog text-purple-600"></i>
                    <span class="text-sm font-medium text-purple-700">الإعدادات</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="px-4 pb-4">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">الطلبات الأخيرة</h3>
                <button class="text-amber-600 text-sm font-medium">عرض الكل</button>
            </div>

            <div class="space-y-3">
                <!-- Order Item -->
                <div class="flex items-center space-x-3 space-x-reverse p-3 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-coffee text-amber-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 text-sm">طلب #1234</p>
                        <p class="text-xs text-gray-600">2x كابتشينو، 1x كوكيز</p>
                        <p class="text-xs text-green-600">تم التسليم • منذ يومين</p>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-amber-600 text-sm">42 ريال</p>
                        <button class="text-xs text-blue-600 hover:underline">إعادة الطلب</button>
                    </div>
                </div>

                <!-- Order Item -->
                <div class="flex items-center space-x-3 space-x-reverse p-3 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-snowflake text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 text-sm">طلب #1233</p>
                        <p class="text-xs text-gray-600">1x أيس كوفي، 1x شيز كيك</p>
                        <p class="text-xs text-green-600">تم التسليم • منذ أسبوع</p>
                    </div>
                    <div class="text-left">
                        <p class="font-bold text-amber-600 text-sm">35 ريال</p>
                        <button class="text-xs text-blue-600 hover:underline">إعادة الطلب</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rewards & Coupons -->
    <div class="px-4 pb-4">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">المكافآت والكوبونات</h3>

            <!-- Points Progress -->
            <div class="mb-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">التقدم نحو المكافأة التالية</span>
                    <span class="text-sm font-medium text-amber-600">125/200 نقطة</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width: 62.5%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">75 نقطة أخرى للحصول على مشروب مجاني!</p>
            </div>

            <!-- Available Coupons -->
            <div class="space-y-3">
                <div class="border border-dashed border-amber-300 rounded-lg p-3 bg-amber-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-amber-800 text-sm">خصم 20%</p>
                            <p class="text-xs text-amber-600">على الطلب التالي</p>
                        </div>
                        <button class="text-xs bg-amber-500 text-white px-3 py-1 rounded-full font-medium">
                            استخدم
                        </button>
                    </div>
                </div>

                <div class="border border-dashed border-green-300 rounded-lg p-3 bg-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-green-800 text-sm">مشروب مجاني</p>
                            <p class="text-xs text-green-600">أي مشروب حار</p>
                        </div>
                        <button class="text-xs bg-green-500 text-white px-3 py-1 rounded-full font-medium">
                            استخدم
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings & Support -->
    <div class="px-4 pb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">الإعدادات والدعم</h3>

            <div class="space-y-3">
                <button class="w-full flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-user text-gray-600"></i>
                        <span class="text-sm text-gray-700">تعديل الملف الشخصي</span>
                    </div>
                    <i class="fas fa-chevron-left text-gray-400 text-sm"></i>
                </button>

                <button class="w-full flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-map-marker-alt text-gray-600"></i>
                        <span class="text-sm text-gray-700">عناوين التوصيل</span>
                    </div>
                    <i class="fas fa-chevron-left text-gray-400 text-sm"></i>
                </button>

                <button class="w-full flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span class="text-sm text-gray-700">الإشعارات</span>
                    </div>
                    <i class="fas fa-chevron-left text-gray-400 text-sm"></i>
                </button>

                <button class="w-full flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-question-circle text-gray-600"></i>
                        <span class="text-sm text-gray-700">المساعدة والدعم</span>
                    </div>
                    <i class="fas fa-chevron-left text-gray-400 text-sm"></i>
                </button>

                <button class="w-full flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <i class="fas fa-sign-out-alt text-red-600"></i>
                        <span class="text-sm text-red-600">تسجيل الخروج</span>
                    </div>
                    <i class="fas fa-chevron-left text-gray-400 text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</x-user-layout>
