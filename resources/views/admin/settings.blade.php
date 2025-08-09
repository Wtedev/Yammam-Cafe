<x-admin-layout title="إعدادات النظام">
    <div class="space-y-6">
        <!-- General Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">الإعدادات العامة</h3>
                <p class="text-sm text-gray-600 mt-1">إدارة الإعدادات الأساسية للمقهى</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم المقهى</label>
                        <input type="text" value="يمام كافيه" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                        <input type="tel" value="+966 50 123 4567" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">العنوان</label>
                        <textarea rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">شارع الملك فهد، حي الملز، الرياض، المملكة العربية السعودية</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">إعدادات الطلبات</h3>
                <p class="text-sm text-gray-600 mt-1">إدارة إعدادات الطلبات والتوصيل</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رسوم التوصيل (ريال)</label>
                        <input type="number" value="5" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الحد الأدنى للطلب (ريال)</label>
                        <input type="number" value="20" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">متوسط وقت التحضير (دقيقة)</label>
                        <input type="number" value="15" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">متوسط وقت التوصيل (دقيقة)</label>
                        <input type="number" value="30" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-800">قبول الطلبات الجديدة</h4>
                            <p class="text-sm text-gray-600">تفعيل أو إيقاف استقبال طلبات جديدة</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-800">خدمة التوصيل</h4>
                            <p class="text-sm text-gray-600">تفعيل أو إيقاف خدمة التوصيل</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">ساعات العمل</h3>
                <p class="text-sm text-gray-600 mt-1">إدارة مواعيد العمل اليومية</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">السبت</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="06:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">الأحد</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="06:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">الاثنين</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="06:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">الثلاثاء</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="06:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">الأربعاء</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="06:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">الخميس</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="06:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="font-medium text-gray-800">الجمعة</div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" value="14:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <input type="time" value="23:00" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        </div>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="text-amber-500 focus:ring-amber-500 rounded">
                            <span class="mr-2 text-sm text-gray-600">مفتوح</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">إعدادات الإشعارات</h3>
                <p class="text-sm text-gray-600 mt-1">إدارة إشعارات النظام</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-gray-800">إشعارات الطلبات الجديدة</h4>
                        <p class="text-sm text-gray-600">تلقي إشعار عند وصول طلب جديد</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-gray-800">إشعارات الاقتراحات الجديدة</h4>
                        <p class="text-sm text-gray-600">تلقي إشعار عند وصول اقتراح جديد</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-gray-800">إشعارات البريد الإلكتروني</h4>
                        <p class="text-sm text-gray-600">تلقي إشعارات عبر البريد الإلكتروني</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button class="bg-amber-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-amber-600 transition-colors duration-200">
                حفظ التغييرات
            </button>
        </div>
    </div>
</x-admin-layout>
