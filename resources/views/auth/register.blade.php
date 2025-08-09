<x-guest-layout>
    <!-- رسائل الخطأ العامة -->
    @if ($errors->any())
    <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
        <div class="text-red-600 text-sm font-medium mb-2">يوجد خطأ في البيانات المدخلة:</div>
        <ul class="text-red-600 text-sm list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- رسائل النجاح -->
    @if (session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200">
        <div class="text-green-600 text-sm font-medium">{{ session('success') }}</div>
    </div>
    @endif

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">إنشاء حساب جديد</h2>

    <form method="POST" action="{{ route('register') }}" class="px-4 sm:px-0">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم</label>
            <div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="أدخل اسمك" class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Mobile Number -->
        <div class="mb-4">
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">رقم الجوال</label>
            <div>
                <input id="mobile" type="tel" name="mobile" value="{{ old('mobile') }}" required placeholder="أدخل رقم الجوال" class="w-full border @error('mobile') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" dir="ltr" />
            </div>
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <!-- Office Number -->
        <div class="mb-4">
            <label for="office_number" class="block text-sm font-medium text-gray-700 mb-2">رقم المكتب</label>
            <div>
                <input id="office_number" type="tel" name="office_number" value="{{ old('office_number') }}" placeholder="أدخل رقم المكتب (اختياري)" class="w-full border @error('office_number') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" dir="ltr" />
            </div>
            <x-input-error :messages="$errors->get('office_number')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور</label>
            <div>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="أدخل كلمة المرور" class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور</label>
            <div>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="أعد إدخال كلمة المرور" class="w-full border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full bg-gradient-to-r from-gray-900 to-black text-white py-4 rounded-xl font-medium hover:from-black hover:to-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                تسجيل
            </button>
        </div>

        <div class="text-center mb-6">
            <p class="text-sm text-gray-600">
                لديك حساب بالفعل؟
                <a href="{{ route('login') }}" class="text-black hover:text-gray-800 font-medium">
                    تسجيل الدخول
                </a>
            </p>
        </div>

        <div class="text-center pt-4 border-t border-gray-200">
            <a href="/" class="text-black hover:text-gray-800 font-medium text-sm">
                العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </form>
</x-guest-layout>
