<x-layout.admin-layout title="الملف الشخصي">
    <div class="container mx-auto px-4 py-2">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle ml-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <span class="font-medium">يوجد أخطاء في البيانات المدخلة:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xl">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name ?? 'المدير' }}</h1>
                        <p class="text-gray-600">{{ auth()->user()->role === 'admin' ? 'مدير النظام' : 'مستخدم' }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->mobile ?? 'رقم الجوال غير محدد' }}</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-cog text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">معلومات الملف الشخصي</h2>
                <p class="text-gray-600 text-sm">قم بتحديث معلوماتك الشخصية والاتصال</p>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                            الاسم الأول <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', explode(' ', auth()->user()->name ?? '')[0] ?? '') }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror" placeholder="أدخل الاسم الأول">
                        </div>
                        @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                            اسم العائلة <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', implode(' ', array_slice(explode(' ', auth()->user()->name ?? ''), 1)) ?: '') }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror" placeholder="أدخل اسم العائلة">
                        </div>
                        @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Mobile Number -->
                <div>
                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">
                        رقم الجوال <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', auth()->user()->mobile ?? '') }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobile') border-red-500 @enderror" placeholder="أدخل رقم الجوال" dir="ltr">
                    </div>
                    @error('mobile')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Office Number (Read Only) -->
                @if(auth()->user()->office_number)
                <div>
                    <label for="office_number" class="block text-sm font-medium text-gray-700 mb-2">
                        رقم المكتب
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-building text-gray-400"></i>
                        </div>
                        <input type="text" id="office_number" value="{{ auth()->user()->office_number }}" readonly class="block w-full pr-10 pl-3 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-600" placeholder="رقم المكتب">
                    </div>
                    <p class="text-gray-500 text-sm mt-1">رقم المكتب غير قابل للتعديل</p>
                </div>
                @endif

                <!-- Role (Read Only) -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        الدور في النظام
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-shield-alt text-gray-400"></i>
                        </div>
                        <input type="text" id="role" value="{{ auth()->user()->role === 'admin' ? 'مدير النظام' : 'مستخدم' }}" readonly class="block w-full pr-10 pl-3 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-600">
                    </div>
                    <p class="text-gray-500 text-sm mt-1">الدور في النظام غير قابل للتعديل</p>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg shadow-sm border border-gray-200 transition-colors duration-200">
                        <i class="fas fa-arrow-right"></i>
                        <span>العودة للوحة التحكم</span>
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg shadow-sm transition-colors duration-200">
                        <i class="fas fa-save"></i>
                        <span>حفظ التغييرات</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-900 mb-2">معلومات الحساب</h2>
                <p class="text-gray-600 text-sm">معلومات إضافية حول حسابك</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">تاريخ بدء العضوية:</span>
                        <span class="text-sm text-gray-900">{{ auth()->user()->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">عدد الطلبات الكلية:</span>
                        <span class="text-sm text-gray-900">{{ \App\Models\Order::count() }}</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">المبيعات الكلية:</span>
                        <span class="text-sm text-gray-900">{{ number_format(\App\Models\Order::whereNotIn('status', ['cancelled'])->sum('total_price'), 2) }} ر.س</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.admin-layout>
