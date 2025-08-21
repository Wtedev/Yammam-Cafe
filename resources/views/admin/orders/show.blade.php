<x-layout.admin-layout title="تفاصيل الطلب">
    <div class="container mx-auto py-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-blue-900 flex items-center gap-2">
                <i class="fas fa-file-invoice text-blue-400"></i>
                تفاصيل الطلب <span class="text-blue-400">#{{ $order->id }}</span>
            </h2>
            <a href="{{ route('admin.orders') }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-medium shadow-sm border border-blue-100 transition flex items-center gap-2">
                <i class="fas fa-arrow-right"></i>
                رجوع للطلبات
            </a>
        </div>

        <!-- حالة الطلب والمبلغ الإجمالي -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 flex flex-col gap-2 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-bold text-blue-700">حالة الطلب:</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                        match($order->status) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processed' => 'bg-blue-100 text-blue-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-200 text-gray-700',
                        }
                    }}">{{ $order->status_text }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-blue-700">المبلغ الإجمالي:</span>
                    <span class="text-green-600 font-extrabold text-lg">{{ $order->formatted_total }}</span>
                </div>
            </div>
            <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 flex flex-col gap-2 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-clock text-blue-400"></i>
                    <span class="text-xs font-bold text-blue-700">تاريخ الطلب:</span>
                    <span class="text-xs text-gray-700">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-calendar-check text-green-400"></i>
                    <span class="text-xs font-bold text-blue-700">وقت التسليم:</span>
                    <span class="text-xs text-gray-700">{{ $order->delivery_time ? $order->delivery_time->format('Y-m-d H:i') : '-' }}</span>
                </div>
                @if($order->first_viewed_at)
                <div class="flex items-center gap-2">
                    <i class="fas fa-eye text-orange-400"></i>
                    <span class="text-xs font-bold text-blue-700">أول مشاهدة:</span>
                    <span class="text-xs text-gray-700">{{ $order->first_viewed_at->format('Y-m-d H:i') }}</span>
                </div>
                @else
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-1 text-xs font-medium text-orange-700">
                        <i class="fas fa-star mr-1"></i>
                        طلب جديد - تمت مشاهدته الآن
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- معلومات العميل والطلب والدفع -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-user text-blue-400"></i>
                    <span class="text-base font-bold text-blue-900">معلومات العميل</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">الاسم:</span>
                    <span class="text-gray-900">{{ $order->user->name ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">البريد الإلكتروني:</span>
                    <span class="text-gray-900">{{ $order->user->email ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">رقم الجوال:</span>
                    <span class="text-gray-900">{{ $order->user->mobile ?? '-' }}</span>
                </div>
            </div>
            <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    <span class="text-base font-bold text-blue-900">معلومات الطلب</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">رقم المكتب:</span>
                    <span class="text-gray-900">{{ $order->office_number ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">طريقة الدفع:</span>
                    <span class="text-gray-900">{{ $order->payment_method ?? '-' }}</span>
                </div>
            </div>
            <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-money-check-alt text-blue-400"></i>
                    <span class="text-base font-bold text-blue-900">معلومات الدفع</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">طريقة الدفع:</span>
                    <span class="text-gray-900">
                        @if($order->payment_method === 'bank_transfer')
                        تحويل بنكي
                        @elseif($order->payment_method === 'network')
                        شبكة
                        @elseif($order->payment_method === 'cash')
                        كاش
                        @else
                        {{ $order->payment_method ?? '-' }}
                        @endif
                    </span>
                </div>

                @if($order->payment_method === 'bank_transfer')
                @if($order->payment_image_url)
                <!-- إيصال التحويل البنكي -->
                <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-exclamation-triangle text-amber-600"></i>
                        <span class="font-bold text-amber-800">تحذير مهم للمدير</span>
                    </div>
                    <p class="text-sm text-amber-700 mb-3">
                        يرجى التحقق من مصداقية إيصال التحويل البنكي المرفق والتأكد من صحة البيانات قبل تأكيد الطلب.
                    </p>

                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700">إيصال التحويل:</span>
                        <a href="{{ asset('storage/' . $order->payment_image_url) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-image"></i>
                            عرض الإيصال
                        </a>
                    </div>

                    <!-- معاينة مصغرة للصورة -->
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $order->payment_image_url) }}" alt="إيصال التحويل البنكي" class="max-w-xs max-h-48 object-contain border border-gray-300 rounded-lg shadow-sm cursor-pointer" onclick="window.open('{{ asset('storage/' . $order->payment_image_url) }}', '_blank')">
                    </div>
                </div>
                @else
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-times-circle text-red-600"></i>
                        <span class="font-bold text-red-800">لم يتم إرفاق إيصال التحويل</span>
                    </div>
                    <p class="text-sm text-red-700 mt-2">
                        العميل لم يقم بإرفاق إيصال التحويل البنكي. يرجى التواصل معه للحصول على الإيصال.
                    </p>
                </div>
                @endif
                @endif
            </div>
        </div>

        <!-- المنتجات -->
        <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 p-4">
            <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-box-open text-blue-400"></i>
                المنتجات المطلوبة
            </h3>
            <div class="space-y-3">
                @php($items = isset($order->products) ? (is_array($order->products) ? $order->products : json_decode($order->products, true)) : [])
                @php($loopItems = $items['items'] ?? $order->products_items ?? $order->products_data ?? [])
                @foreach($loopItems as $product)
                <div class="flex items-center justify-between p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <div>
                            <span class="font-medium text-blue-900">{{ $product['name'] }}</span>
                            <div class="text-sm text-blue-600">
                                الكمية: <span class="font-bold">{{ $product['quantity'] }}</span>
                                @if(isset($product['size']) && $product['size'])
                                - الحجم: <span class="font-medium">{{ $product['size'] }}</span>
                                @endif
                            </div>
                            @if(isset($product['notes']) && $product['notes'])
                            <div class="text-xs text-blue-500 mt-1">
                                <i class="fas fa-sticky-note"></i>
                                {{ $product['notes'] }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-left">
                        <div class="text-lg font-bold text-blue-900">{{ number_format($product['price'], 2) }} ريال</div>
                        <div class="text-sm text-blue-600">للقطعة الواحدة</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- إجمالي الطلب -->
            <div class="mt-4 pt-4 border-t border-blue-200">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-blue-900">إجمالي الطلب:</span>
                    <span class="text-xl font-bold text-green-600">{{ number_format($order->total_price, 2) }} ريال</span>
                </div>
            </div>
        </div> <!-- تحديث حالة الطلب -->
        <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 p-4">
            <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                <i class="fas fa-sync-alt text-blue-400"></i>
                تحديث حالة الطلب
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-blue-600">حالة الطلب الحالية:</p>
                    <div class="flex items-center gap-2">
                        @if($order->status == 'pending')
                        <span class="px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium border border-yellow-200">
                            🕒 {{ $order->status_text }}
                        </span>
                        @elseif($order->status == 'processed')
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-800 rounded-full text-sm font-medium border border-blue-200">
                            ⚡ {{ $order->status_text }}
                        </span>
                        @elseif($order->status == 'delivered')
                        <span class="px-3 py-1.5 bg-green-100 text-green-800 rounded-full text-sm font-medium border border-green-200">
                            ✅ {{ $order->status_text }}
                        </span>
                        @elseif($order->status == 'cancelled')
                        <span class="px-3 py-1.5 bg-red-100 text-red-800 rounded-full text-sm font-medium border border-red-200">
                            ❌ {{ $order->status_text }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-blue-600">آخر تحديث:</p>
                    <p class="text-blue-900 font-medium">{{ $order->updated_at->diffForHumans() }}</p>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-blue-700 mb-2">الحالة الجديدة</label>
                        <select id="status" name="status" class="block w-full rounded-lg border-blue-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 text-sm">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                🕒 في الانتظار
                            </option>
                            <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>
                                ⚡ قيد المعالجة
                            </option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                ✅ تم التسليم
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                ❌ ملغى
                            </option>
                        </select>
                        @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2 flex items-end">
                        <button type="submit" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 flex items-center justify-center gap-2 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" onclick="this.disabled=true; const ic=this.querySelector('.btn-icon'); if(ic){ ic.classList.remove('fa-save'); ic.classList.add('fa-spinner','fa-spin'); } const lbl=this.querySelector('.btn-label'); if(lbl){ lbl.textContent='جاري التحديث...'; } this.form.submit();">
                            <i class="fas fa-save btn-icon"></i>
                            <span class="btn-label">تحديث حالة الطلب</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout.admin-layout>
