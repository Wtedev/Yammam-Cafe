<x-admin-layout title="عرض الاقتراح">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">تفاصيل الاقتراح</h2>
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('admin.suggestions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-1"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Suggestion Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">معلومات الاقتراح</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">النوع:</span>
                            <span class="font-medium">
                                @if($suggestion->type == 'suggestion')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">اقتراح</span>
                                @elseif($suggestion->type == 'complaint')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">شكوى</span>
                                @elseif($suggestion->type == 'inquiry')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">استفسار</span>
                                @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $suggestion->type }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">الحالة:</span>
                            <span class="font-medium">
                                @if($suggestion->status == 'new')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">جديد</span>
                                @elseif($suggestion->status == 'reviewed')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">تمت المراجعة</span>
                                @elseif($suggestion->status == 'responded')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">تم الرد</span>
                                @elseif($suggestion->status == 'closed')
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">مغلق</span>
                                @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $suggestion->status }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">تاريخ الإرسال:</span>
                            <span class="font-medium">{{ $suggestion->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">معلومات المرسل</h3>
                    <div class="space-y-2">
                        @if($suggestion->is_anonymous)
                        <div class="bg-gray-100 text-gray-600 p-3 rounded-lg text-center">
                            <i class="fas fa-user-secret text-xl mb-2"></i>
                            <p>تم إرسال هذا الاقتراح بشكل مجهول</p>
                        </div>
                        @else
                        <div class="flex justify-between">
                            <span class="text-gray-600">الاسم:</span>
                            <span class="font-medium">{{ $suggestion->name }}</span>
                        </div>
                        @if($suggestion->mobile)
                        <div class="flex justify-between">
                            <span class="text-gray-600">رقم الجوال:</span>
                            <span class="font-medium">{{ $suggestion->mobile }}</span>
                        </div>
                        @endif
                        @if($suggestion->email)
                        <div class="flex justify-between">
                            <span class="text-gray-600">البريد الإلكتروني:</span>
                            <span class="font-medium">{{ $suggestion->email }}</span>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Suggestion Content -->
            <div class="bg-white border border-gray-200 rounded-lg p-5 mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">محتوى الاقتراح</h3>
                <div class="bg-gray-50 p-4 rounded-lg text-gray-700 whitespace-pre-line">
                    {{ $suggestion->suggestion }}
                </div>
            </div>

            <!-- Admin Response Form -->
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h3 class="font-semibold text-gray-800 mb-3">الرد على الاقتراح</h3>

                <form action="{{ route('admin.suggestions.update-status', $suggestion) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 mb-2">تغيير الحالة</label>
                        <select id="status" name="status" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <option value="new" {{ $suggestion->status == 'new' ? 'selected' : '' }}>جديد</option>
                            <option value="reviewed" {{ $suggestion->status == 'reviewed' ? 'selected' : '' }}>تمت المراجعة</option>
                            <option value="responded" {{ $suggestion->status == 'responded' ? 'selected' : '' }}>تم الرد</option>
                            <option value="closed" {{ $suggestion->status == 'closed' ? 'selected' : '' }}>مغلق</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="admin_response" class="block text-gray-700 mb-2">الرد</label>
                        <textarea id="admin_response" name="admin_response" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ $suggestion->admin_response }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-colors duration-200">
                            حفظ الرد
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
