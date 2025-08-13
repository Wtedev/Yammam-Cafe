<!-- Simple Mobile Navigation (Top Only) -->
<nav class="lg:hidden bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50 relative" x-data="{ isMenuOpen: false }">
    <div class="px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-coffee text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">يمام كافيه</h2>
                    <p class="text-xs text-gray-500 hidden sm:block">لوحة الإدارة</p>
                </div>
            </div>

            <!-- Navigation Links (Hidden on small screens) -->
            <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900' }}">
                    <i class="fas fa-home ml-1"></i>
                    الرئيسية
                </a>
                <a href="{{ route('admin.products.index') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('admin.products.*') ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900' }}">
                    <i class="fas fa-boxes ml-1"></i>
                    المنتجات
                </a>
                <a href="{{ route('admin.orders') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('admin.orders') ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900' }}">
                    <i class="fas fa-shopping-cart ml-1"></i>
                    الطلبات
                </a>
                <a href="{{ route('admin.suggestions.index') ?? '/admin/suggestions' }}" class="text-sm font-medium transition-colors {{ request()->routeIs('admin.suggestions.*') ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900' }}">
                    <i class="fas fa-lightbulb ml-1"></i>
                    الاقتراحات
                </a>
                <a href="{{ route('admin.profile') }}" class="text-sm font-medium transition-colors {{ request()->routeIs('admin.profile') ? 'text-blue-600' : 'text-gray-700 hover:text-gray-900' }}">
                    <i class="fas fa-user-cog ml-1"></i>
                    الملف الشخصي
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="isMenuOpen = !isMenuOpen" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                <i class="fas fa-bars text-lg" x-show="!isMenuOpen"></i>
                <i class="fas fa-times text-lg" x-show="isMenuOpen"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="isMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="md:hidden absolute top-full left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-50 p-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}" @click="isMenuOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-home w-5"></i>
                <span>الصفحة الرئيسية</span>
            </a>

            <a href="{{ route('admin.products.index') }}" @click="isMenuOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-boxes w-5"></i>
                <span>إدارة المنتجات</span>
            </a>

            <a href="{{ route('admin.orders') }}" @click="isMenuOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-colors {{ request()->routeIs('admin.orders') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-shopping-cart w-5"></i>
                <span>إدارة الطلبات</span>
            </a>

            <a href="{{ route('admin.suggestions.index') ?? '/admin/suggestions' }}" @click="isMenuOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-colors {{ request()->routeIs('admin.suggestions.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-lightbulb w-5"></i>
                <span>الاقتراحات</span>
            </a>

            <a href="{{ route('admin.profile') }}" @click="isMenuOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-colors {{ request()->routeIs('admin.profile') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-user-cog w-5"></i>
                <span>الملف الشخصي</span>
            </a>

            <!-- User Info & Logout -->
            <div class="pt-3 border-t border-gray-200">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 font-medium text-xs">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ auth()->user()->name ?? 'المدير' }}
                            </p>
                            <p class="text-xs text-gray-500">مدير النظام</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
