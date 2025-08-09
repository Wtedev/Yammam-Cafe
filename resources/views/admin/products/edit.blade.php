<x-admin-layout title="تعديل المنتج">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">تعديل المنتج: {{ $product->name }}</h1>
            <div class="flex space-x-2 space-x-reverse">
                <a href="{{ route('admin.products.show', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-eye ml-2"></i>
                    عرض
                </a>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                اسم المنتج <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="أدخل اسم المنتج">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                الوصف <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="4" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="أدخل وصف المنتج">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                الفئة <span class="text-red-500">*</span>
                            </label>
                            <select id="category" name="category" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                                <option value="">اختر الفئة</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                السعر (ريال) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror" placeholder="0.00">
                            @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                نوع المنتج
                            </label>
                            <select id="type" name="type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                                <option value="fixed" {{ old('type', $product->type) == 'fixed' ? 'selected' : '' }}>ثابت</option>
                                <option value="weekly" {{ old('type', $product->type) == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Calories -->
                        <div>
                            <label for="calories" class="block text-sm font-medium text-gray-700 mb-2">
                                السعرات الحرارية
                            </label>
                            <input type="number" id="calories" name="calories" value="{{ old('calories', $product->calories) }}" min="0" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('calories') border-red-500 @enderror" placeholder="0">
                            @error('calories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Current Image -->
                        @if($product->image)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                الصورة الحالية
                            </label>
                            <div class="mb-4">
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded-lg shadow-sm">
                            </div>
                        </div>
                        @endif

                        <!-- Image Upload -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $product->image ? 'تغيير الصورة' : 'صورة المنتج' }}
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>ارفع صورة</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pr-1">أو اسحب وأفلت</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Options -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">خيارات المنتج</h3>

                            <!-- Available -->
                            <div class="flex items-center">
                                <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_available" class="mr-2 block text-sm text-gray-900">
                                    متوفر للطلب
                                </label>
                            </div>

                            <!-- Featured -->
                            <div class="flex items-center">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_featured" class="mr-2 block text-sm text-gray-900">
                                    منتج مميز
                                </label>
                            </div>
                        </div>

                        <!-- Preparation Time -->
                        <div>
                            <label for="preparation_time" class="block text-sm font-medium text-gray-700 mb-2">
                                وقت التحضير (دقيقة)
                            </label>
                            <input type="number" id="preparation_time" name="preparation_time" value="{{ old('preparation_time', $product->preparation_time ?? 15) }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('preparation_time') border-red-500 @enderror" placeholder="15">
                            @error('preparation_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Date Fields for Weekly Products -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6" id="dateFields" style="display: {{ old('type', $product->type) == 'weekly' ? 'grid' : 'none' }}">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            تاريخ البداية
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $product->start_date) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            تاريخ النهاية
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $product->end_date) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 space-x-reverse pt-6 border-t border-gray-200 mt-8">
                    <a href="{{ route('admin.products.show', $product) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                        إلغاء
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show/hide date fields based on product type
        document.getElementById('type').addEventListener('change', function() {
            const dateFields = document.getElementById('dateFields');
            if (this.value === 'weekly') {
                dateFields.style.display = 'grid';
            } else {
                dateFields.style.display = 'none';
            }
        });

    </script>
</x-admin-layout>
