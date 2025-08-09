@props(['title'])

<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-lg mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <!-- Page Title -->
            <h1 class="text-xl font-bold text-gray-800">{{ $title }}</h1>

            <!-- User Actions -->
            <div class="flex items-center space-x-4 space-x-reverse">
                @auth
                <!-- Shopping Cart Icon -->
                <a href="{{ route('cart.index') ?? '#' }}" class="relative p-2 text-gray-600 hover:text-amber-600 transition-colors duration-200">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <!-- Cart Badge (if items exist) -->
                    <span class="cart-count absolute -top-1 -right-1 bg-amber-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">
                        0
                    </span>
                </a>
                @else
                <!-- Login Link -->
                <a href="{{ route('login') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors duration-200 px-3 py-1 rounded-full bg-amber-50 hover:bg-amber-100">
                    سجل دخولك
                </a>
                @endauth
            </div>
        </div>
    </div>
</header>
