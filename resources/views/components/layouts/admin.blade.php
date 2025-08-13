@props(['title' => 'لوحة الإدارة', 'showNavbar' => true, 'showSearchbar' => false, 'searchAction' => ''])

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title }} - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <x-admin.header :title="$title" />
    
    <!-- Navigation Bar -->
    @if($showNavbar)
        <x-admin.navbar :activeRoute="request()->route()->getName()" />
    @endif
    
    <!-- Search Bar -->
    @if($showSearchbar)
        <x-admin.searchbar :action="$searchAction" :value="request('search')" />
    @endif
    
    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>
    
    <!-- Footer (optional) -->
    <footer class="bg-white border-t border-gray-200 py-4">
        <div class="px-4 lg:px-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.
        </div>
    </footer>
</body>
</html>
