<!-- Mobile Navigation Bar -->
<nav class="lg:hidden fixed top-0 left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-50 relative" x-data="{ isOpen: false }">
    <div class="px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-coffee text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">يمام كافيه</h2>
                    <p class="text-xs text-gray-500">لوحة الإدارة</p>
                </div>
            </div>

            <!-- Menu Toggle Button -->
            <button @click="isOpen = !isOpen" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                <i class="fas fa-bars text-lg" x-show="!isOpen"></i>
                <i class="fas fa-times text-lg" x-show="isOpen"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="absolute top-full left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-50 p-4">

            <!-- Navigation Links -->
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" @click="isOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-home text-lg w-5"></i>
                    <span class="font-medium">الصفحة الرئيسية</span>
                </a>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" @click="isOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-boxes text-lg w-5"></i>
                    <span class="font-medium">إدارة المنتجات</span>
                </a>

                <!-- Orders -->
                <a href="{{ route('admin.orders') }}" @click="isOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.orders') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-shopping-cart text-lg w-5"></i>
                    <span class="font-medium">إدارة الطلبات</span>
                </a>

                <!-- Suggestions -->
                <a href="{{ route('admin.suggestions.index') ?? '/admin/suggestions' }}" @click="isOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.suggestions.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-lightbulb text-lg w-5"></i>
                    <span class="font-medium">الاقتراحات</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('admin.profile') }}" @click="isOpen = false" class="flex items-center space-x-3 space-x-reverse p-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-user-cog text-lg w-5"></i>
                    <span class="font-medium">الملف الشخصي</span>
                </a>
            </div>

            <!-- User Info -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center space-x-3 space-x-reverse p-3 bg-gray-50 rounded-lg">
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
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 p-1">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navigation Spacer -->
<div class="lg:hidden h-20"></div>
