<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="flex justify-around items-center py-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') ?? '/admin' }}" class="flex flex-col items-center py-2 px-3 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-amber-600' : 'text-gray-600 hover:text-amber-600' }}">
            <i class="fas fa-home text-xl mb-1"></i>
            <span class="text-xs font-medium">الرئيسية</span>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center py-2 px-3 transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'text-amber-600' : 'text-gray-600 hover:text-amber-600' }}">
            <i class="fas fa-boxes text-xl mb-1"></i>
            <span class="text-xs font-medium">المنتجات</span>
        </a>

        <!-- Orders -->
        <a href="{{ route('admin.orders') }}" class="flex flex-col items-center py-2 px-3 transition-all duration-200 {{ request()->routeIs('admin.orders') ? 'text-amber-600' : 'text-gray-600 hover:text-amber-600' }}">
            <i class="fas fa-shopping-cart text-xl mb-1"></i>
            <span class="text-xs font-medium">الطلبات</span>
        </a>


        <!-- Suggestions -->
        <a href="{{ route('admin.suggestions.index') ?? '/admin/suggestions' }}" class="flex flex-col items-center py-2 px-3 transition-all duration-200 relative {{ request()->routeIs('admin.suggestions.*') ? 'text-amber-600' : 'text-gray-600 hover:text-amber-600' }}">
            <div class="relative">
                <i class="fas fa-lightbulb text-xl mb-1"></i>
                <!-- Suggestions Badge -->
                <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                    3
                </span>
            </div>
            <span class="text-xs font-medium">الاقتراحات</span>
        </a>

        <!-- الملف الشخصي -->
        <a href="{{ route('admin.profile') }}" class="flex flex-col items-center py-2 px-3 transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'text-amber-600' : 'text-gray-600 hover:text-amber-600' }}">
            <i class="fas fa-user-cog text-xl mb-1"></i>
            <span class="text-xs font-medium">الملف الشخصي</span>
        </a>
    </div>
</nav>
