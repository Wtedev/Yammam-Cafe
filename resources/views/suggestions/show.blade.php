<x-user-layout :title="'تفاصيل الاقتراح #' . $suggestion->id">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        تفاصيل الاقتراح
                        <span class="text-blue-600">#{{ $suggestion->id }}</span>
                    </h1>
                    <p class="text-gray-600 mt-1 flex items-center gap-2">
                        <i class="fas fa-clock"></i>
                        <span>{{ $suggestion->created_at->format('Y-m-d H:i') }}</span>
                    </p>
                </div>
                <a href="{{ route('my-suggestions') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-right ml-2"></i>
                    رجوع لاقتراحاتي
                </a>
            </div>
        </div>

        @php
        $statusClasses = [
        'new' => 'bg-yellow-100 text-yellow-800',
        'reviewed' => 'bg-blue-100 text-blue-800',
        'responded' => 'bg-green-100 text-green-800',
        'closed' => 'bg-gray-100 text-gray-800',
        ];
        $typeClasses = [
        'suggestion' => 'bg-blue-100 text-blue-800',
        'complaint' => 'bg-red-100 text-red-800',
        'compliment' => 'bg-green-100 text-green-800',
        ];

        $steps = ['new' => 'جديد', 'reviewed' => 'مراجع', 'responded' => 'مجاب عليه', 'closed' => 'مغلق'];
        $keys = array_keys($steps);
        $currentIndex = array_search($suggestion->status, $keys);
        if ($currentIndex === false) { $currentIndex = 0; }
        @endphp

        <!-- Top cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Sender Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-bold text-blue-700">المرسل</span>
                    @if($suggestion->anonymous)
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">مجهول</span>
                    @endif
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-user text-gray-400"></i>
                        <span>{{ $suggestion->name ?? ($suggestion->user->name ?? 'غير محدد') }}</span>
                    </div>
                    @if(optional($suggestion->user)->mobile)
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-phone text-gray-400"></i>
                        <span>{{ $suggestion->user->mobile }}</span>
                    </div>
                    @endif
                    @if(optional($suggestion->user)->office_number)
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="fas fa-building text-gray-400"></i>
                        <span>مكتب {{ $suggestion->user->office_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Suggestion meta -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-bold text-blue-700">تفاصيل</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $typeClasses[$suggestion->type] ?? 'bg-gray-200 text-gray-700' }}">{{ $suggestion->type_text }}</span>
                </div>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar"></i>
                        <span>تاريخ الإرسال: {{ $suggestion->created_at->format('Y-m-d') }}</span>
                    </div>
                    @if($suggestion->first_viewed_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-eye"></i>
                        <span>تمت مراجعته: {{ $suggestion->first_viewed_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    @if($suggestion->responded_at)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-reply"></i>
                        <span>تاريخ الرد: {{ $suggestion->responded_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-bold text-blue-700">حالة الاقتراح</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses[$suggestion->status] ?? 'bg-gray-200 text-gray-700' }}">{{ $suggestion->status_text }}</span>
                </div>

                <!-- Timeline -->
                <div class="flex items-center justify-between mt-2">
                    @foreach($steps as $key => $label)
                    @php $index = array_search($key, $keys); @endphp
                    <div class="flex-1 flex items-center">
                        <div class="flex flex-col items-center text-center w-20">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center text-xs font-bold
                                    {{ $index <= $currentIndex ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                {{ $index + 1 }}
                            </div>
                            <span class="mt-1 text-[11px] {{ $index <= $currentIndex ? 'text-blue-700' : 'text-gray-400' }}">{{ $label }}</span>
                        </div>
                        @if(!$loop->last)
                        <div class="flex-1 h-0.5 mx-2 {{ $index < $currentIndex ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <!-- Suggestion Text -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-blue-50 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3">نص الاقتراح</h2>
                <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $suggestion->suggestion }}</div>
            </div>

            <!-- Admin Response -->
            <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-3">رد الإدارة</h2>
                @if($suggestion->admin_response)
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="text-gray-800 whitespace-pre-line">{{ $suggestion->admin_response }}</div>
                    @if($suggestion->responded_at)
                    <div class="flex items-center gap-2 text-gray-500 text-xs">
                        <i class="fas fa-calendar-check"></i>
                        <span>بتاريخ: {{ $suggestion->responded_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-sm text-gray-500">
                    لم يتم إضافة رد حتى الآن. سنقوم بإخطارك عند وجود رد.
                </div>
                @endif
            </div>
        </div>

        <!-- Footer actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('my-suggestions') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">رجوع</a>
        </div>
    </div>
</x-user-layout>
