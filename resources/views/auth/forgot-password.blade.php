<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">استعادة كلمة المرور</h2>

    <div class="mb-6 text-sm text-gray-600 text-center">
        نسيت كلمة المرور؟ لا مشكلة. أدخل رقم الجوال وسنرسل لك رابط إعادة تعيين كلمة المرور.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="px-4 sm:px-0">
        @csrf

        <!-- Mobile Number -->
        <div class="mb-6">
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">رقم الجوال</label>
            <div>
                <input id="mobile" type="tel" name="mobile" value="{{ old('mobile') }}" required autofocus placeholder="أدخل رقم الجوال" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" dir="ltr" />
            </div>
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-medium hover:bg-gray-900 transition-colors duration-200 shadow-sm">
                إرسال رابط استعادة كلمة المرور
            </button>
        </div>

        <div class="text-center pt-4 border-t border-gray-200">
            <a href="{{ route('login') }}" class="text-black hover:text-gray-800 font-medium text-sm">
                العودة إلى تسجيل الدخول
            </a>
        </div>

        <div class="text-center mt-4">
            <a href="/" class="text-black hover:text-gray-800 font-medium text-sm">
                العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </form>
</x-guest-layout>
