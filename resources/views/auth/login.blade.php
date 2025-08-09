<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">تسجيل الدخول</h2>

    <form method="POST" action="{{ route('login') }}" class="px-4 sm:px-0">
        @csrf

        <!-- Mobile Number -->
        <div class="mb-4">
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">رقم الجوال</label>
            <div>
                <input id="mobile" type="tel" name="mobile" value="{{ old('mobile') }}" required autofocus placeholder="أدخل رقم الجوال" class="w-full border @error('mobile') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" dir="ltr" />
            </div>
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور</label>
            <div>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="أدخل كلمة المرور" class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-black shadow-sm focus:ring-black">
                <span class="mr-2 text-sm text-gray-600">تذكرني</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-sm text-black hover:text-gray-800 font-medium" href="{{ route('password.request') }}">
                نسيت كلمة المرور؟
            </a>
            @endif
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full bg-gradient-to-r from-gray-900 to-black text-white py-4 rounded-xl font-medium hover:from-black hover:to-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                تسجيل الدخول
            </button>
        </div>

        <div class="text-center mb-6">
            <p class="text-sm text-gray-600">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="text-black hover:text-gray-800 font-medium">
                    إنشاء حساب جديد
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
