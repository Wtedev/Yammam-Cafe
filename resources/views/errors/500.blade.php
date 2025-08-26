<x-user-layout title="خطأ في الخادم - 500">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-lg mx-auto text-center">
            <!-- Error Icon and Message -->
            <div class="mb-8">
                <div class="text-8xl font-bold text-gray-400 mb-4">500</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">خطأ في الخادم</h2>
                <p class="text-gray-600">عذراً، حدث خطأ غير متوقع. نعمل على إصلاح المشكلة</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mb-8">
                <button onclick="window.location.reload()" class="block w-full bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    إعادة تحميل الصفحة
                </button>
                <a href="{{ route('home') }}" class="block bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
                    العودة للصفحة الرئيسية
                </a>
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
