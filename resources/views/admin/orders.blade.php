<x-layout.admin-layout title="إدارة الطلبات">
    <div class="container mx-auto px-4 py-2">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
            <h1 class="sr-only">إدارة الطلبات</h1>
        </div>

        <!-- Stats Cards (Unified like dashboard) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">طلبات جديدة</span>
                <span class="text-2xl md:text-3xl font-extrabold text-orange-600">{{ $newOrdersCount ?? 0 }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">في الانتظار</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $statusCounts['pending'] ?? 0 }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">قيد المعالجة</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $statusCounts['processed'] ?? 0 }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">تم التسليم</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $statusCounts['delivered'] ?? 0 }}</span>
            </div>
            <div class="rounded-2xl bg-white shadow-sm border border-blue-50 flex flex-col items-start p-4 min-h-[110px]">
                <span class="text-xs text-blue-700 font-bold mb-1">ملغى</span>
                <span class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $statusCounts['cancelled'] ?? 0 }}</span>
            </div>
        </div>

        <!-- الطلبات -->
        <h2 class="text-xl font-bold text-gray-900 mb-4">الطلبات</h2>

        <!-- Orders List -->
        {{-- اضفت المود من هنا  --}}
        <!-- Orders List (All Orders, paginated) -->
        <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 mb-6">
            <div class="flex items-center justify-between px-4 py-3 border-b border-blue-50">
                <h3 class="sr-only">جميع الطلبات</h3>
            </div>
            @if($orders->count() > 0)
            <ul class="divide-y divide-blue-50">
                @foreach($orders as $order)
                <li onclick="window.location='{{ route('admin.orders') }}/{{ $order->id }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-blue-50/60">
                    <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                        <!-- موبايل: كارد تفاعلي -->
                        <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-blue-50 p-3 mb-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-blue-600 font-bold text-lg">#{{ $order->id }}</span>
                                @if($order->is_new)
                                <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">
                                    جديد
                                </span>
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
                        <!-- لابتوب: نفس الشكل القديم -->
                        <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                            <span class="text-blue-600 font-bold text-base md:text-lg shrink-0">#{{ $order->id }}</span>
                            @if($order->is_new)
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">
                                جديد
                            </span>
                            @endif
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
            <div class="mt-6 flex justify-center">
                {{ $orders->links() }}
            </div>
            @else
            <div class="p-8 text-center text-gray-400">لا توجد طلبات حتى الآن</div>
            @endif
        </div>
        {{-- الى هنا  --}}

    </div>
</x-layout.admin-layout>
