<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">إعادة تعيين كلمة المرور</h2>

    <form method="POST" action="{{ route('password.store') }}" class="px-4 sm:px-0">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Mobile Number -->
        <div class="mb-4">
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">رقم الجوال</label>
            <div>
                <input id="mobile" type="tel" name="mobile" value="{{ old('mobile', $request->mobile) }}" required autofocus placeholder="أدخل رقم الجوال" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" dir="ltr" />
            </div>
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة</label>
            <div>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="أدخل كلمة المرور الجديدة" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور</label>
            <div>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="أعد إدخال كلمة المرور الجديدة" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full bg-black text-white py-4 rounded-xl font-medium hover:bg-gray-900 transition-colors duration-200 shadow-sm">
                إعادة تعيين كلمة المرور
            </button>
        </div>

        <div class="text-center pt-4 border-t border-gray-200">
            <a href="{{ route('login') }}" class="text-black hover:text-gray-800 font-medium text-sm">
                العودة إلى تسجيل الدخول
            </a>
        </div>
    </form>
</x-guest-layout>
