<x-user-layout :title="'تفاصيل الطلب #' . $order->id">
    @php
    $data = is_array($order->products) ? $order->products : (json_decode($order->products, true) ?: []);
    $items = $order->products_items ?? ($data['items'] ?? []);
    $meta = $order->products_meta ?? ($data['meta'] ?? []);
    $statusColors = [
    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
    'processed' => 'bg-blue-100 text-blue-800 border-blue-200',
    'delivered' => 'bg-green-100 text-green-800 border-green-200',
    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
    'confirmed' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
    ];
    $statusText = [
    'pending' => 'في الانتظار',
    'processed' => 'قيد التحضير',
    'delivered' => 'تم التسليم',
    'cancelled' => 'ملغي',
    'confirmed' => 'مؤكد'
    ];
    $paymentText = [
    'cash' => 'دفع نقدي',
    'network' => 'شبكة',
    'bank_transfer' => 'تحويل بنكي'
    ];
    $canCancel = in_array($order->status, ['pending','confirmed']);
    @endphp

    <div class="max-w-6xl mx-auto space-y-8">
        <!-- العنوان -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-receipt text-blue-600"></i>
                    تفاصيل الطلب <span class="text-base text-gray-500">#{{ $order->id }}</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">تاريخ الإنشاء: {{ $order->created_at?->format('Y/m/d H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('my-orders') }}" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
                    <i class="fas fa-arrow-right"></i>
                    الرجوع لطلباتي
                </a>
            </div>
        </div>

        <!-- الشبكة العلوية: 3 أعمدة -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- بطاقة بيانات العميل -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-4">
                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user text-blue-500"></i>
                    بيانات العميل
                </h3>
                <ul class="text-sm space-y-2 text-gray-600">
                    <li class="flex items-center gap-2"><i class="fas fa-id-badge text-gray-400"></i>{{ $order->user?->name }}</li>
                    <li class="flex items-center gap-2"><i class="fas fa-phone text-gray-400"></i>{{ $order->user?->mobile ?? 'غير متوفر' }}</li>
                    <li class="flex items-center gap-2"><i class="fas fa-building text-gray-400"></i>المكتب: {{ $order->office_number ?? '—' }}</li>
                </ul>
            </div>

            <!-- بطاقة معلومات الدفع -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-4">
                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-wallet text-amber-500"></i>
                    معلومات الدفع
                </h3>
                <ul class="text-sm space-y-2 text-gray-600">
                    <li class="flex items-center gap-2"><i class="fas fa-money-bill-wave text-gray-400"></i>الطريقة: {{ $paymentText[$order->payment_method] ?? 'غير معروفة' }}</li>
                    <li class="flex items-center gap-2"><i class="fas fa-coins text-gray-400"></i>الإجمالي: {{ number_format($order->total_price,2) }} ر.س</li>
                    <li class="flex items-center gap-2"><i class="fas fa-calendar-alt text-gray-400"></i>أنشئ: {{ $order->created_at?->diffForHumans() }}</li>
                </ul>
            </div>

            <!-- بطاقة حالة الطلب -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-stream text-blue-500"></i>
                        <span class="text-sm font-bold text-blue-700">حالة الطلب</span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $statusText[$order->status] ?? $order->status }}
                    </span>
                </div>

                @php
                $steps = [
                    ['key' => 'pending', 'label' => 'جديد', 'icon' => 'fa-clock'],
                    ['key' => 'confirmed', 'label' => 'مؤكد', 'icon' => 'fa-circle-check'],
                    ['key' => 'processed', 'label' => 'قيد التحضير', 'icon' => 'fa-mug-hot'],
                    ['key' => 'delivered', 'label' => 'تم التسليم', 'icon' => 'fa-check-circle'],
                ];
                $currentIndex = collect($steps)->search(fn($s) => $s['key'] === $order->status);
                @endphp

                <!-- Timeline -->
                @if($order->status === 'cancelled')
                    <!-- Show only current status for cancelled orders -->
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center text-sm font-bold bg-red-500 text-white">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-red-700">ملغي</span>
                                <span class="text-xs text-red-600 font-semibold">الحالة النهائية</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">تم إلغاء الطلب</p>
                        </div>
                    </div>
                @else
                    <!-- Show full timeline for non-cancelled orders -->
                    <div class="space-y-3">
                        @foreach($steps as $index => $step)
                        @php 
                            $isActive = $currentIndex !== false && $index <= $currentIndex;
                            $isCurrent = $currentIndex !== false && $index === $currentIndex;
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                <div class="h-6 w-6 rounded-full flex items-center justify-center text-xs font-bold border-2
                                        {{ $isActive ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white border-gray-300 text-gray-400' }}
                                        {{ $isCurrent ? 'ring-2 ring-blue-200' : '' }}">
                                    @if($isActive)
                                        @if($index < $currentIndex)
                                            <i class="fas fa-check text-[10px]"></i>
                                        @else
                                            <i class="fas {{ $step['icon'] }} text-[10px]"></i>
                                        @endif
                                    @else
                                        <i class="fas {{ $step['icon'] }} text-[10px]"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium {{ $isActive ? 'text-blue-700' : 'text-gray-400' }}">{{ $step['label'] }}</span>
                                    @if($isCurrent)
                                        <span class="text-xs text-blue-600 font-semibold">الحالة الحالية</span>
                                    @elseif($isActive && $index < $currentIndex)
                                        <span class="text-xs text-green-600">مكتمل</span>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <div class="h-4 flex items-center mt-1">
                                        <div class="w-px h-full {{ $index < $currentIndex ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

                <!-- Last Update Info -->
                @if($order->updated_at)
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="fas fa-clock"></i>
                        <span>آخر تحديث: {{ $order->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

            
            @if(!empty($meta['notes']))
            <div class="mt-2 bg-gray-50 border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                <i class="fas fa-comment-dots text-gray-400 mt-1"></i>
                <div>
                    <p class="text-xs font-bold text-gray-700 mb-1">ملاحظات العميل</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $meta['notes'] }}</p>
                </div>
            </div>
            @endif

            @if($order->payment_method === 'bank_transfer' && $order->payment_image_url)
            <div class="mt-2">
                <h3 class="text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-image text-blue-500"></i>
                    إيصال التحويل البنكي
                </h3>
                <div class="relative group w-64 h-64 rounded-xl overflow-hidden border border-gray-200 bg-gray-100 flex items-center justify-center">
                    <img src="{{ asset('storage/'.$order->payment_image_url) }}" alt="إيصال الدفع" class="w-full h-full object-cover group-hover:scale-105 transition" />
                    <a href="{{ asset('storage/'.$order->payment_image_url) }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition text-white text-xs font-medium">
                        فتح بالحجم الكامل
                    </a>
                </div>
            </div>
            @endif
        </div>
    

    <!-- عناصر الطلب بعرض كامل أسفل الشبكة -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mt-6">
        <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
            <i class="fas fa-layer-group text-green-500"></i>
            عناصر الطلب
        </h2>
        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-1 custom-scrollbar">
            @forelse($items as $it)
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center text-gray-400">
                    <i class="fas fa-mug-hot"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ $it['name'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $it['quantity'] }} × {{ number_format($it['price'],2) }} ر.س</p>
                </div>
                <div class="text-sm font-bold text-green-600">{{ number_format($it['subtotal'],2) }} ر.س</div>
            </div>
            @empty
            <div class="text-center py-10 text-gray-500 text-sm">
                <i class="fas fa-box-open text-2xl mb-2"></i>
                لا توجد عناصر
            </div>
            @endforelse
        </div>
        <div class="mt-6 border-t border-gray-200 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">المجموع الفرعي</span>
                <span class="font-medium text-gray-800">{{ number_format($order->total_price,2) }} ر.س</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">التوصيل</span>
                <span class="font-medium text-green-600">مجاني</span>
            </div>
            <div class="flex justify-between text-base font-extrabold text-gray-900 pt-2 border-t border-gray-200">
                <span>الإجمالي</span>
                <span class="text-green-600">{{ number_format($order->total_price,2) }} ر.س</span>
            </div>
        </div>
    </div>

    </div>
</x-user-layout>
