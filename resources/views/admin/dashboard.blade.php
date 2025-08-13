<x-layout.admin-layout title="لوحة الإدارة">
    <!-- Weekly Stats (Soft, Modern, Responsive) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6 font-[Cairo,Tajawal,Segoe UI,Arial,sans-serif]">
        <div class="rounded-2xl bg-white shadow-sm border border-orange-50 flex flex-col items-start p-4 min-h-[110px]">
            <span class="text-xs text-orange-700 font-bold mb-1">طلبات جديدة</span>
            <span class="text-2xl md:text-3xl font-extrabold text-orange-600">{{ number_format($weeklyStats['new_orders']) }}</span>
        </div>
        <div class="rounded-2xl bg-white shadow-sm border border-purple-50 flex flex-col items-start p-4 min-h-[110px]">
            <span class="text-xs text-purple-700 font-bold mb-1">اقتراحات جديدة</span>
            <span class="text-2xl md:text-3xl font-extrabold text-purple-600">{{ number_format($weeklyStats['new_suggestions']) }}</span>
        </div>
        <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
            <span class="text-xs text-blue-700 font-bold mb-1">طلبات هذا الأسبوع</span>
            <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ number_format($weeklyStats['orders']) }}</span>
        </div>
        <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
            <span class="text-xs text-blue-700 font-bold mb-1">مبيعات هذا الأسبوع</span>
            <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ number_format($weeklyStats['revenue'], 2) }} <span class="text-base text-blue-400 font-normal">ر.س</span></span>
        </div>
        <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
            <span class="text-xs text-blue-700 font-bold mb-1">عدد منتجاتي</span>
            <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ number_format($weeklyStats['products']) }}</span>
        </div>
        <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
            <span class="text-xs text-blue-700 font-bold mb-1">اقتراحات هذا الأسبوع</span>
            <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ number_format($weeklyStats['suggestions']) }}</span>
        </div>
    </div>

    <!-- Recent Orders List (Mobile-first, List Row, Soft) -->
    <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 mb-6">
        <div class="flex items-center justify-between px-4 py-3 border-b border-blue-50">
            <h3 class="text-lg md:text-xl font-bold text-blue-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-blue-400"></span>
                أحدث الطلبات
            </h3>
            <a href="{{ route('admin.orders') }}" class="border border-blue-200 text-blue-700 hover:bg-blue-50 hover:text-blue-900 px-3 py-1.5 rounded-lg font-medium text-xs md:text-sm transition-colors duration-200">عرض كل الطلبات</a>
        </div>
        @if($recentOrders->count() > 0)
        <ul class="divide-y divide-blue-50">
            @foreach($recentOrders as $order)
            <li onclick="window.location='{{ route('admin.orders') }}/{{ $order->id }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-blue-50/60">
                <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                    <!-- موبايل: كارد تفاعلي -->
                    <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-blue-50 p-3 mb-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-blue-600 font-bold text-lg">#{{ $order->id }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                match($order->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processed' => 'bg-blue-100 text-blue-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-200 text-gray-700',
                                }
                            }}">{{
                                match($order->status) {
                                    'pending' => 'في الانتظار',
                                    'processed' => 'قيد المعالجة',
                                    'delivered' => 'تم التسليم',
                                    'cancelled' => 'ملغي',
                                    default => $order->status,
                                }
                            }}</span>
                            <span class="text-green-600 font-bold text-sm ml-auto">{{ number_format($order->total_price, 2) }} ر.س</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-building"></i>
                            <span>{{ isset($order->office_number) ? 'مكتب ' . $order->office_number : 'مكتب غير معروف' }}</span>
                            <span class="mx-1">|</span>
                            <i class="fas fa-user"></i>
                            <span class="truncate">{{ $order->user->name ?? 'بدون اسم' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock"></i>
                            <span>{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <!-- لابتوب: نفس الشكل القديم -->
                    <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                        <span class="text-blue-600 font-bold text-base md:text-lg shrink-0">#{{ $order->id }}</span>
                        <span class="hidden md:inline-block text-gray-400">|</span>
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold text-gray-900 truncate">
                                {{ isset($order->office_number) ? 'مكتب ' . $order->office_number : 'مكتب غير معروف' }}
                            </span>
                            <span class="text-xs text-gray-400 truncate md:block hidden">
                                {{ isset($order->user->email) ? $order->user->email : $order->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-2 md:gap-4 ml-auto">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                            match($order->status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processed' => 'bg-blue-100 text-blue-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-200 text-gray-700',
                            }
                        }}" style="min-width: 64px; text-align:center;">{{
                            match($order->status) {
                                'pending' => 'في الانتظار',
                                'processed' => 'قيد المعالجة',
                                'delivered' => 'تم التسليم',
                                'cancelled' => 'ملغي',
                                default => $order->status,
                            }
                        }}</span>
                        <span class="text-green-600 font-bold text-sm md:text-base">{{ number_format($order->total_price, 2) }} ر.س</span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="p-8 text-center text-gray-400">لا توجد طلبات حتى الآن</div>
        @endif
    </div>

    <!-- New Orders List (Special Alert Style) -->
    @if($newOrders->count() > 0)
    <div class="rounded-2xl bg-orange-50/90 shadow-sm border border-orange-100 mb-6">
        <div class="flex items-center justify-between px-4 py-3 border-b border-orange-100">
            <h3 class="text-lg md:text-xl font-bold text-orange-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
                طلبات جديدة تحتاج مراجعة
            </h3>
            <a href="{{ route('admin.orders') }}" class="border border-orange-200 text-orange-700 hover:bg-orange-100 hover:text-orange-900 px-3 py-1.5 rounded-lg font-medium text-xs md:text-sm transition-colors duration-200">عرض كل الطلبات</a>
        </div>
        <ul class="divide-y divide-orange-100">
            @foreach($newOrders as $order)
            <li onclick="window.location='{{ route('admin.orders') }}/{{ $order->id }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-orange-100/60">
                <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                    <!-- موبايل: كارد تفاعلي -->
                    <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-orange-100 p-3 mb-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-orange-600 font-bold text-lg">#{{ $order->id }}</span>
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">
                                جديد
                            </span>
                            <span class="text-green-600 font-bold text-sm ml-auto">{{ number_format($order->total_price, 2) }} ر.س</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-building"></i>
                            <span>{{ isset($order->office_number) ? 'مكتب ' . $order->office_number : 'مكتب غير معروف' }}</span>
                            <span class="mx-1">|</span>
                            <i class="fas fa-user"></i>
                            <span class="truncate">{{ $order->user->name ?? 'بدون اسم' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock"></i>
                            <span>{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <!-- لابتوب -->
                    <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                        <span class="text-orange-600 font-bold text-base md:text-lg shrink-0">#{{ $order->id }}</span>
                        <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">
                            جديد
                        </span>
                        <span class="hidden md:inline-block text-gray-400">|</span>
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold text-gray-900 truncate">
                                {{ isset($order->office_number) ? 'مكتب ' . $order->office_number : 'مكتب غير معروف' }}
                            </span>
                            <span class="text-xs text-gray-400 truncate md:block hidden">
                                {{ isset($order->user->email) ? $order->user->email : $order->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-2 md:gap-4 ml-auto">
                        <span class="text-green-600 font-bold text-sm md:text-base">{{ number_format($order->total_price, 2) }} ر.س</span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- New Suggestions List (Special Alert Style) -->
    @if($newSuggestions->count() > 0)
    <div class="rounded-2xl bg-purple-50/90 shadow-sm border border-purple-100 mb-6">
        <div class="flex items-center justify-between px-4 py-3 border-b border-purple-100">
            <h3 class="text-lg md:text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                اقتراحات جديدة تحتاج مراجعة
            </h3>
            <a href="{{ route('admin.suggestions.index') }}" class="border border-purple-200 text-purple-700 hover:bg-purple-100 hover:text-purple-900 px-3 py-1.5 rounded-lg font-medium text-xs md:text-sm transition-colors duration-200">عرض كل الاقتراحات</a>
        </div>
        <ul class="divide-y divide-purple-100">
            @foreach($newSuggestions as $suggestion)
            <li onclick="window.location='{{ route('admin.suggestions.show', $suggestion) }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-purple-100/60">
                <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                    <!-- موبايل: كارد تفاعلي -->
                    <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-purple-100 p-3 mb-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-purple-600 font-bold text-lg">#{{ $suggestion->id }}</span>
                            <span class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-700">
                                جديد
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                match($suggestion->type) {
                                    'suggestion' => 'bg-blue-100 text-blue-800',
                                    'complaint' => 'bg-red-100 text-red-800',
                                    'compliment' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-200 text-gray-700',
                                }
                            }} ml-auto">{{
                                match($suggestion->type) {
                                    'suggestion' => 'اقتراح',
                                    'complaint' => 'شكوى',
                                    'compliment' => 'إعجاب',
                                    default => $suggestion->type,
                                }
                            }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-comment-dots"></i>
                            <span class="truncate">{{ Str::limit($suggestion->suggestion, 40) }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock"></i>
                            <span>{{ $suggestion->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <!-- لابتوب -->
                    <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                        <span class="text-purple-600 font-bold text-base md:text-lg shrink-0">#{{ $suggestion->id }}</span>
                        <span class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-700">
                            جديد
                        </span>
                        <span class="hidden md:inline-block text-gray-400">|</span>
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($suggestion->suggestion, 40) }}</span>
                            <span class="text-xs text-gray-400 truncate md:block hidden">{{ $suggestion->name ?? 'مجهول' }}</span>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-2 md:gap-4 ml-auto">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                            match($suggestion->type) {
                                'suggestion' => 'bg-blue-100 text-blue-800',
                                'complaint' => 'bg-red-100 text-red-800',
                                'compliment' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-200 text-gray-700',
                            }
                        }}" style="min-width: 56px; text-align:center;">{{
                            match($suggestion->type) {
                                'suggestion' => 'اقتراح',
                                'complaint' => 'شكوى',
                                'compliment' => 'إعجاب',
                                default => $suggestion->type,
                            }
                        }}</span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Recent Suggestions List (Mobile-first, List Row, Soft) -->
    <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50">
        <div class="flex items-center justify-between px-4 py-3 border-b border-blue-50">
            <h3 class="text-lg md:text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-purple-400"></span>
                أحدث الاقتراحات
            </h3>
            <a href="{{ route('admin.suggestions.index') }}" class="border border-purple-200 text-purple-700 hover:bg-purple-50 hover:text-purple-900 px-3 py-1.5 rounded-lg font-medium text-xs md:text-sm transition-colors duration-200">عرض كل الاقتراحات</a>
        </div>
        @if($recentSuggestions->count() > 0)
        <ul class="divide-y divide-blue-50">
            @foreach($recentSuggestions as $suggestion)
            <li onclick="window.location='{{ route('admin.suggestions.show', $suggestion) }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-purple-50/60">
                <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                    <!-- موبايل: كارد تفاعلي -->
                    <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-purple-50 p-3 mb-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-purple-600 font-bold text-lg">#{{ $suggestion->id }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                match($suggestion->type) {
                                    'product' => 'bg-blue-100 text-blue-800',
                                    'service' => 'bg-green-100 text-green-800',
                                    'improvement' => 'bg-amber-100 text-amber-800',
                                    'complaint' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-200 text-gray-700',
                                }
                            }}">{{
                                match($suggestion->type) {
                                    'product' => 'منتج',
                                    'service' => 'خدمة',
                                    'improvement' => 'تحسين',
                                    'complaint' => 'شكوى',
                                    default => $suggestion->type,
                                }
                            }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-comment-dots"></i>
                            <span class="truncate">{{ Str::limit($suggestion->title, 40) }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                            <i class="fas fa-align-left"></i>
                            <span class="truncate">{{ Str::limit($suggestion->description, 60) }}</span>
                        </div>
                    </div>
                    <!-- لابتوب: نفس الشكل القديم -->
                    <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                        <span class="text-purple-600 font-bold text-base md:text-lg shrink-0">#{{ $suggestion->id }}</span>
                        <span class="hidden md:inline-block text-gray-300">|</span>
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($suggestion->title, 40) }}</span>
                            <span class="text-xs text-gray-400 truncate">{{ Str::limit($suggestion->description, 60) }}</span>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col md:flex-row md:items-center gap-1 md:gap-4 min-w-0">
                        <span class="text-sm font-medium text-gray-900 truncate">{{ Str::limit($suggestion->title, 40) }}</span>
                        <span class="hidden md:inline-block text-xs text-gray-400 truncate">{{ Str::limit($suggestion->description, 60) }}</span>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-2 md:gap-4">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                            match($suggestion->type) {
                                'product' => 'bg-blue-100 text-blue-800',
                                'service' => 'bg-green-100 text-green-800',
                                'improvement' => 'bg-amber-100 text-amber-800',
                                'complaint' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-200 text-gray-700',
                            }
                        }}" style="min-width: 56px; text-align:center;">{{
                            match($suggestion->type) {
                                'product' => 'منتج',
                                'service' => 'خدمة',
                                'improvement' => 'تحسين',
                                'complaint' => 'شكوى',
                                default => $suggestion->type,
                            }
                        }}</span>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-2 md:gap-4 text-xs text-gray-400 md:text-sm">
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="p-8 text-center text-gray-400">لا توجد اقتراحات حتى الآن</div>
        @endif
    </div>
</x-layout.admin-layout>
