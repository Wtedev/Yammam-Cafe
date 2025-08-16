@props(['title' => 'يمام كافيه'])

<!-- Header -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Title -->
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-900">{{ $title }}</h1>
            </div>

            <!-- User Actions -->
            <div class="flex items-center space-x-4 space-x-reverse">
                <!-- Shopping Cart -->
                <a href="/cart" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <!-- Cart Badge -->
                    <span class="cart-badge absolute -top-0.5 -right-0.5 h-4 w-4 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center">
                        {{ array_sum(session('cart', [])) }}
                    </span>
                </a>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 space-x-reverse text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 font-medium text-sm">
                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                            </span>
                        </div>
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-medium text-gray-900">
                                {{ auth()->user()->name ?? 'المستخدم' }}
                            </p>
                            <p class="text-xs text-gray-500">مستخدم</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

                        <div class="py-1">
                            <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user ml-3 text-gray-400"></i>
                                ملفي الشخصي
                            </a>

                            <a href="{{ route('my-orders') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-shopping-bag ml-3 text-gray-400"></i>
                                طلباتي
                            </a>

                            <a href="{{ route('my-suggestions') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-lightbulb ml-3 text-gray-400"></i>
                                اقتراحاتي
                            </a>

                            <hr class="my-1">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt ml-3 text-red-400"></i>
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
