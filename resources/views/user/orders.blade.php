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
                        {{ $activeCount ?? 0 }} طلبات نشطة
                    </span>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <x-user.search-bar page="orders" />

        @if(isset($orders) && $orders->count())
        <!-- Orders List (أسلوب الأدمن) -->
        <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 mb-6">
            <div class="flex items-center justify-between px-4 py-3 border-b border-blue-50">
                <h3 class="sr-only">جميع الطلبات</h3>
            </div>
            <ul class="divide-y divide-blue-50">
                @foreach($orders as $order)
                <li onclick="window.location='{{ route('orders.show', $order) }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-blue-50/60">
                    <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                        <!-- موبايل: كارد تفاعلي -->
                        <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-blue-50 p-3 mb-1 w-full">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-blue-600 font-bold text-lg">#{{ $order->id }}</span>
                                @if($order->is_new)
                                <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">جديد</span>
                                @endif
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

                        <!-- ديسكتوب: صف تفاعلي مختصر -->
                        <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                            <span class="text-blue-600 font-bold text-base md:text-lg shrink-0">#{{ $order->id }}</span>
                            @if($order->is_new)
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">جديد</span>
                            @endif
                            <span class="hidden md:inline-block text-gray-400">|</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-sm font-semibold text-gray-900 truncate">
                                    {{ isset($order->office_number) ? 'مكتب ' . $order->office_number : 'مكتب غير معروف' }}
                                </span>
                                <span class="text-xs text-gray-400 truncate md:block hidden">
                                    {{ $order->created_at->diffForHumans() }}
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
            <div class="mt-6 flex justify-center">
                {{ $orders->links() }}
            </div>
        </div>
        @else
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
        @endif
    </div>
</x-user-layout>
