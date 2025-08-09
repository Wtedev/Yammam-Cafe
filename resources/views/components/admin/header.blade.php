@props(['title'])

<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
    <div class="px-4 lg:px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Page Title -->
            <h1 class="text-xl lg:text-2xl font-bold text-gray-800">{{ $title }}</h1>

            <!-- Admin Actions -->
            <div class="flex items-center space-x-4 space-x-reverse">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-amber-600 transition-colors duration-200 rounded-full hover:bg-gray-100">
                    <i class="fas fa-bell text-xl"></i>
                    <!-- Notification Badge -->
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        5
                    </span>
                </button>

                <!-- Admin Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 space-x-reverse text-gray-700 hover:text-gray-900 focus:outline-none">
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <span class="hidden lg:block font-medium">{{ auth()->user()->name ?? 'المدير' }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-50">
                        <a href="{{ route('admin.profile') ?? '#' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user ml-2"></i>
                            الملف الشخصي
                        </a>
                        <a href="{{ url('/') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-home ml-2"></i>
                            الصفحة الرئيسية
                        </a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt ml-2"></i>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
