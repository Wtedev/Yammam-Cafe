<x-admin-layout title="إدارة الاقتراحات">
    <!-- Filter and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <!-- Search -->
                <div class="relative flex-1 lg:max-w-md">
                    <input type="text" placeholder="البحث في الاقتراحات..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Filter Buttons -->
                <div class="flex space-x-2 space-x-reverse" x-data="{ filter: 'all' }">
                    <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        الكل
                    </button>
                    <button @click="filter = 'new'" :class="filter === 'new' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        جديد
                    </button>
                    <button @click="filter = 'reviewing'" :class="filter === 'reviewing' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        قيد المراجعة
                    </button>
                    <button @click="filter = 'implemented'" :class="filter === 'implemented' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        تم التنفيذ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Suggestions List -->
    <div class="space-y-4 mb-6">
        @forelse($suggestions as $suggestion)
        <!-- Suggestion Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-start space-x-4 space-x-reverse">
                    <div class="w-12 h-12 {{ $suggestion->name === 'مجهول' ? 'bg-gray-100' : 'bg-amber-100' }} rounded-full flex items-center justify-center">
                        <span class="{{ $suggestion->name === 'مجهول' ? 'text-gray-600' : 'text-amber-600' }} font-semibold">{{ substr($suggestion->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $suggestion->name }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ $suggestion->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 space-x-reverse">
                    @if($suggestion->status == 'new')
                    <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-medium">
                        جديد
                    </span>
                    @elseif($suggestion->status == 'reviewing')
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-medium">
                        قيد المراجعة
                    </span>
                    @elseif($suggestion->status == 'approved')
                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                        مقبول
                    </span>
                    @elseif($suggestion->status == 'rejected')
                    <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full font-medium">
                        مرفوض
                    </span>
                    @elseif($suggestion->status == 'implemented')
                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                        تم التنفيذ
                    </span>
                    @endif

                    <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg" x-data="{ open: false }">
                        <i class="fas fa-ellipsis-v" @click="open = !open"></i>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-10">
                            <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="reviewing">
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    قيد المراجعة
                                </button>
                            </form>

                            <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-green-700 hover:bg-green-50">
                                    موافق
                                </button>
                            </form>

                            <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                    رفض
                                </button>
                            </form>

                            <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="implemented">
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-blue-700 hover:bg-blue-50">
                                    تم التنفيذ
                                </button>
                            </form>

                            <form action="{{ route('admin.suggestions.mark-read', $suggestion) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    تمت القراءة
                                </button>
                            </form>
                        </div>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <div class="flex items-center space-x-2 space-x-reverse mb-2">
                    @if($suggestion->type == 'suggestion')
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">اقتراح</span>
                    @elseif($suggestion->type == 'complaint')
                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">شكوى</span>
                    @elseif($suggestion->type == 'compliment')
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">ملاحظة إيجابية</span>
                    @endif
                </div>
                <p class="text-gray-700 leading-relaxed">
                    {{ $suggestion->suggestion }}
                </p>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="flex items-center space-x-4 space-x-reverse text-sm text-gray-500">
                    <span><i class="fas fa-calendar-alt"></i> {{ $suggestion->created_at->format('Y/m/d') }}</span>
                    <span><i class="fas fa-clock"></i> {{ $suggestion->created_at->format('h:i A') }}</span>
                </div>
                <div class="flex space-x-2 space-x-reverse">
                    <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors duration-200">
                            موافق
                        </button>
                    </form>

                    <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="reviewing">
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-600 transition-colors duration-200">
                            قيد المراجعة
                        </button>
                    </form>

                    <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-600 transition-colors duration-200">
                            رفض
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-gray-600 py-6">لا توجد اقتراحات حتى الآن</p>
        </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $suggestions->links() }}
        </div>
    </div>
    <span class="text-blue-600 font-semibold">س</span>
    </div>
    <div>
        <h3 class="font-semibold text-gray-800 mb-1">سارة أحمد</h3>
        <p class="text-sm text-gray-600">sara@email.com • منذ 5 ساعات</p>
    </div>
    </div>
    <div class="flex items-center space-x-2 space-x-reverse">
        <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-medium">
            قيد المراجعة
        </span>
    </div>
    </div>

    <div class="mb-4">
        <div class="flex items-center space-x-2 space-x-reverse mb-2">
            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">تحسين التطبيق</span>
            <span class="text-sm font-medium text-gray-700">نظام النقاط والمكافآت</span>
        </div>
        <p class="text-gray-700 leading-relaxed">
            اقتراح إضافة نظام نقاط ومكافآت للعملاء المتكررين. كل طلب يحصل فيه العميل على نقاط يمكن استبدالها بمشروبات مجانية أو خصومات. هذا سيشجع العملاء على العودة مرة أخرى.
        </p>
    </div>

    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
        <div class="flex items-center space-x-4 space-x-reverse text-sm text-gray-500">
            <span><i class="fas fa-heart text-red-500"></i> 23 إعجاب</span>
            <span><i class="fas fa-comment text-blue-500"></i> 7 تعليقات</span>
            <span><i class="fas fa-share text-green-500"></i> 5 مشاركات</span>
        </div>
        <div class="flex space-x-2 space-x-reverse">
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors duration-200">
                موافق
            </button>
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-600 transition-colors duration-200">
                رفض
            </button>
        </div>
    </div>
    </div>

    <!-- Suggestion Card 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-start space-x-4 space-x-reverse">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-green-600 font-semibold">م</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">محمد علي</h3>
                    <p class="text-sm text-gray-600">mohammed@email.com • منذ يوم</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 space-x-reverse">
                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                    تم التنفيذ
                </span>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex items-center space-x-2 space-x-reverse mb-2">
                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">تحسين الخدمة</span>
                <span class="text-sm font-medium text-gray-700">تحسين سرعة التطبيق</span>
            </div>
            <p class="text-gray-700 leading-relaxed">
                التطبيق أحياناً يكون بطيء في التحميل، خاصة صفحة المنيو. اقتراح تحسين الأداء وإضافة ميزة البحث السريع للعثور على المنتجات بسهولة أكبر.
            </p>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
            <div class="flex items-center space-x-2 space-x-reverse">
                <i class="fas fa-check-circle text-green-600"></i>
                <span class="text-sm font-medium text-green-800">تم التنفيذ</span>
            </div>
            <p class="text-sm text-green-700 mt-1">
                تم تحسين أداء التطبيق وإضافة ميزة البحث السريع. شكراً لك على الاقتراح القيم!
            </p>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <div class="flex items-center space-x-4 space-x-reverse text-sm text-gray-500">
                <span><i class="fas fa-heart text-red-500"></i> 32 إعجاب</span>
                <span><i class="fas fa-comment text-blue-500"></i> 12 تعليقات</span>
                <span><i class="fas fa-share text-green-500"></i> 8 مشاركات</span>
            </div>
            <button class="bg-gray-500 text-white px-4 py-2 rounded-lg font-medium cursor-not-allowed">
                تم التنفيذ
            </button>
        </div>
    </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-exclamation text-red-600 text-xl"></i>
            </div>
            <p class="text-2xl font-bold text-gray-900">3</p>
            <p class="text-sm text-gray-600">اقتراحات جديدة</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <p class="text-2xl font-bold text-gray-900">5</p>
            <p class="text-sm text-gray-600">قيد المراجعة</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-check text-green-600 text-xl"></i>
            </div>
            <p class="text-2xl font-bold text-gray-900">18</p>
            <p class="text-sm text-gray-600">تم التنفيذ</p>
        </div>
    </div>
</x-admin-layout>
