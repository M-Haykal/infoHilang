<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terjadi Kesalahan') | {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col items-center justify-center min-h-screen text-gray-800"
    style="
            background-image: url('{{ asset('img/home-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
    ">

    <div
        class="p-10 max-w-lg w-11/12 text-center border-t-4 border-primary bg-white/80 backdrop-blur-md rounded-xl shadow-lg">
        <div class="flex justify-center mb-6">
            <div class="w-48 h-48 rounded-lg overflow-hidden flex items-center justify-center bg-gray-100/70">
                <img src="@yield('image', asset('images/errors/default-error.svg'))" alt="Error Image" class="w-full h-full object-contain" />
            </div>
        </div>

        <h1 class="text-3xl font-bold text-primary mb-3">
            @yield('title', 'Oops! Terjadi Kesalahan')
        </h1>

        <p class="text-gray-700 mb-6 leading-relaxed">
            @yield('message', 'Halaman yang Anda cari tidak ditemukan atau terjadi kesalahan pada sistem.')
        </p>

        <a href="{{ url('/') }}"
            class="inline-block bg-primary text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition-all duration-300">
            Kembali ke Beranda
        </a>
    </div>

    <p class="text-gray-100 text-sm mt-6 drop-shadow">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </p>

</body>

</html>
