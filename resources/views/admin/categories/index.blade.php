<x-layout.admin-layout title="إدارة التصنيفات">
    <div class="container mx-auto px-4 py-2">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle ml-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-xl shadow transition-colors duration-200">
                    <i class="fas fa-plus"></i>
                    <span>إضافة تصنيف جديد</span>
                </a>
            </div>
        </div>

        <!-- التصنيفات -->
        <h2 class="text-xl font-bold text-gray-900 mb-4">التصنيفات</h2>

        <!-- Categories List -->
        <div class="rounded-2xl bg-white/90 shadow-sm border border-green-50 mb-6">
            <div class="flex items-center justify-between px-4 py-3 border-b border-green-50">
                <h3 class="sr-only">جميع التصنيفات</h3>
            </div>
            @if($categories->count() > 0)
            <ul class="divide-y divide-green-50">
                @foreach($categories as $category)
                <li onclick="window.location='{{ route('admin.categories.show', $category) }}'" class="group cursor-pointer transition-colors px-2 md:px-4 py-3 hover:bg-green-50/60">
                    <div class="flex flex-col md:flex-row md:items-center md:gap-2">
                        <!-- موبايل: كارد تفاعلي -->
                        <div class="flex md:hidden flex-col gap-2 bg-white rounded-xl shadow-sm border border-green-50 p-3 mb-1">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-tag text-white text-sm"></i>
                                </div>
                                <span class="text-green-600 font-bold text-lg">{{ $category->name }}</span>
                                @if($category->products->count() == 0)
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
                                    فارغ
                                </span>
                                @else
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">
                                    {{ $category->products->count() }} منتج
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-boxes"></i>
                                <span>{{ $category->products->where('is_available', true)->count() }} متوفر</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                                <i class="fas fa-clock"></i>
                                <span>{{ $category->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <!-- لابتوب: نفس الشكل القديم -->
                        <div class="hidden md:flex flex-1 flex-row items-center gap-3 min-w-0">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-tag text-white"></i>
                            </div>
                            <span class="hidden md:inline-block text-gray-400">|</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-2 md:gap-4 ml-auto">
                            @if($category->products->count() == 0)
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700" style="min-width: 64px; text-align:center;">
                                فارغ
                            </span>
                            @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800" style="min-width: 64px; text-align:center;">
                                {{ $category->products->count() }} منتج
                            </span>
                            @endif
                            <span class="text-green-600 font-bold text-sm md:text-base">{{ $category->products->where('is_available', true)->count() }} متوفر</span>
                            
                            <!-- Action Buttons -->
                            <div class="flex items-center gap-1" onclick="event.stopPropagation()">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="inline-flex items-center px-2 py-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-xs font-medium rounded transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirmDelete{{ $category->id }}()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-2 py-1 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-medium rounded transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <script>
                                    function confirmDelete{{ $category->id }}() {
                                        @if($category->products->count() > 0)
                                        return confirm('⚠️ تحذير!\n\nالتصنيف "{{ $category->name }}" يحتوي على {{ $category->products->count() }} منتج.\n\nعند الحذف سيتم إزالة ارتباط المنتجات.\nهل أنت متأكد؟');
                                        @else
                                        return confirm('هل أنت متأكد من حذف التصنيف "{{ $category->name }}"؟');
                                        @endif
                                    }
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-tags text-gray-300 text-4xl mb-4"></i>
                <p class="mb-4">لا توجد تصنيفات حتى الآن</p>
                <a href="{{ route('admin.categories.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة تصنيف جديد
                </a>
            </div>
            @endif
        </div>
    </div>
</x-layout.admin-layout>
