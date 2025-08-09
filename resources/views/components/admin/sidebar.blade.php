<aside class="hidden lg:flex lg:flex-col lg:fixed lg:right-0 lg:top-0 lg:h-screen lg:w-64 bg-white border-l border-gray-200 shadow-lg z-50">
    <!-- Logo/Brand -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3 space-x-reverse">
            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-coffee text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">يمام كافيه</h2>
                <p class="text-sm text-gray-500">لوحة الإدارة</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 p-4 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-500' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-home text-lg w-5"></i>
            <span class="font-medium">الصفحة الرئيسية</span>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-500' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-boxes text-lg w-5"></i>
            <span class="font-medium">إدارة المنتجات</span>
        </a>

        <!-- Orders -->
        <a href="{{ route('admin.orders') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.orders') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-500' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-shopping-cart text-lg w-5"></i>
            <span class="font-medium">إدارة الطلبات</span>
        </a>


        <!-- Suggestions -->
        <a href="{{ route('admin.suggestions.index') ?? '/admin/suggestions' }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.suggestions.*') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-500' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-lightbulb text-lg w-5"></i>
            <span class="font-medium">الاقتراحات</span>
            <!-- New Suggestions Badge -->
            <span class="mr-auto bg-blue-500 text-white text-xs px-2 py-1 rounded-full">3</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('admin.profile') }}" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'bg-amber-50 text-amber-700 border-l-4 border-amber-500' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-user-cog text-lg w-5"></i>
            <span class="font-medium">الملف الشخصي</span>
        </a>
    </nav>

    <!-- User Info at Bottom -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3 space-x-reverse">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <span class="text-gray-600 font-medium text-sm">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">
                    {{ auth()->user()->name ?? 'المدير' }}
                </p>
                <p class="text-xs text-gray-500">مدير النظام</p>
            </div>
        </div>
    </div>
</aside>
