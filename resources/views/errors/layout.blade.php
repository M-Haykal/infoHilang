<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Error') | {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen bg-netral-50 flex items-center justify-center p-4">

    <!-- Main Card -->
    <div
        class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-netral-200 p-8 md:p-12 text-center animate-slide-up">

        <!-- Icon Section -->
        <div
            class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full @yield('icon_bg') @yield('icon_color') animate-bounce-soft">
            @yield('icon')
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl md:text-7xl font-black text-dark mb-2 tracking-tight">
            @yield('code')
        </h1>

        <!-- Error Title -->
        <h2 class="text-xl md:text-2xl font-bold text-dark mb-3">
            @yield('title')
        </h2>

        <!-- Error Description -->
        <p class="text-dark-soft text-base mb-8 leading-relaxed">
            @yield('message')
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @yield('actions')
        </div>

        <!-- Footer Links -->
        <div class="mt-8 pt-6 border-t border-netral-200">
            <div class="flex justify-center gap-4 text-sm">
                <a href="{{ url('/') }}"
                    class="text-primary hover:text-primary-dark font-medium transition-colors">Beranda</a>
                <span class="text-netral-300">•</span>
                <a href="{{ url('/contact') }}"
                    class="text-primary hover:text-primary-dark font-medium transition-colors">Bantuan</a>
                <span class="text-netral-300">•</span>
                <a href="#" onclick="location.reload()"
                    class="text-primary hover:text-primary-dark font-medium transition-colors">Muat Ulang</a>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
