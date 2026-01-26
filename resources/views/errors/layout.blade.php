<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terjadi Kesalahan') | {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden bg-netral-50 font-sans text-dark py-12">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8 sm:p-10 mx-4 z-10 text-center" data-aos="zoom-in" data-aos-duration="600">
        <div class="flex justify-center">
            <div class="relative">
                <img src="@yield('image')" alt="Error State" class="relative w-56 h-56 object-contain" />
            </div>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold text-primary mb-4 tracking-tight">
            @yield('title', 'Oops! Terjadi Kesalahan')
        </h1>

        <p class="text-netral-500 mb-8 leading-relaxed font-medium">
            @yield('message', 'Halaman yang Anda cari tidak ditemukan atau terjadi kesalahan pada sistem.')
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-[0.98]">
                <i class="fa-solid fa-house-chimney text-sm"></i>
                Kembali ke Beranda
            </a>

            @if(request()->is('errors/401') || request()->status == 401)
            <a href="{{ route('showLogin') }}" class="inline-flex items-center justify-center gap-2 border-2 border-accent text-accent-hover hover:bg-accent-surface px-8 py-3.5 rounded-xl font-bold transition-all">
                Masuk Sekarang
            </a>
            @endif
        </div>
    </div>

    <p class="text-netral-400 text-sm font-medium mt-10">
        &copy; {{ date('Y') }} InfoHilang. All rights reserved.
    </p>

</body>

</html>
