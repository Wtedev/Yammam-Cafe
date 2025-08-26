<x-user-layout title="غير مصرح - 403">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-lg mx-auto text-center">
            <!-- Error Icon and Message -->
            <div class="mb-8">
                <div class="text-8xl font-bold text-gray-400 mb-4">403</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">غير مصرح لك</h2>
                <p class="text-gray-600">عذراً، ليس لديك الصلاحية للوصول إلى هذه الصفحة</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mb-8">
                <a href="{{ route('home') }}" class="block bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    العودة للصفحة الرئيسية
                </a>
                @guest
                <a href="{{ route('login') }}" class="block bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
                    تسجيل الدخول
                </a>
                @endguest
            </div>

            <!-- Contact Section -->
            <div class="mt-8 text-center">
                <a href="{{ route('contact.developer') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-code text-sm"></i>
                    <span class="text-sm">تواصل مع المطور</span>
                </a>
            </div>
        </div>
    </div>
</x-user-layout>
