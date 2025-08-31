<x-layout.admin-layout title="إعدادات البنك">
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
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <span class="font-medium">يوجد أخطاء في البيانات المدخلة:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-university text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">إعدادات البنك للتحويلات</h1>
                        <p class="text-gray-600">إدارة معلومات البنك المستخدمة لاستقبال التحويلات من العملاء</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Settings Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">معلومات الحساب البنكي</h2>
                <p class="text-gray-600 text-sm">هذه المعلومات ستظهر للعملاء في صفحة الدفع والطلبات</p>
            </div>

            <form action="{{ route('admin.bank-settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bank Name -->
                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                            اسم البنك <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-university text-gray-400"></i>
                            </div>
                            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankSettings->bank_name) }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('bank_name') border-red-500 @enderror" placeholder="أدخل اسم البنك">
                        </div>
                        @error('bank_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Holder -->
                    <div>
                        <label for="account_holder" class="block text-sm font-medium text-gray-700 mb-2">
                            اسم صاحب الحساب <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-user-tie text-gray-400"></i>
                            </div>
                            <input type="text" id="account_holder" name="account_holder" value="{{ old('account_holder', $bankSettings->account_holder) }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('account_holder') border-red-500 @enderror" placeholder="أدخل اسم صاحب الحساب">
                        </div>
                        @error('account_holder')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Number -->
                    <div>
                        <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">
                            رقم الحساب <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-credit-card text-gray-400"></i>
                            </div>
                            <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $bankSettings->account_number) }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('account_number') border-red-500 @enderror" placeholder="أدخل رقم الحساب" dir="ltr">
                        </div>
                        @error('account_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- IBAN -->
                    <div>
                        <label for="iban" class="block text-sm font-medium text-gray-700 mb-2">
                            رقم الآيبان (IBAN) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-barcode text-gray-400"></i>
                            </div>
                            <input type="text" id="iban" name="iban" value="{{ old('iban', $bankSettings->iban) }}" required class="block w-full pr-10 pl-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('iban') border-red-500 @enderror" placeholder="أدخل رقم الآيبان" dir="ltr">
                        </div>
                        @error('iban')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-eye text-blue-600"></i>
                        معاينة البيانات في صفحة الدفع
                    </h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-sm font-medium text-gray-600">اسم البنك:</span>
                                <span class="text-sm text-gray-900" id="preview-bank-name">{{ $bankSettings->bank_name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-sm font-medium text-gray-600">اسم صاحب الحساب:</span>
                                <span class="text-sm text-gray-900" id="preview-account-holder">{{ $bankSettings->account_holder }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-sm font-medium text-gray-600">رقم الحساب:</span>
                                <span class="text-sm text-gray-900 font-mono" id="preview-account-number">{{ $bankSettings->account_number }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">رقم الآيبان:</span>
                                <span class="text-sm text-gray-900 font-mono font-bold" id="preview-iban">{{ $bankSettings->iban }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg shadow-sm border border-gray-200 transition-colors duration-200">
                        <i class="fas fa-arrow-right"></i>
                        <span>العودة للوحة التحكم</span>
                    </a>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg shadow-sm transition-colors duration-200">
                        <i class="fas fa-save"></i>
                        <span>حفظ إعدادات البنك</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Live Preview -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = {
                'bank_name': 'preview-bank-name',
                'account_holder': 'preview-account-holder',
                'account_number': 'preview-account-number',
                'iban': 'preview-iban'
            };

            Object.keys(inputs).forEach(inputId => {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(inputs[inputId]);
                
                if (input && preview) {
                    input.addEventListener('input', function() {
                        preview.textContent = this.value || 'غير محدد';
                    });
                }
            });
        });
    </script>
</x-layout.admin-layout>
