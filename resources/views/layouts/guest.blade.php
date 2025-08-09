<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Yammam Cafe') }}</title>

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
            background-color: #f8f9fa;
        }

        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08),
                        0 8px 10px -6px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .card-shadow:hover {
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.12),
                        0 10px 15px -6px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        .logo-container {
            transition: all 0.3s ease;
            width: 100px;
            height: 100px;
        }

        @media (min-width: 640px) {
            .logo-container {
                width: 110px;
                height: 110px;
            }
        }

        .logo-container:hover {
            transform: scale(1.05);
        }

        .card-body {
            padding: 3rem 2.5rem !important; /* علوي/سفلي 48px — جانبي 40px */
        }
        @media (min-width: 640px) {
            .card-body { padding: 3.5rem 2.5rem !important; } /* sm:py-14 */
        }

    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
        
        <!-- الشعار -->
        <div class="mb-8 sm:mb-10 lg:mb-12">
            <a href="/" class="flex flex-col items-center justify-center">
                <div class="bg-black rounded-3xl flex items-center justify-center shadow-lg overflow-hidden logo-container">
                    <img src="{{ asset('images/yammam-logo.png') }}" alt="يمام كافيه" class="w-full h-full object-cover">
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mt-4">يمام كافيه</h1>
            </a>
        </div>

        <div class="w-full sm:max-w-md bg-white shadow-lg overflow-hidden rounded-2xl sm:rounded-3xl border border-gray-100 card-shadow card-body">
            {{ $slot }}
        </div>



        <!-- الفوتر -->
        <div class="mt-6 sm:mt-8 lg:mt-10 text-center text-sm text-gray-600 px-4 sm:px-6">
            <p>© {{ date('Y') }} يمام كافيه - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>
