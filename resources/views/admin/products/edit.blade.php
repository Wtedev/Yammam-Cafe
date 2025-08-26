<x-layout.admin-layout title="تعديل المنتج">
    <div class="max-w-4xl mx-auto py-8 px-2 md:px-6 font-[Cairo,Tajawal,Segoe UI,Arial,sans-serif]">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-blue-900 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-blue-400"></span>
                تعديل المنتج: {{ $product->name }}
            </h1>
            <div class="flex flex-row gap-2">
                <a href="{{ route('admin.products.show', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-eye"></i> عرض
                </a>
                <button type="submit" form="editProductForm" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-save"></i> حفظ التغييرات
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm flex items-center gap-1">
                    <i class="fas fa-arrow-right"></i> العودة للقائمة
                </a>
            </div>
        </div>

        <form id="editProductForm" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Product Image -->
                <div class="md:col-span-1">
                    <div class="bg-white/90 rounded-2xl shadow-sm border border-blue-50 p-4 flex flex-col items-center">
                        <h3 class="text-base font-bold text-blue-900 mb-3">صورة المنتج</h3>
                        <div id="imagePreviewContainer" class="relative w-full">
                            @if($product->image)
                            <img id="imagePreview" data-original-src="{{ Storage::url($product->image) }}" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover rounded-xl shadow-sm border border-blue-50 mb-2 transition-opacity duration-200">
                            @else
                            <div id="noImagePlaceholder" class="w-full h-56 bg-gray-100 rounded-xl flex items-center justify-center mb-2">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                            @endif
                        </div>
                        <div class="w-full mb-2">
                            <label for="image" class="block">
                                <div class="flex flex-col items-center justify-center border-2 border-dashed border-blue-200 rounded-xl bg-blue-50 hover:border-blue-400 transition-colors duration-200 cursor-pointer py-6 px-3">
                                    <svg class="mx-auto h-10 w-10 text-blue-300 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="text-blue-700 font-medium text-sm">اسحب الصورة هنا أو اضغط للرفع</span>
                                    <span class="text-xs text-blue-400 mt-1">PNG, JPG, GIF حتى 10MB</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only" />
                                </div>
                            </label>
                        </div>
                        @if($product->image)
                        <input type="hidden" id="remove_image" name="remove_image" value="{{ old('remove_image') ? 1 : 0 }}">
                        <div id="imageActionButtons" class="w-full flex flex-wrap items-center gap-2">
                            <button type="button" id="btnDeleteImage" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center justify-center gap-1 shadow-sm"><i class="fas fa-trash-alt"></i><span>حذف الصورة</span></button>
                            <button type="button" id="btnReplaceImage" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center justify-center gap-1 shadow-sm"><i class="fas fa-sync-alt"></i><span>استبدال</span></button>
                        </div>
                        <div id="imageDeletedNotice" class="hidden w-full mt-2 text-xs bg-red-50 border border-red-200 text-red-700 rounded-lg px-3 py-2 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>تم تحديد حذف الصورة. لن تُحذف فعلياً إلا عند الضغط على "حفظ التغييرات". يمكنك التراجع.</span>
                        </div>
                        <button type="button" id="btnUndoDelete" class="hidden mt-2 w-full bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold px-3 py-2 rounded-lg flex items-center justify-center gap-1"><i class="fas fa-undo"></i><span>تراجع عن الحذف</span></button>
                        @endif
                        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        @if(session('uploadError'))<p class="mt-2 text-xs text-red-600 font-semibold">❗ {{ session('uploadError') }}</p>@elseif(session('uploadWarning'))<p class="mt-2 text-xs text-amber-600 font-semibold">⚠ {{ session('uploadWarning') }}</p>@endif
                    </div>
                </div>

                <!-- Product Details -->
                <div class="md:col-span-2">
                    <div class="bg-white/90 rounded-2xl shadow-sm border border-blue-50 p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="name" class="text-xs text-blue-700 font-bold mb-1">اسم المنتج <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="أدخل اسم المنتج">
                                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <div class="flex items-center justify-between mb-1">
                                    <label for="category" class="text-xs text-blue-700 font-bold">الفئة <span class="text-red-500">*</span></label>
                                    <a href="{{ route('admin.categories.create') }}" 
                                       target="_blank"
                                       class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                        <i class="fas fa-plus text-xs ml-1"></i>
                                        إضافة تصنيف
                                    </a>
                                </div>
                                <select id="category" name="category" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                                    <option value="">اختر الفئة</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2 md:col-span-2">
                                <label for="description" class="text-xs text-blue-700 font-bold mb-1">الوصف <span class="text-red-500">*</span></label>
                                <textarea id="description" name="description" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="أدخل وصف المنتج">{{ old('description', $product->description) }}</textarea>
                                @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="price" class="text-xs text-blue-700 font-bold mb-1">السعر (ريال) <span class="text-red-500">*</span></label>
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror" placeholder="0.00">
                                @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="stock_quantity" class="text-xs text-blue-700 font-bold mb-1">الكمية المتوفرة <span class="text-red-500">*</span></label>
                                <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" min="0" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('stock_quantity') border-red-500 @enderror" placeholder="0">
                                @error('stock_quantity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="type" class="text-xs text-blue-700 font-bold mb-1">نوع المنتج</label>
                                <select id="type" name="type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                                    <option value="fixed" {{ old('type', $product->type) == 'fixed' ? 'selected' : '' }}>ثابت</option>
                                    <option value="weekly" {{ old('type', $product->type) == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                </select>
                                @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="calories" class="text-xs text-blue-700 font-bold mb-1">السعرات الحرارية</label>
                                <input type="number" id="calories" name="calories" value="{{ old('calories', $product->calories) }}" min="0" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('calories') border-red-500 @enderror" placeholder="0">
                                @error('calories')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="preparation_time" class="text-xs text-blue-700 font-bold mb-1">وقت التحضير (دقيقة)</label>
                                <input type="number" id="preparation_time" name="preparation_time" value="{{ old('preparation_time', $product->preparation_time ?? 15) }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('preparation_time') border-red-500 @enderror" placeholder="15">
                                @error('preparation_time')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap gap-4 mt-4">
                            <div class="flex items-center gap-2">
                                <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_available" class="text-xs text-blue-700 font-bold">متوفر للطلب</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-300 rounded">
                                <label for="is_featured" class="text-xs text-yellow-700 font-bold">منتج مميز</label>
                            </div>
                        </div>
                        <!-- Date Fields for Weekly Products -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" id="dateFields" style="display: {{ old('type', $product->type) == 'weekly' ? 'grid' : 'none' }}">
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="start_date" class="text-xs text-blue-700 font-bold mb-1">تاريخ البداية</label>
                                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $product->start_date) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                                @error('start_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-2">
                                <label for="end_date" class="text-xs text-blue-700 font-bold mb-1">تاريخ النهاية</label>
                                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $product->end_date) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                                @error('end_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const removeField = document.getElementById('remove_image');
            const img = document.getElementById('imagePreview');
            const btnDelete = document.getElementById('btnDeleteImage');
            const btnReplace = document.getElementById('btnReplaceImage');
            const btnUndo = document.getElementById('btnUndoDelete');
            const deletedNotice = document.getElementById('imageDeletedNotice');
            let originalSrc = img ? img.getAttribute('data-original-src') : null;

            function markDeleted() {
                if (removeField) {
                    removeField.value = 1;
                }
                if (img) {
                    img.style.display = 'none';
                }
                if (btnDelete) {
                    btnDelete.classList.add('hidden');
                }
                if (btnReplace) {
                    btnReplace.classList.add('hidden');
                }
                if (deletedNotice) {
                    deletedNotice.classList.remove('hidden');
                }
                if (btnUndo) {
                    btnUndo.classList.remove('hidden');
                }
                ensurePlaceholder();
            }

            function undoDelete() {
                if (removeField) {
                    removeField.value = 0;
                }
                if (img) {
                    img.style.display = 'block';
                    if (originalSrc) {
                        img.src = originalSrc;
                    }
                }
                if (btnDelete) {
                    btnDelete.classList.remove('hidden');
                }
                if (btnReplace) {
                    btnReplace.classList.remove('hidden');
                }
                if (deletedNotice) {
                    deletedNotice.classList.add('hidden');
                }
                if (btnUndo) {
                    btnUndo.classList.add('hidden');
                }
                removeTemporaryPlaceholder();
            }

            function ensurePlaceholder() {
                if (!document.getElementById('noImagePlaceholder')) {
                    const cont = document.getElementById('imagePreviewContainer');
                    const ph = document.createElement('div');
                    ph.id = 'noImagePlaceholder';
                    ph.className = 'w-full h-56 bg-gray-100 rounded-xl flex items-center justify-center mb-2 border border-dashed border-gray-300';
                    ph.innerHTML = '<i class="fas fa-image text-4xl text-gray-400"></i>';
                    cont.prepend(ph);
                }
            }

            function removeTemporaryPlaceholder() {
                const ph = document.getElementById('noImagePlaceholder');
                if (ph && originalSrc) {
                    ph.remove();
                }
            }
            if (btnDelete) {
                btnDelete.addEventListener('click', markDeleted);
            }
            if (btnUndo) {
                btnUndo.addEventListener('click', undoDelete);
            }
            if (btnReplace) {
                btnReplace.addEventListener('click', () => imageInput && imageInput.click());
            }
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files.length) {
                        // Selecting new image cancels deletion if marked
                        if (removeField && removeField.value === '1') {
                            undoDelete();
                        }
                    }
                });
            }
        });
        // Preview new image selection
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                let img = document.getElementById('imagePreview');
                const container = document.getElementById('imagePreviewContainer');
                if (!img) {
                    img = document.createElement('img');
                    img.id = 'imagePreview';
                    img.className = 'w-full h-56 object-cover rounded-xl shadow-sm border border-blue-50 mb-2';
                    container.prepend(img);
                }
                img.src = ev.target.result;
                img.style.display = 'block';
                const statusText = document.createElement('div');
                statusText.className = 'text-xs text-green-600 mt-1 font-semibold';
                statusText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>تم استبدال الصورة - الحفظ عند الضغط على "حفظ التغييرات"';
                const existing = container.querySelector('.text-green-600');
                if (existing) existing.remove();
                container.appendChild(statusText);
                const ph = document.getElementById('noImagePlaceholder');
                if (ph) ph.remove();
            };
            reader.readAsDataURL(file);
        });

    </script>
</x-layout.admin-layout>
