<!-- Bottom Navigation (Mobile) -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="flex justify-around items-center h-16 px-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="font-medium">الرئيسية</span>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('admin.products.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-boxes text-lg mb-1"></i>
            <span class="font-medium">المنتجات</span>
        </a>

        <!-- Orders -->
        <a href="{{ route('admin.orders') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('admin.orders') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-shopping-cart text-lg mb-1"></i>
            <span class="font-medium">الطلبات</span>
        </a>

        <!-- Suggestions -->
        <a href="{{ route('admin.suggestions.index') ?? '/admin/suggestions' }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('admin.suggestions.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-lightbulb text-lg mb-1"></i>
            <span class="font-medium">اقتراحات</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('admin.profile') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('admin.profile') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-user-cog text-lg mb-1"></i>
            <span class="font-medium">الملف</span>
        </a>
    </div>
</nav>
