<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Yammam Cafe') }}</title>

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
<body class="font-sans antialiased bg-gray-50 pb-20">
    <!-- Header -->
    <x-user.header :title="$title ?? 'Yammam Cafe'" />

    <!-- Page Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Bottom Navigation -->
    <x-user.bottom-navigation />

    <!-- Cart JavaScript -->
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
