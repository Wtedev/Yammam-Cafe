@props(['placeholder' => 'بحث...', 'action' => '', 'name' => 'search', 'value' => ''])

<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <form method="GET" action="{{ $action }}">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="block w-full pr-10 pl-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors text-sm flex items-center">
                            <i class="fas fa-search ml-2"></i>
                            بحث
                        </button>

                        @if($value)
                        <a href="{{ $action }}" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2.5 rounded-lg font-medium transition-colors text-sm flex items-center">
                            <i class="fas fa-times ml-2"></i>
                            مسح
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
