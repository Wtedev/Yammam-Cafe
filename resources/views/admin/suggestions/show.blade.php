<x-layout.admin-layout title="تفاصيل الاقتراح">
    <div class="container mx-auto py-8">
        <!-- رسائل النجاح والخطأ -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-600"></i>
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
                <span class="font-semibold">يرجى تصحيح الأخطاء التالية:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-purple-900 flex items-center gap-2">
                <i class="fas fa-lightbulb text-purple-400"></i>
                تفاصيل الاقتراح <span class="text-purple-400">#{{ $suggestion->id }}</span>
            </h2>
            <a href="{{ route('admin.suggestions.index') }}" class="bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-lg font-medium shadow-sm border border-purple-100 transition flex items-center gap-2">
                <i class="fas fa-arrow-right"></i>
                رجوع للقائمة
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="rounded-2xl bg-white/90 shadow-sm border border-purple-50 flex flex-col gap-2 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-bold text-purple-700">نوع الاقتراح:</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                        match($suggestion->type) {
                            'suggestion' => 'bg-blue-100 text-blue-800',
                            'complaint' => 'bg-red-100 text-red-800',
                            'compliment' => 'bg-green-100 text-green-800',
                            default => 'bg-gray-200 text-gray-700',
                        }
                    }}" style="min-width: 56px; text-align:center;">{{
                        match($suggestion->type) {
                            'suggestion' => 'اقتراح',
                            'complaint' => 'شكوى',
                            'compliment' => 'إعجاب',
                            default => $suggestion->type,
                        }
                    }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-purple-400"></i>
                    <span class="text-xs font-bold text-purple-700">تاريخ الإرسال:</span>
                    <span class="text-xs text-gray-700">{{ $suggestion->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>
            <div class="rounded-2xl bg-white/90 shadow-sm border border-purple-50 flex flex-col gap-2 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-user text-purple-400"></i>
                    <span class="text-base font-bold text-purple-900">معلومات المقترِح</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">الاسم:</span>
                    <span class="text-gray-900">{{ $suggestion->name ?? ($suggestion->anonymous ? 'مجهول' : ($suggestion->user->name ?? 'غير محدد')) }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700">البريد الإلكتروني:</span>
                    <span class="text-gray-900">{{ $suggestion->anonymous ? 'مخفي' : ($suggestion->user->email ?? 'غير محدد') }}</span>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white/90 shadow-sm border border-purple-50 p-4 mb-6">
            <h3 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                <i class="fas fa-align-left text-purple-400"></i>
                نص الاقتراح
            </h3>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-gray-800 leading-relaxed">{{ $suggestion->suggestion }}</p>
            </div>

            <!-- حالة الاقتراح -->
            <div class="mt-4 flex items-center gap-2">
                <span class="font-medium text-gray-700">الحالة الحالية:</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{
                    match($suggestion->status) {
                        'new' => 'bg-yellow-100 text-yellow-800',
                        'reviewing' => 'bg-blue-100 text-blue-800',
                        'approved' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        'implemented' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-200 text-gray-700',
                    }
                }}">{{
                    match($suggestion->status) {
                        'new' => 'جديد',
                        'reviewing' => 'قيد المراجعة',
                        'approved' => 'موافق عليه',
                        'rejected' => 'مرفوض',
                        'implemented' => 'تم التنفيذ',
                        default => $suggestion->status,
                    }
                }}</span>
            </div>

            <!-- نموذج تحديث الحالة -->
            <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST" class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                @csrf
                @method('PATCH')

                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">تحديث حالة الاقتراح:</label>
                        <select name="status" id="status" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" required>
                            <option value="new" {{ $suggestion->status === 'new' ? 'selected' : '' }}>جديد</option>
                            <option value="reviewing" {{ $suggestion->status === 'reviewing' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ $suggestion->status === 'approved' ? 'selected' : '' }}>موافق عليه</option>
                            <option value="rejected" {{ $suggestion->status === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            <option value="implemented" {{ $suggestion->status === 'implemented' ? 'selected' : '' }}>تم التنفيذ</option>
                        </select>
                    </div>
                </div>

                <!-- زر حفظ التعديلات -->
                <div class="mt-6 text-center">
                    <button type="submit" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-bold text-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-save"></i>
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.admin-layout>
