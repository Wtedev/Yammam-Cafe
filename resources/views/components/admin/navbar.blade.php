@props(['activeRoute' => ''])

<!-- Admin Navigation Bar -->
<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side - Navigation Links -->
            <div class="flex items-center space-x-8 space-x-reverse">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors {{ str_starts_with($activeRoute, 'admin.dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-home ml-2"></i>
                    الرئيسية
                </a>
                
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors {{ str_starts_with($activeRoute, 'admin.products') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-boxes ml-2"></i>
                    المنتجات
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors {{ str_starts_with($activeRoute, 'admin.categories') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-tags ml-2"></i>
                    التصنيفات
                </a>
                
                <a href="{{ route('admin.orders') }}" 
                   class="inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors {{ str_starts_with($activeRoute, 'admin.orders') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-shopping-cart ml-2"></i>
                    الطلبات
                </a>
            </div>

            <!-- Right side - User menu -->
            <div class="flex items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <span class="text-sm text-gray-700">{{ auth()->user()->name ?? 'المدير' }}</span>
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 font-medium text-xs">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
