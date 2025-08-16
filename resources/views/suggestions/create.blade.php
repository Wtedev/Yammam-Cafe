<x-user-layout title="إرسال اقتراح">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-yellow-500"></i>
                        إرسال اقتراح
                    </h1>
                    <p class="text-gray-600 mt-1">يسعدنا سماع اقتراحاتك أو ملاحظاتك لتحسين تجربتك</p>
                </div>
                <a href="{{ route('my-suggestions') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                    <span class="hidden sm:inline ml-2">رجوع لاقتراحاتي</span>
                </a>
            </div>
        </div>

        <!-- Form and tips -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Form Card -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-blue-50 p-6" x-data="{
                    anonymous: {{ old('is_anonymous') ? 'true' : 'false' }},
                    message: `{{ str_replace(["`", "\\"], ['\`','\\\\'], str_replace(["\n","\r"], ["\\n", ""], old('message',''))) }}`,
                    type: '{{ old('type','suggestion') }}',
                    max: 1000,
                    get progress() { return Math.min(100, Math.round((this.message.length / this.max) * 100)); }
                 }">

                @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-3 text-red-700 text-sm">
                    <ul class="list-disc pr-5 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('suggestions.store') }}" class="space-y-6">
                    @csrf

                    <!-- Anonymous + Name (moved up) -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl p-3">
                            <div class="flex items-center gap-3">
                                <!-- Toggle: clickable track with moving knob -->
                                <button type="button" @click="anonymous = !anonymous" class="relative inline-flex items-center cursor-pointer focus:outline-none" :aria-pressed="anonymous">
                                    <input id="is_anonymous" name="is_anonymous" type="checkbox" value="1" x-model="anonymous" class="sr-only">
                                    <div class="relative w-12 h-7 rounded-full transition-colors duration-200" :class="anonymous ? 'bg-blue-600' : 'bg-gray-300'">
                                        <span class="absolute top-1 left-1 w-5 h-5 bg-white rounded-full transition-transform duration-200 ease-in-out" :style="anonymous ? 'transform: translateX(20px)' : 'transform: translateX(0px)'"></span>
                                    </div>
                                </button>
                                <label for="is_anonymous" class="text-sm text-gray-700 cursor-pointer select-none" @click="anonymous = !anonymous">
                                    إرسال كمجهول (لن يظهر اسمك)
                                </label>
                            </div>
                            <i class="fas fa-user-secret text-gray-400"></i>
                        </div>
                        <div x-show="!anonymous" x-cloak>
                            <label for="name" class="block text-sm font-bold text-gray-800 mb-1">اسمك</label>
                            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name ?? '') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="اكتب اسمك هنا">
                            @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Type: Segmented buttons -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">اختر نوع الرسالة</label>
                        <input type="hidden" name="type" :value="type">
                        <div class="inline-flex w-full gap-2 flex-wrap">
                            <button type="button" @click="type='suggestion'" :class="type==='suggestion' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <i class="fas fa-lightbulb"></i>
                                اقتراح
                            </button>
                            <button type="button" @click="type='complaint'" :class="type==='complaint' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                شكوى
                            </button>
                            <button type="button" @click="type='compliment'" :class="type==='compliment' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <i class="fas fa-heart"></i>
                                إطراء
                            </button>
                        </div>
                        @error('type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="message" class="block text-sm font-bold text-gray-800">نص الرسالة</label>
                            <span class="text-xs text-gray-500" x-text="message.length + ' / ' + max"></span>
                        </div>
                        <div class="relative mt-2">
                            <textarea id="message" name="message" rows="8" x-model="message" maxlength="1000" class="block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="اكتب اقتراحك أو ملاحظتك بالتفصيل..."></textarea>
                            <div class="absolute -bottom-2 right-0 left-0 h-1 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full bg-blue-500 transition-all" :style="`width: ${progress}%`"></div>
                            </div>
                        </div>
                        @error('message')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-2">
                        <div class="text-xs text-gray-500 flex items-center gap-2">
                            <i class="fas fa-shield-alt"></i>
                            نحترم خصوصيتك. لن نشارك بياناتك خارج نطاق الخدمة.
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="submit" :disabled="message.length === 0" :class="message.length === 0 ? 'bg-blue-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'" class="inline-flex items-center px-5 py-2.5 text-white rounded-lg transition-colors text-sm">
                                <i class="fas fa-paper-plane ml-2"></i>
                                إرسال
                            </button>
                            <a href="{{ route('my-suggestions') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tips / Info -->
            <div class="space-y-4">
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-amber-800 text-sm">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-info-circle mt-0.5"></i>
                        <div>
                            <div class="font-bold mb-1">تنبيه</div>
                            لن تظهر ضمن صفحة "اقتراحاتي" الرسائل التي ترسلها كمجهول.
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-blue-50 rounded-2xl p-4 text-sm text-gray-600">
                    <div class="font-bold text-gray-800 mb-2">نصائح لاقتراح فعال</div>
                    <ul class="list-disc pr-5 space-y-1">
                        <li>اكتب الفكرة أو المشكلة بوضوح وباختصار.</li>
                        <li>اذكر أمثلة أو سيناريو إن أمكن.</li>
                        <li>اقترح حلاً أو تحسيناً متوقعاً.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
