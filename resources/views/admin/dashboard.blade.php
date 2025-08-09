<x-admin-layout title="لوحة الإدارة">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي الطلبات</p>
                    <p class="text-3xl font-bold text-gray-900">1,234</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i>
                        +12% من الشهر الماضي
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي المبيعات</p>
                    <p class="text-3xl font-bold text-gray-900">45,678 ريال</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i>
                        +8% من الشهر الماضي
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">الطلبات المعلقة</p>
                    <p class="text-3xl font-bold text-gray-900">12</p>
                    <p class="text-sm text-red-600 mt-1">
                        <i class="fas fa-clock"></i>
                        تحتاج لمراجعة
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- New Suggestions -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">اقتراحات جديدة</p>
                    <p class="text-3xl font-bold text-gray-900">3</p>
                    <p class="text-sm text-amber-600 mt-1">
                        <i class="fas fa-lightbulb"></i>
                        غير مقروءة
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lightbulb text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">أحدث الطلبات</h3>
                <a href="/admin/orders" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                    عرض الكل
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الطلب</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العميل</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المبلغ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#1234</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">أحمد محمد</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">45 ريال</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                قيد التحضير
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">منذ 5 دقائق</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#1233</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">فاطمة علي</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">32 ريال</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                مكتمل
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">منذ 10 دقائق</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#1232</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">محمد سالم</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">28 ريال</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                ملغي
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">منذ 15 دقيقة</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">إجراءات سريعة</h4>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" class="block w-full bg-amber-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200 text-center">
                    إضافة منتج جديد
                </a>
                <button class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-600 transition-colors duration-200">
                    عرض التقارير
                </button>
                <button class="w-full bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors duration-200">
                    إدارة المخزون
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات اليوم</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">الطلبات المكتملة</span>
                    <span class="font-semibold text-green-600">45</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">الطلبات الجارية</span>
                    <span class="font-semibold text-yellow-600">12</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">إجمالي المبيعات</span>
                    <span class="font-semibold text-blue-600">1,450 ريال</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">الاقتراحات الجديدة</h4>
            <div class="space-y-3">
                <div class="p-3 bg-amber-50 rounded-lg border border-amber-200">
                    <p class="text-sm text-gray-800 font-medium">إضافة مشروب جديد</p>
                    <p class="text-xs text-gray-600 mt-1">من: محمد أحمد</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-gray-800 font-medium">تحسين الخدمة</p>
                    <p class="text-xs text-gray-600 mt-1">من: سارة علي</p>
                </div>
                <a href="/admin/suggestions" class="block text-center text-amber-600 hover:text-amber-700 text-sm font-medium">
                    عرض جميع الاقتراحات
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
