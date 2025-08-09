<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="max-w-lg mx-auto">
        <div class="flex justify-around items-center py-2">
            <!-- Home -->
            <a href="{{ route('home') ?? '/' }}" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-amber-600 transition-all duration-200 {{ request()->routeIs('home') ? 'text-amber-600' : '' }}">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-xs font-medium">الرئيسية</span>
            </a>

            <!-- Full Menu -->
            <a href="{{ route('menu.index') ?? '/menu' }}" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-amber-600 transition-all duration-200 {{ request()->routeIs('menu.*') ? 'text-amber-600' : '' }}">
                <i class="fas fa-utensils text-xl mb-1"></i>
                <span class="text-xs font-medium">المنيو</span>
            </a>

            <!-- Suggestions -->
            <a href="{{ route('suggestions.index') ?? '/suggestions' }}" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-amber-600 transition-all duration-200 {{ request()->routeIs('suggestions.*') ? 'text-amber-600' : '' }}">
                <i class="fas fa-lightbulb text-xl mb-1"></i>
                <span class="text-xs font-medium">الاقتراحات</span>
            </a>

            <!-- Profile / Login -->
            @auth
            <a href="{{ route('profile.show') ?? '/profile' }}" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-amber-600 transition-all duration-200 {{ request()->routeIs('profile.*') ? 'text-amber-600' : '' }}">
                <i class="fas fa-user text-xl mb-1"></i>
                <span class="text-xs font-medium">الملف الشخصي</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="flex flex-col items-center py-2 px-3 text-gray-600 hover:text-amber-600 transition-all duration-200 {{ request()->routeIs('login') || request()->routeIs('register') ? 'text-amber-600' : '' }}">
                <i class="fas fa-sign-in-alt text-xl mb-1"></i>
                <span class="text-xs font-medium">تسجيل الدخول</span>
            </a>
            @endauth
        </div>
    </div>
</nav>
