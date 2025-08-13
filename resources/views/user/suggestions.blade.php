<x-user-layout title="اقتراحاتي">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">اقتراحاتي</h1>
                    <p class="text-gray-600 mt-1">شاركنا آرائك واقتراحاتك لتحسين الخدمة</p>
                </div>
                <a href="{{ route('suggestions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة اقتراح جديد
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <x-user.search-bar page="suggestions" />

        <!-- Notice: Anonymous suggestions won't show here -->
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-lg px-4 py-3 mb-4 text-sm flex items-center">
            <i class="fas fa-info-circle ml-2"></i>
            لن تظهر هنا اقتراحاتك التي قمت بإرسالها كمجهول
        </div>

        @if(isset($suggestions) && $suggestions->count() > 0)
        <!-- Suggestions List (أسلوب الأدمن مع طابع المستخدم) -->
        <div class="rounded-2xl bg-white/90 shadow-sm border border-blue-50 mb-6">
            <div class="flex items-center justify-between px-4 py-3 border-b border-blue-50">
                <h3 class="sr-only">جميع الاقتراحات</h3>
            </div>
            <ul class="divide-y divide-blue-50">
                @foreach($suggestions as $suggestion)
                <li onclick="window.location='{{ route('suggestions.show', $suggestion) }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-blue-50/60">
                    <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                        <!-- موبايل: كارد تفاعلي -->
                        <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-blue-50 p-3 mb-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-blue-600 font-bold text-lg">#{{ $suggestion->id }}</span>
                                @if($suggestion->is_new_view)
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700">جديد</span>
                                @endif
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                            match($suggestion->type) {
                                                'suggestion' => 'bg-blue-100 text-blue-800',
                                                'complaint' => 'bg-red-100 text-red-800',
                                                'compliment' => 'bg-green-100 text-green-800',
                                                default => 'bg-gray-200 text-gray-700',
                                            }
                                        }}">{{ $suggestion->type_text }}</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                            match($suggestion->status) {
                                                'new' => 'bg-yellow-100 text-yellow-800',
                                                'reviewed' => 'bg-blue-100 text-blue-800',
                                                'responded' => 'bg-green-100 text-green-800',
                                                'closed' => 'bg-gray-100 text-gray-800',
                                                default => 'bg-gray-200 text-gray-700',
                                            }
                                        }}">{{ $suggestion->status_text }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-user"></i>
                                <span>{{ $suggestion->name ?? ($suggestion->user->name ?? 'مجهول') }}</span>
                                <span class="mx-1">|</span>
                                <i class="fas fa-calendar"></i>
                                <span>{{ $suggestion->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-xs text-gray-600 mt-1">
                                <span class="line-clamp-2">{{ Str::limit($suggestion->suggestion, 100) }}</span>
                            </div>
                        </div>

                        <!-- ديسكتوب: صف تفاعلي مختصر -->
                        <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                            <span class="text-blue-600 font-bold text-base md:text-lg shrink-0">#{{ $suggestion->id }}</span>
                            @if($suggestion->is_new_view)
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700">جديد</span>
                            @endif
                            <span class="hidden md:inline-block text-gray-400">|</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $suggestion->name ?? ($suggestion->user->name ?? 'مجهول') }}
                                </span>
                                <span class="text-xs text-gray-400 truncate">
                                    {{ $suggestion->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-2 md:gap-4 ml-auto">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                        match($suggestion->type) {
                                            'suggestion' => 'bg-blue-100 text-blue-800',
                                            'complaint' => 'bg-red-100 text-red-800',
                                            'compliment' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-200 text-gray-700',
                                        }
                                    }}" style="min-width: 64px; text-align:center;">{{ $suggestion->type_text }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{
                                        match($suggestion->status) {
                                            'new' => 'bg-yellow-100 text-yellow-800',
                                            'reviewed' => 'bg-blue-100 text-blue-800',
                                            'responded' => 'bg-green-100 text-green-800',
                                            'closed' => 'bg-gray-100 text-gray-800',
                                            default => 'bg-gray-200 text-gray-700',
                                        }
                                    }}" style="min-width: 64px; text-align:center;">{{ $suggestion->status_text }}</span>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="mt-6 flex justify-center">
                {{ $suggestions->links() }}
            </div>
        </div>
        @else
        <!-- Empty Content Area -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-lightbulb text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">لا توجد اقتراحات بعد</h2>
                <p class="text-gray-500 mb-6">ساعدنا في تطوير خدماتنا من خلال مشاركة اقتراحاتك وآرائك</p>
                <a href="{{ route('suggestions.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-comment-alt ml-2"></i>
                    إضافة اقتراح
                </a>
            </div>
        </div>
        @endif
    </div>
</x-user-layout>
