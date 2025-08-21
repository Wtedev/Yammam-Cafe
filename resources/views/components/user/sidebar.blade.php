<aside class="hidden lg:flex lg:flex-col lg:fixed lg:right-0 lg:top-0 lg:h-screen lg:w-64 bg-white border-l border-gray-200 shadow-lg z-40">
    <!-- Logo/Brand -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3 space-x-reverse">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-coffee text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">يمام كافيه</h2>
                <p class="text-sm text-gray-500">مرحباً بك</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 p-4 space-y-2">
        <!-- Home -->
        <a href="{{ route('home') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-home text-lg w-5"></i>
            <span class="font-medium">الرئيسية</span>
        </a>

        <!-- Menu -->
        <a href="{{ route('menu.index') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('menu.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-utensils text-lg w-5"></i>
            <span class="font-medium">المنيو</span>
        </a>

    <!-- My Orders -->
    @auth
    <a href="{{ route('my-orders') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('my-orders') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-shopping-bag text-lg w-5"></i>
            <span class="font-medium">طلباتي</span>
        </a>
    @endauth

    <!-- My Suggestions -->
    @auth
    <a href="{{ route('my-suggestions') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('my-suggestions') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-lightbulb text-lg w-5"></i>
            <span class="font-medium">اقتراحاتي</span>
        </a>
    @endauth

        <!-- Profile / Login -->
        @auth
        <a href="{{ route('user.profile') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('user.profile*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-user text-lg w-5"></i>
            <span class="font-medium">ملفي الشخصي</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 text-gray-700 hover:bg-gray-50">
            <span class="font-medium">تسجيل الدخول</span>
        </a>
        @endauth
    </nav>

    <!-- User Info at Bottom -->
    @auth
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3 space-x-reverse">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <span class="text-gray-600 font-medium text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">مستخدم</p>
            </div>
        </div>
    </div>
    @endauth
</aside>
