<x-layout.guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">تحقق من بريدك الإلكتروني</h2>

    <div class="mb-6 text-sm text-gray-600 text-center px-4 sm:px-0">
        شكرًا للتسجيل! قبل البدء، هل يمكنك التحقق من عنوان بريدك الإلكتروني بالنقر على الرابط الذي أرسلناه إليك للتو؟ إذا لم تتلق البريد الإلكتروني، فسنرسل لك رابطًا آخر بكل سرور.
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="p-4 mb-6 text-sm rounded-lg bg-green-50 text-green-600 text-center font-medium">
        تم إرسال رابط تحقق جديد إلى عنوان البريد الإلكتروني الذي قدمته أثناء التسجيل.
    </div>
    @endif

    <div class="mb-6 px-4 sm:px-0">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-buttons.primary type="submit" class="w-full bg-black text-white py-4 rounded-xl font-medium hover:bg-gray-900 transition-colors duration-200 shadow-sm">
                إعادة إرسال بريد التحقق
            </x-buttons.primary>
        </form>
    </div>

    <div class="text-center px-4 sm:px-0 pt-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-black hover:text-gray-800 font-medium">
                تسجيل الخروج
            </button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="/" class="text-black hover:text-gray-800 font-medium text-sm">
            العودة إلى الصفحة الرئيسية
        </a>
    </div>
</x-layout.guest-layout>
