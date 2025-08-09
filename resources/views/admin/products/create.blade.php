<x-admin-layout title="إضافة منتج جديد">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">إضافة منتج جديد</h1>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة للقائمة
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Type Selection -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">اختر نوع المنتج</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fixed Product -->
                        <label for="type_fixed" class="cursor-pointer">
                            <input type="radio" id="type_fixed" name="type" value="fixed" {{ old('type') == 'fixed' ? 'checked' : '' }} class="sr-only product-type-radio" required>
                            <div class="border-2 border-gray-200 rounded-xl p-8 text-center transition-all duration-200 hover:border-blue-300 hover:shadow-md product-type-card">
                                <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-coffee text-blue-600 text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">منتج ثابت</h4>
                                <p class="text-gray-600 text-sm">منتج متاح بشكل دائم في القائمة</p>
                            </div>
                        </label>

                        <!-- Weekly Product -->
                        <label for="type_weekly" class="cursor-pointer">
                            <input type="radio" id="type_weekly" name="type" value="weekly" {{ old('type') == 'weekly' ? 'checked' : '' }} class="sr-only product-type-radio" required>
                            <div class="border-2 border-gray-200 rounded-xl p-8 text-center transition-all duration-200 hover:border-green-300 hover:shadow-md product-type-card">
                                <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-week text-green-600 text-2xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">منتج أسبوعي</h4>
                                <p class="text-gray-600 text-sm">منتج متاح لفترة محددة من الوقت</p>
                            </div>
                        </label>
                    </div>
                    @error('type')
                    <p class="mt-3 text-sm text-red-600 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-8">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="px-4 text-sm text-gray-500 bg-white">معلومات المنتج الأساسية</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <!-- Product Basic Info -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Image Upload -->
                    <div class="lg:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            صورة المنتج
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                            <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <label for="image" class="cursor-pointer">
                                <div id="image-preview" class="hidden">
                                    <img id="preview-img" src="" alt="Preview" class="max-w-xs mx-auto rounded-lg mb-4">
                                </div>
                                <div id="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-600">اضغط لرفع صورة المنتج</p>
                                    <p class="text-sm text-gray-400 mt-2">PNG, JPG, GIF حتى 2MB</p>
                                </div>
                            </label>
                        </div>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            اسم المنتج <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="أدخل اسم المنتج">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            التصنيف <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                            <option value="">اختر التصنيف</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            وصف المنتج
                        </label>
                        <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="أدخل وصف المنتج">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-8">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="px-4 text-sm text-gray-500 bg-white">التسعير والمعلومات الغذائية</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <!-- Pricing & Nutrition -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            السعر <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror" placeholder="أدخل السعر">
                        @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Calories -->
                    <div>
                        <label for="calories" class="block text-sm font-medium text-gray-700 mb-2">
                            السعرات الحرارية
                        </label>
                        <input type="number" id="calories" name="calories" value="{{ old('calories') }}" min="0" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('calories') border-red-500 @enderror" placeholder="أدخل السعرات">
                        @error('calories')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preparation Time -->
                    <div>
                        <label for="preparation_time" class="block text-sm font-medium text-gray-700 mb-2">
                            وقت التحضير
                        </label>
                        <input type="number" id="preparation_time" name="preparation_time" value="{{ old('preparation_time', 15) }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('preparation_time') border-red-500 @enderror" placeholder="بالدقائق">
                        @error('preparation_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Weekly Product Dates -->
                <div id="weekly-dates" class="hidden">
                    <!-- Divider -->
                    <div class="flex items-center mb-6">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="px-4 text-sm text-gray-500 bg-white">فترة عرض المنتج الأسبوعي</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                تاريخ البداية
                            </label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                تاريخ النهاية
                            </label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Product Options -->
                <div class="border-t border-gray-200 pt-6 mb-8">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">خيارات المنتج</h4>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_available" class="ml-3 text-sm text-gray-700">
                                متاح للبيع
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-3 text-sm text-gray-700">
                                منتج مميز
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 space-x-reverse pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        إلغاء
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors duration-200">
                        <i class="fas fa-save ml-2"></i>
                        إضافة المنتج
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Product type selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('.product-type-radio');
            const typeCards = document.querySelectorAll('.product-type-card');
            const weeklyDates = document.getElementById('weekly-dates');

            // Update card styles based on selection
            function updateTypeSelection() {
                typeRadios.forEach((radio, index) => {
                    const card = typeCards[index];
                    if (radio.checked) {
                        if (radio.value === 'fixed') {
                            card.classList.remove('border-gray-200');
                            card.classList.add('border-blue-500', 'bg-blue-50', 'shadow-md');
                        } else if (radio.value === 'weekly') {
                            card.classList.remove('border-gray-200');
                            card.classList.add('border-green-500', 'bg-green-50', 'shadow-md');
                        }

                        // Show/hide weekly dates
                        if (radio.value === 'weekly') {
                            weeklyDates.classList.remove('hidden');
                        } else {
                            weeklyDates.classList.add('hidden');
                        }
                    } else {
                        card.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'shadow-md');
                        card.classList.add('border-gray-200');
                    }
                });
            }

            // Add event listeners
            typeRadios.forEach(radio => {
                radio.addEventListener('change', updateTypeSelection);
            });

            // Initialize on page load
            updateTypeSelection();
        });

        // Image preview functionality
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

    <style>
        .product-type-card {
            transition: all 0.2s ease-in-out;
        }

        .product-type-card:hover {
            transform: translateY(-2px);
        }

    </style>
</x-admin-layout>
