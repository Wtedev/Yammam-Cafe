@props(['page' => '', 'placeholder' => 'بحث...', 'action' => '', 'value' => ''])

@php
// تحديد المسار والمعاملات حسب الصفحة
$searchConfig = [
'products' => [
'action' => route('admin.products.index'),
'placeholder' => 'بحث في المنتجات...',
'fields' => [
['name' => 'search', 'placeholder' => 'اسم المنتج أو الوصف', 'type' => 'text'],
['name' => 'category', 'placeholder' => 'الفئة', 'type' => 'select', 'options' => 'categories'],
['name' => 'type', 'placeholder' => 'النوع', 'type' => 'select', 'options' => [
'coffee' => 'قهوة',
'tea' => 'شاي',
'cold_drink' => 'مشروب بارد',
'dessert' => 'حلوى',
'pastry' => 'معجنات'
]],
['name' => 'status', 'placeholder' => 'الحالة', 'type' => 'select', 'options' => [
'1' => 'متاح',
'0' => 'غير متاح'
]]
]
],
'orders' => [
'action' => route('admin.orders'),
'placeholder' => 'بحث في الطلبات...',
'fields' => [
['name' => 'search', 'placeholder' => 'رقم الطلب أو اسم العميل', 'type' => 'text'],
['name' => 'status', 'placeholder' => 'حالة الطلب', 'type' => 'select', 'options' => [
'pending' => 'في الانتظار',
'processed' => 'قيد المعالجة',
'delivered' => 'تم التسليم',
'cancelled' => 'ملغي'
]],
['name' => 'date_from', 'placeholder' => 'من تاريخ', 'type' => 'date'],
['name' => 'date_to', 'placeholder' => 'إلى تاريخ', 'type' => 'date']
]
],
'users' => [
'action' => route('admin.users.index'),
'placeholder' => 'بحث في المستخدمين...',
'fields' => [
['name' => 'search', 'placeholder' => 'الاسم أو رقم الجوال', 'type' => 'text'],
['name' => 'role', 'placeholder' => 'الدور', 'type' => 'select', 'options' => [
'admin' => 'مدير',
'user' => 'مستخدم'
]],
['name' => 'office_number', 'placeholder' => 'رقم المكتب', 'type' => 'text']
]
],
'suggestions' => [
'action' => route('admin.suggestions.index'),
'placeholder' => 'بحث في الاقتراحات...',
'fields' => [
['name' => 'search', 'placeholder' => 'البحث في المحتوى', 'type' => 'text'],
['name' => 'type', 'placeholder' => 'النوع', 'type' => 'select', 'options' => [
'suggestion' => 'اقتراح',
'complaint' => 'شكوى',
'compliment' => 'إعجاب'
]],
['name' => 'status', 'placeholder' => 'الحالة', 'type' => 'select', 'options' => [
'new' => 'جديد',
'viewed' => 'تمت المشاهدة'
]]
]
]
];

$config = $searchConfig[$page] ?? null;
@endphp

@if($config)
<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <!-- Search Form -->
            <form method="GET" action="{{ $config['action'] }}" x-data="{ showAdvanced: false }" class="space-y-4">
                <!-- Basic Search -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="{{ $config['fields'][0]['name'] }}" value="{{ request($config['fields'][0]['name']) }}" placeholder="{{ $config['fields'][0]['placeholder'] }}" class="block w-full pr-10 pl-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors text-sm flex items-center">
                            <i class="fas fa-search ml-2"></i>
                            بحث
                        </button>

                        @if(count($config['fields']) > 1)
                        <button type="button" @click="showAdvanced = !showAdvanced" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-medium transition-colors text-sm flex items-center">
                            <i class="fas fa-filter ml-2"></i>
                            متقدم
                            <i class="fas fa-chevron-down ml-1 transition-transform" :class="{ 'rotate-180': showAdvanced }"></i>
                        </button>
                        @endif

                        @if(request()->hasAny(array_column($config['fields'], 'name')))
                        <a href="{{ $config['action'] }}" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2.5 rounded-lg font-medium transition-colors text-sm flex items-center">
                            <i class="fas fa-times ml-2"></i>
                            مسح
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Advanced Filters -->
                @if(count($config['fields']) > 1)
                <div x-show="showAdvanced" x-transition class="border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach(array_slice($config['fields'], 1) as $field)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $field['placeholder'] }}</label>

                            @if($field['type'] === 'select')
                            <select name="{{ $field['name'] }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">الكل</option>
                                @if($field['options'] === 'categories')
                                @php
                                $categories = \App\Models\Category::all();
                                @endphp
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request($field['name']) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                                @else
                                @foreach($field['options'] as $value => $label)
                                <option value="{{ $value }}" {{ request($field['name']) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @elseif($field['type'] === 'date')
                            <input type="date" name="{{ $field['name'] }}" value="{{ request($field['name']) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @else
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="{{ request($field['name']) }}" placeholder="{{ $field['placeholder'] }}" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Active Filters Display -->
                @if(request()->hasAny(array_column($config['fields'], 'name')))
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm text-gray-600">الفلاتر النشطة:</span>
                    @foreach($config['fields'] as $field)
                    @if(request($field['name']))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $field['placeholder'] }}:
                        @if($field['type'] === 'select' && isset($field['options']) && is_array($field['options']))
                        {{ $field['options'][request($field['name'])] ?? request($field['name']) }}
                        @elseif($field['options'] === 'categories')
                        @php
                        $category = \App\Models\Category::find(request($field['name']));
                        @endphp
                        {{ $category->name ?? request($field['name']) }}
                        @else
                        {{ request($field['name']) }}
                        @endif
                        <a href="{{ request()->fullUrlWithQuery([$field['name'] => null]) }}" class="mr-1 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    @endforeach
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endif
