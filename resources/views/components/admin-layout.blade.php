@props(['title' => 'لوحة الإدارة'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'يمام كافيه') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <div x-bind:class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" class="fixed top-0 left-0 h-full w-64 bg-amber-900 text-white transform transition-transform duration-200 ease-in-out md:translate-x-0 z-30">
            <div class="p-4 border-b border-amber-800">
                <div class="flex items-center justify-between">
                    <a href="{{ url('/admin') }}" class="text-xl font-bold">
                        <img src="{{ asset('images/logo-white.png') }}" alt="يمام كافيه" class="h-8">
                    </a>
                    <button @click="sidebarOpen = false" class="md:hidden text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <nav class="py-4">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ url('/admin') }}" class="flex items-center px-4 py-3 hover:bg-amber-800 {{ request()->is('admin') ? 'bg-amber-800' : '' }}">
                            <i class="fas fa-chart-pie w-5 text-center"></i>
                            <span class="mr-3">لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.orders.*') ? 'bg-amber-800' : '' }}">
                            <i class="fas fa-shopping-bag w-5 text-center"></i>
                            <span class="mr-3">الطلبات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.products.*') ? 'bg-amber-800' : '' }}">
                            <i class="fas fa-mug-hot w-5 text-center"></i>
                            <span class="mr-3">المنتجات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.users.*') ? 'bg-amber-800' : '' }}">
                            <i class="fas fa-users w-5 text-center"></i>
                            <span class="mr-3">المستخدمين</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.suggestions.index') }}" class="flex items-center px-4 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.suggestions.*') ? 'bg-amber-800' : '' }}">
                            <i class="fas fa-lightbulb w-5 text-center"></i>
                            <span class="mr-3">الاقتراحات</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:mr-64">
            <!-- Top Navigation -->
            <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
                <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-700 ml-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-lg font-bold text-gray-800">{{ $title }}</h1>
                    </div>

                    <div class="flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 focus:outline-none">
                                <img src="{{ asset('images/avatar.png') }}" alt="User" class="h-8 w-8 rounded-full border-2 border-amber-500">
                                <span class="mr-2 hidden sm:block">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down mr-1 text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle ml-1"></i>
                                    الملف الشخصي
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1 pt-1">
                                    @csrf
                                    <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt ml-1"></i>
                                        تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="container mx-auto px-4 py-6">
                @if (session('success'))
                <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="mr-3">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="mr-3">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
