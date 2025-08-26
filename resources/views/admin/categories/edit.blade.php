<x-layout.admin-layout title="تعديل التصنيف - {{ $category->name }}">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">تعديل التصنيف</h1>
                <p class="text-gray-600 mt-1">تعديل بيانات التصنيف: {{ $category->name }}</p>
            </div>
            
            <a href="{{ route('admin.categories.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors">
                <i class="fas fa-arrow-right ml-2"></i>
                عودة للقائمة
            </a>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        اسم التصنيف <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="مثال: مشروبات ساخنة"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                <!-- Products Count Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 ml-2"></i>
                        <span class="text-sm text-blue-700">
                            هذا التصنيف يحتوي على <strong>{{ $category->products->count() }}</strong> منتج
                        </span>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout.admin-layout>
