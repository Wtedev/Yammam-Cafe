<x-layout.admin-layout title="إضافة منتج جديد">
    <div class="max-w-3xl mx-auto px-2 sm:px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">إضافة منتج جديد</h1>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg shadow-sm border border-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right"></i>
                <span class="hidden sm:inline">العودة للقائمة</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-8">
            <!-- Stepper -->
            <div class="flex items-center justify-center mb-8">
                <div class="flex items-center gap-2">
                    <div id="step-indicator-1" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-blue-500 bg-blue-500 text-white font-bold">1</div>
                    <div class="w-8 h-1 bg-blue-100"></div>
                    <div id="step-indicator-2" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-blue-100 bg-white text-blue-500 font-bold">2</div>
                    <div class="w-8 h-1 bg-blue-100"></div>
                    <div id="step-indicator-3" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-blue-100 bg-white text-blue-500 font-bold">3</div>
                    <div class="w-8 h-1 bg-blue-100"></div>
                    <div id="step-indicator-4" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-blue-100 bg-white text-blue-500 font-bold">4</div>
                    <div class="w-8 h-1 bg-blue-100"></div>
                    <div id="step-indicator-5" class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-blue-100 bg-white text-blue-500 font-bold">5</div>
                </div>
            </div>
            <form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <!-- Step 1: Product Type Selection -->
                <div class="step" id="step-1">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 text-center">اختر نوع المنتج</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Fixed Product -->
                        <label for="type_fixed" class="cursor-pointer">
                            <input type="radio" id="type_fixed" name="type" value="fixed" {{ old('type') == 'fixed' ? 'checked' : '' }} class="sr-only product-type-radio" required>
                            <div class="border-2 border-gray-200 rounded-xl p-6 text-center transition-all duration-200 hover:border-blue-300 hover:shadow-md product-type-card">
                                <div class="w-14 h-14 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-coffee text-blue-600 text-xl"></i>
                                </div>
                                <h4 class="text-base font-semibold text-gray-900 mb-1">منتج ثابت</h4>
                                <p class="text-gray-600 text-xs">منتج متاح بشكل دائم في القائمة</p>
                            </div>
                        </label>
                        <!-- Weekly Product -->
                        <label for="type_weekly" class="cursor-pointer">
                            <input type="radio" id="type_weekly" name="type" value="weekly" {{ old('type') == 'weekly' ? 'checked' : '' }} class="sr-only product-type-radio" required>
                            <div class="border-2 border-gray-200 rounded-xl p-6 text-center transition-all duration-200 hover:border-green-300 hover:shadow-md product-type-card">
                                <div class="w-14 h-14 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-week text-green-600 text-xl"></i>
                                </div>
                                <h4 class="text-base font-semibold text-gray-900 mb-1">منتج أسبوعي</h4>
                                <p class="text-gray-600 text-xs">منتج متاح لفترة محددة من الوقت</p>
                            </div>
                        </label>
                    </div>
                    @error('type')
                    <p class="mt-3 text-xs text-red-600 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Step 2: Weekly Dates (if weekly) -->
                <div class="step hidden" id="step-2">
                    <div id="weekly-dates-step" class="">
                        <div class="flex items-center mb-4">
                            <div class="flex-grow border-t border-gray-100"></div>
                            <span class="px-3 text-xs text-gray-400 bg-white">فترة عرض المنتج الأسبوعي</span>
                            <div class="flex-grow border-t border-gray-100"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ البداية</label>
                                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ النهاية</label>
                                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 3: Basic Info -->
                <div class="step hidden" id="step-3">
                    <div class="flex items-center mb-8">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span class="px-3 text-xs sm:text-sm text-gray-400 bg-white">معلومات المنتج الأساسية</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Image Upload -->
                        <div class="lg:col-span-2">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">صورة المنتج</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 sm:p-6 text-center hover:border-blue-300 transition-colors bg-blue-50/30">
                                <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                                <label for="image" class="cursor-pointer">
                                    <div id="image-preview" class="hidden">
                                        <img id="preview-img" src="" alt="Preview" class="max-w-xs mx-auto rounded-lg mb-4">
                                    </div>
                                    <div id="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-400 mb-2"></i>
                                        <p class="text-gray-600 text-sm">اضغط لرفع صورة المنتج</p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF حتى 10MB</p>
                                    </div>
                                </label>
                            </div>
                            @error('image')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">اسم المنتج <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="أدخل اسم المنتج">
                            @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Category -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">التصنيف <span class="text-red-500">*</span></label>
                                <a href="{{ route('admin.categories.create') }}" 
                                   target="_blank"
                                   class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                    <i class="fas fa-plus text-xs ml-1"></i>
                                    إضافة تصنيف جديد
                                </a>
                            </div>
                            <select id="category_id" name="category_id" required class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                <option value="">اختر التصنيف</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Description -->
                        <div class="lg:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">وصف المنتج</label>
                            <textarea id="description" name="description" rows="3" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="أدخل وصف المنتج">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Step 4: Pricing & Nutrition -->
                <div class="step hidden" id="step-4">
                    <div class="flex items-center mb-8">
                        <div class="flex-grow border-t border-gray-100"></div>
                        <span class="px-3 text-xs sm:text-sm text-gray-400 bg-white">التسعير والمعلومات الغذائية</span>
                        <div class="flex-grow border-t border-gray-100"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">السعر <span class="text-red-500">*</span></label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror" placeholder="أدخل السعر">
                            @error('price')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Stock Quantity -->
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">الكمية المتوفرة <span class="text-red-500">*</span></label>
                            <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('stock_quantity') border-red-500 @enderror" placeholder="الكمية">
                            @error('stock_quantity')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Calories -->
                        <div>
                            <label for="calories" class="block text-sm font-medium text-gray-700 mb-2">السعرات الحرارية</label>
                            <input type="number" id="calories" name="calories" value="{{ old('calories') }}" min="0" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('calories') border-red-500 @enderror" placeholder="أدخل السعرات">
                            @error('calories')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Preparation Time -->
                        <div>
                            <label for="preparation_time" class="block text-sm font-medium text-gray-700 mb-2">وقت التحضير</label>
                            <input type="number" id="preparation_time" name="preparation_time" value="{{ old('preparation_time', 15) }}" min="1" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 @error('preparation_time') border-red-500 @enderror" placeholder="بالدقائق">
                            @error('preparation_time')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Weekly Product Dates -->
                    <div id="weekly-dates" class="hidden">
                        <div class="flex items-center mb-4">
                            <div class="flex-grow border-t border-gray-100"></div>
                            <span class="px-3 text-xs text-gray-400 bg-white">فترة عرض المنتج الأسبوعي</span>
                            <div class="flex-grow border-t border-gray-100"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ البداية</label>
                                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ النهاية</label>
                                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 5: Product Options & Submit -->
                <div class="step hidden" id="step-5">
                    <div class="border-t border-gray-100 pt-6 mb-8">
                        <h4 class="text-base font-semibold text-gray-900 mb-3">خيارات المنتج</h4>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-200 rounded">
                                <label for="is_available" class="mr-2 text-sm text-gray-700">متاح للبيع</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-200 rounded">
                                <label for="is_featured" class="mr-2 text-sm text-gray-700">منتج مميز</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8 items-center flex-wrap gap-3">
                    <button type="button" id="prev-btn" class="hidden bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg shadow-sm border border-gray-200 transition-colors duration-200">السابق</button>
                    <div class="ml-auto flex items-center gap-3" id="nav-dynamic-area">
                        <button type="button" id="next-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-lg shadow-sm transition-colors duration-200">التالي</button>
                        <div id="final-actions" class="hidden items-center gap-3">
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg shadow-sm border border-gray-200 transition-colors duration-200">
                                <i class="fas fa-times"></i><span>إلغاء</span>
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-lg shadow-sm transition-colors duration-200">
                                <i class="fas fa-save"></i><span>إضافة المنتج</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Multi-step form logic
        document.addEventListener('DOMContentLoaded', function() {
            const steps = Array.from(document.querySelectorAll('.step'));
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            const finalActions = document.getElementById('final-actions');
            const stepIndicators = [
                document.getElementById('step-indicator-1')
                , document.getElementById('step-indicator-2')
                , document.getElementById('step-indicator-3')
                , document.getElementById('step-indicator-4')
                , document.getElementById('step-indicator-5')
            ];
            let currentStep = 0;

            // For conditional step 2 (weekly dates)
            function isWeekly() {
                const weeklyRadio = document.getElementById('type_weekly');
                return weeklyRadio && weeklyRadio.checked;
            }

            function showStep(idx) {
                // Hide all steps
                steps.forEach((step, i) => {
                    step.classList.add('hidden');
                });
                // Show only the relevant step
                if (idx === 1 && !isWeekly()) {
                    // Skip weekly dates step if not weekly
                    currentStep = 2;
                    showStep(currentStep);
                    return;
                }
                steps[idx].classList.remove('hidden');
                // Stepper UI
                stepIndicators.forEach((el, i) => {
                    if (i === idx) {
                        el.classList.add('border-blue-500', 'bg-blue-500', 'text-white');
                        el.classList.remove('border-blue-100', 'bg-white', 'text-blue-500');
                    } else {
                        el.classList.remove('border-blue-500', 'bg-blue-500', 'text-white');
                        el.classList.add('border-blue-100', 'bg-white', 'text-blue-500');
                    }
                });
                prevBtn.classList.toggle('hidden', idx === 0);
                const isLast = idx === steps.length - 1;
                if (isLast) {
                    nextBtn.classList.add('hidden');
                    finalActions.classList.remove('hidden');
                } else {
                    nextBtn.classList.remove('hidden');
                    finalActions.classList.add('hidden');
                }
            }

            nextBtn.addEventListener('click', function() {
                if (currentStep < steps.length - 1) {
                    // If moving to step 2 and not weekly, skip to step 3
                    if (currentStep === 0 && !isWeekly()) {
                        currentStep += 2;
                    } else {
                        currentStep++;
                    }
                    showStep(currentStep);
                }
            });
            prevBtn.addEventListener('click', function() {
                if (currentStep > 0) {
                    // If moving back from step 2 and not weekly, skip to step 0
                    if (currentStep === 2 && !isWeekly()) {
                        currentStep -= 2;
                    } else {
                        currentStep--;
                    }
                    showStep(currentStep);
                }
            });
            showStep(currentStep);

            // Product type selection functionality (for card highlight and weekly dates step)
            const typeRadios = document.querySelectorAll('.product-type-radio');
            const typeCards = document.querySelectorAll('.product-type-card');

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
                    } else {
                        card.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'shadow-md');
                        card.classList.add('border-gray-200');
                    }
                });
                // If user changes type, and is on step 2 but not weekly, skip to step 3
                if (currentStep === 1 && !isWeekly()) {
                    currentStep = 2;
                    showStep(currentStep);
                }
            }
            typeRadios.forEach(radio => {
                radio.addEventListener('change', updateTypeSelection);
            });
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
</x-layout.admin-layout>
