<x-user-layout title="الاقتراحات والملاحظات">
    <!-- Header Section -->
    <div class="px-4 pt-6 pb-4">
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
            <div class="flex items-center space-x-3 space-x-reverse mb-2">
                <i class="fas fa-lightbulb text-amber-600 text-xl"></i>
                <h2 class="text-lg font-semibold text-amber-800">شاركنا اقتراحاتك</h2>
            </div>
            <p class="text-amber-700 text-sm">نحن نقدر آراءك واقتراحاتك لتحسين خدماتنا</p>
        </div>
    </div>

    <!-- Suggestion Form -->
    <div class="px-4 pb-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">إضافة اقتراح جديد</h3>

            <form action="{{ route('suggestions.store') }}" method="POST" class="space-y-4">
                @csrf

                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Anonymous Option -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_anonymous" name="is_anonymous" class="rounded text-amber-500 focus:ring-amber-500 mr-2" {{ old('is_anonymous') ? 'checked' : '' }}>
                    <label for="is_anonymous" class="text-sm text-gray-700">إرسال اقتراحي كمجهول</label>
                </div>

                <!-- Name Field (hidden when anonymous) -->
                <div id="nameField" class="{{ old('is_anonymous') ? 'hidden' : '' }}">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('name') border-red-500 @enderror" placeholder="اسمك الكريم">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Suggestion Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">نوع الاقتراح</label>
                    <select id="type" name="type" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('type') border-red-500 @enderror">
                        <option value="">اختر نوع الاقتراح</option>
                        <option value="suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>اقتراح منتج جديد</option>
                        <option value="complaint" {{ old('type') == 'complaint' ? 'selected' : '' }}>شكوى</option>
                        <option value="compliment" {{ old('type') == 'compliment' ? 'selected' : '' }}>ملاحظة إيجابية</option>
                    </select>
                    @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Suggestion Text -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">تفاصيل الاقتراح</label>
                    <textarea id="message" name="message" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('message') border-red-500 @enderror" placeholder="شاركنا اقتراحك بالتفصيل...">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-amber-500 text-white py-3 rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200">
                    إرسال الاقتراح
                </button>
            </form>
        </div>
    </div>

    <script>
        // إخفاء/إظهار حقل الاسم عند تحديد خيار إرسال كمجهول
        document.addEventListener('DOMContentLoaded', function() {
            const anonymousCheckbox = document.getElementById('is_anonymous');
            const nameField = document.getElementById('nameField');

            anonymousCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    nameField.classList.add('hidden');
                    document.getElementById('name').value = '';
                } else {
                    nameField.classList.remove('hidden');
                }
            });
        });

    </script>
</x-user-layout>
