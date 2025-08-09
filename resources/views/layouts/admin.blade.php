<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'لوحة الإدارة - Yammam Cafe' }}</title>

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
        }

    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar (Desktop) -->
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:mr-64">
            <!-- Header -->
            <x-admin.header :title="$title ?? 'لوحة الإدارة'" />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6 pb-20 lg:pb-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Bottom Navigation (Mobile) -->
    <x-admin.bottom-navigation />
</body>
</html>
