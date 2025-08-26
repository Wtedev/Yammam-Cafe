<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إتمام الطلب - يمام كافيه</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-arabic" x-data="checkoutData()">

    <x-user-layout title="إتمام الطلب">
        <div class="max-w-4xl mx-auto space-y-4">
            <div class="flex items-center gap-3">
                <i class="fas fa-credit-card text-2xl text-blue-500"></i>
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900">إتمام الطلب</h1>
                    <p class="text-sm text-gray-500">أكمل بياناتك لإنهاء طلبك</p>
                </div>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ submitting:false }" @submit="submitting=true;">
                @csrf

                <div class="lg:grid lg:grid-cols-3 lg:gap-6">
                    <!-- Order Form -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Customer Information -->
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-user text-blue-500"></i>
                                بيانات العميل
                            </h2>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Customer Name -->
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                        اسم العميل *
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Office Number -->
                                <div>
                                    <label for="office_number" class="block text-sm font-bold text-gray-700 mb-2">
                                        رقم المكتب *
                                    </label>
                                    <input type="text" id="office_number" name="office_number" value="{{ old('office_number', Auth::user()->office_number ?? '') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    @error('office_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6" x-data="{ warn:false }" x-effect="warn = (paymentMethod==='bank_transfer' && !document.getElementById('receipt_image')?.files.length)">
                            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-credit-card text-green-500"></i>
                                طريقة الدفع
                            </h2>
                            <template x-if="paymentMethod==='bank_transfer'">
                                <div x-show="warn" class="mb-4 px-4 py-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium flex items-center gap-2">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    الرجاء إرفاق صورة الإيصال لإتمام عملية التحويل البنكي
                                </div>
                            </template>
                            <div class="space-y-3">
                                <!-- Bank Transfer -->
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition" :class="paymentMethod === 'bank_transfer' ? 'border-blue-500 bg-blue-50' : ''">
                                    <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <div class="mr-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-university text-blue-500"></i>
                                            <span class="font-bold text-gray-900">تحويل بنكي</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">تحويل إلى الحساب البنكي للمقهى</p>
                                    </div>
                                </label>

                                <!-- Network Payment -->
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition" :class="paymentMethod === 'network' ? 'border-blue-500 bg-blue-50' : ''">
                                    <input type="radio" name="payment_method" value="network" x-model="paymentMethod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <div class="mr-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-credit-card text-green-500"></i>
                                            <span class="font-bold text-gray-900">شبكة</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">الدفع بالبطاقة البنكية</p>
                                    </div>
                                </label>

                                <!-- Cash Payment -->
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition" :class="paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50' : ''">
                                    <input type="radio" name="payment_method" value="cash" x-model="paymentMethod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <div class="mr-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-money-bills text-orange-500"></i>
                                            <span class="font-bold text-gray-900">كاش</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">الدفع نقداً عند الاستلام</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bank Transfer Details -->
                        <div x-show="paymentMethod === 'bank_transfer'" x-transition class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl shadow-sm p-6">
                            <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-university text-blue-600"></i>
                                بيانات الحساب البنكي
                            </h3>

                            <div class="grid md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-white/70 p-4 rounded-xl">
                                    <p class="text-xs text-blue-600 font-bold mb-1">اسم البنك</p>
                                    <p class="font-bold text-gray-900">{{ $bankInfo['bank_name'] }}</p>
                                </div>
                                <div class="bg-white/70 p-4 rounded-xl">
                                    <p class="text-xs text-blue-600 font-bold mb-1">اسم صاحب الحساب</p>
                                    <p class="font-bold text-gray-900">{{ $bankInfo['account_holder'] }}</p>
                                </div>
                                <div class="bg-white/70 p-4 rounded-xl md:col-span-2">
                                    <p class="text-xs text-blue-600 font-bold mb-1">رقم الحساب / IBAN</p>
                                    <p class="font-bold text-gray-900 text-lg">{{ $bankInfo['iban'] }}</p>
                                </div>
                            </div>

                            <!-- Receipt Upload -->
                            <div>
                                <label for="receipt_image" class="block text-sm font-bold text-blue-900 mb-2">
                                    <i class="fas fa-camera ml-1"></i>
                                    إرفاق صورة الإيصال <span class="text-red-600" x-show="paymentMethod==='bank_transfer'">(إلزامي)</span>
                                </label>
                                <div x-data="{ 
                                        fileName: '', 
                                        fileSize: '',
                                        handleFileChange(event) {
                                            const file = event.target.files[0];
                                            if (file) { this.fileName = file.name; this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB'; }
                                            else { this.fileName=''; this.fileSize=''; }
                                        }
                                    }" class="space-y-2">
                                    <input type="file" id="receipt_image" name="receipt_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/heic,image/heif" @change="handleFileChange($event)" :required="paymentMethod==='bank_transfer'" class="w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white">
                                    <div x-show="fileName" class="text-xs text-blue-700 bg-blue-50 p-2 rounded-lg">
                                        <i class="fas fa-file-image ml-1"></i>
                                        <span x-text="fileName"></span>
                                        <span class="text-blue-500">(<span x-text="fileSize"></span>)</span>
                                    </div>
                                </div>
                                <p class="text-xs text-blue-600 mt-2">يُفضل إرفاق صورة واضحة للإيصال</p>
                                @error('receipt_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sticky top-4">
                            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-receipt text-green-500"></i>
                                ملخص الطلب
                            </h2>

                            <!-- Products List -->
                            <div class="space-y-3 mb-4">
                                @foreach($cartProducts as $item)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                                        @if($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-mug-hot text-gray-400"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $item['product']->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $item['quantity'] }}x {{ number_format($item['product']->price, 2) }} ر.س</p>
                                    </div>
                                    <div class="text-sm font-bold text-green-600">
                                        {{ number_format($item['subtotal'], 2) }} ر.س
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Total -->
                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">المجموع الفرعي</span>
                                    <span class="font-bold text-gray-800">{{ number_format($total, 2) }} ر.س</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">التوصيل</span>
                                    <span class="font-bold text-green-600">مجاني</span>
                                </div>
                                <hr>
                                <div class="flex justify-between text-lg">
                                    <span class="font-extrabold text-gray-900">الإجمالي</span>
                                    <span class="font-extrabold text-green-600">{{ number_format($total, 2) }} ر.س</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6 space-y-3">
                                <button type="submit" :disabled="submitting" :class="submitting ? 'opacity-75 cursor-not-allowed' : ''" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-sm flex items-center justify-center gap-2 transition">
                                    <i class="fas fa-check-circle" x-show="!submitting"></i>
                                    <i class="fas fa-spinner fa-spin" x-show="submitting"></i>
                                    <span x-text="submitting ? 'جاري التنفيذ...' : 'تأكيد الطلب'"></span>
                                </button>
                                <template x-if="submitting">
                                    <p class="text-center text-[10px] text-gray-500">إذا تأخر التنفيذ أكثر من 10 ثوانٍ <a href="#" @click.prevent="submitting=false" class="underline">اضغط هنا لإعادة المحاولة</a></p>
                                </template>
                                <a href="{{ route('cart.index') }}" class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs flex items-center justify-center gap-1 transition">
                                    <i class="fas fa-arrow-right"></i>
                                    العودة للسلة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        </div>
    </x-user-layout>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="fixed top-4 left-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)">
        <div class="flex flex-col gap-1">
            <span>{{ session('success') }}</span>
            @if(session('trace'))
            <span class="text-xs text-green-100">كود التتبع: {{ session('trace') }}</span>
            @endif
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 left-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 8000)">
        <div class="flex flex-col gap-1">
            <span>{{ session('error') }}</span>
            @if(session('trace'))
            <span class="text-xs text-red-100">كود التتبع: {{ session('trace') }}</span>
            @endif
        </div>
    </div>
    @endif

    <script>
        function checkoutData() {
            return {
                paymentMethod: @json(old('payment_method', 'cash'))
            };
        }

    </script>

</body>
</html>
