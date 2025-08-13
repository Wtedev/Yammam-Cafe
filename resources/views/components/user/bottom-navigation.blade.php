<!-- Bottom Navigation (Mobile) -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="flex justify-around items-center h-16 px-2">
        <!-- Home -->
        <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="font-medium">الرئيسية</span>
        </a>

        <!-- Menu -->
        <a href="{{ route('menu.index') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('menu.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-utensils text-lg mb-1"></i>
            <span class="font-medium">المنيو</span>
        </a>

        <!-- My Orders -->
        <a href="{{ route('my-orders') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('my-orders') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-shopping-bag text-lg mb-1"></i>
            <span class="font-medium">طلباتي</span>
        </a>

        <!-- My Suggestions -->
        <a href="{{ route('my-suggestions') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('my-suggestions') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-lightbulb text-lg mb-1"></i>
            <span class="font-medium">اقتراحاتي</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="flex-1 flex flex-col items-center justify-center py-2 text-xs transition-colors {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-user text-lg mb-1"></i>
            <span class="font-medium">ملفي</span>
        </a>
    </div>
</nav>
