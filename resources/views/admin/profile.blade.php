<x-admin-layout title="الملف الشخصي">
    <div class="space-y-6">
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6">
                <div class="flex items-center space-x-6 space-x-reverse">
                    <div class="relative">
                        <div class="w-24 h-24 bg-amber-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-3xl font-bold">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <button class="absolute bottom-0 right-0 bg-white border border-gray-200 rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-camera text-gray-600 text-sm"></i>
                        </button>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name ?? 'المدير' }}</h2>
                        <p class="text-gray-600">مدير النظام</p>
                        <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email ?? 'admin@yammamcafe.com' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">المعلومات الشخصية</h3>
                <p class="text-sm text-gray-600 mt-1">إدارة بياناتك الشخصية</p>
            </div>
            <div class="p-6">
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الأول</label>
                            <input type="text" value="أحمد" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">اسم العائلة</label>
                            <input type="text" value="محمد" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input type="email" value="admin@yammamcafe.com" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                            <input type="tel" value="+966 50 123 4567" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-amber-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">تغيير كلمة المرور</h3>
                <p class="text-sm text-gray-600 mt-1">تحديث كلمة المرور الخاصة بك</p>
            </div>
            <div class="p-6">
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الحالية</label>
                        <input type="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة</label>
                        <input type="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-600 transition-colors duration-200">
                            تحديث كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">إحصائيات الحساب</h3>
                <p class="text-sm text-gray-600 mt-1">معلومات عن نشاط حسابك</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-calendar text-blue-600 text-2xl"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">2</p>
                        <p class="text-sm text-gray-600">سنوات في النظام</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-sign-in-alt text-green-600 text-2xl"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">1,245</p>
                        <p class="text-sm text-gray-600">مرة تسجيل دخول</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-check-circle text-purple-600 text-2xl"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">5,678</p>
                        <p class="text-sm text-gray-600">طلب تم معالجته</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">النشاط الأخير</h3>
                <p class="text-sm text-gray-600 mt-1">آخر الأنشطة على حسابك</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">تم قبول طلب #1234</p>
                            <p class="text-xs text-gray-500">منذ 5 دقائق</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">تم تحديث إعدادات النظام</p>
                            <p class="text-xs text-gray-500">منذ ساعة</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-lightbulb text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">تمت مراجعة اقتراح جديد</p>
                            <p class="text-xs text-gray-500">منذ 3 ساعات</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">تسجيل عضو جديد</p>
                            <p class="text-xs text-gray-500">منذ 6 ساعات</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
