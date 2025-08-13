<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'يمام كافيه' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
        }

        /* تنعيم حواف الحقول */
        input,
        select,
        button {
            border-radius: 0.75rem !important;
        }

        /* تحسين مظهر القوائم المنسدلة */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-left: 2.5rem;
        }

        /* Line Clamp for Product Descriptions */
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar (Desktop) -->
        <x-user.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:mr-64">
            <!-- Header -->
            <x-user.header :title="$title ?? 'يمام كافيه'" />

            <!-- Search Bar - يظهر حسب الصفحة -->
            @if(isset($searchPage))
            <div class="search-bar-container sticky top-0 z-30">
                <x-user.search-bar :page="$searchPage" />
            </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6 pb-20 lg:pb-6 pt-4 lg:pt-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Bottom Navigation (Mobile) -->
    <x-user.bottom-navigation />
</body>
</html>
