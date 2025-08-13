<x-layout.guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">تأكيد كلمة المرور</h2>

    <div class="mb-6 text-sm text-gray-600 text-center">
        هذه منطقة آمنة من التطبيق. يرجى تأكيد كلمة المرور الخاصة بك قبل المتابعة.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-6">
            <x-forms.label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور</x-forms.label>
            <div class="relative">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-forms.input id="password" type="password" name="password" required autocomplete="current-password" placeholder="أدخل كلمة المرور الخاصة بك" class="w-full border border-gray-300 rounded-lg pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" />
            </div>
            <x-forms.error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-buttons.primary type="submit" class="w-full bg-amber-500 text-white py-3 rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200">
                تأكيد
            </x-buttons.primary>
        </div>
    </form>
</x-layout.guest-layout>
