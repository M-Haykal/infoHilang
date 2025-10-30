<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terjadi Kesalahan') | {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-accent text-gray-800 flex flex-col items-center justify-center min-h-screen">

    <div class=" p-10 max-w-lg w-11/12 text-center border-t-4 border-primary">
        <div class="flex justify-center mb-6">
            <div class="w-48 h-48 rounded-lg overflow-hidden flex items-center justify-center">
                <img src="@yield('image', asset('images/errors/default-error.svg'))" alt="Error Image" class="w-full h-full object-contain" />
            </div>
        </div>


        <h1 class="text-3xl font-bold text-primary mb-3">
            @yield('title', 'Oops! Terjadi Kesalahan')
        </h1>

        <p class="text-gray-600 mb-6 leading-relaxed">
            @yield('message', 'Halaman yang Anda cari tidak ditemukan atau terjadi kesalahan pada sistem.')
        </p>

        <a href="{{ url('/') }}"
            class="inline-block bg-primary text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition-all duration-300">
            Kembali ke Beranda
        </a>
    </div>

    <p class="text-gray-500 text-sm mt-6">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </p>

</body>

</html>
