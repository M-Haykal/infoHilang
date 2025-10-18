<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'InfoHilang' }}</title>
</head>

<body class="min-h-screen flex flex-col bg-secondary font-sans">
    <!-- Navbar -->
    <nav class="bg-primary text-white py-4 shadow-md">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="text-xl font-bold flex items-center">
                <span class="mr-2">🔍</span> InfoHilang
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('start') }}" class="hover:underline">Beranda</a>
                <a href="#types" class="hover:underline">Jenis Laporan</a>
                <a href="#how" class="hover:underline">Cara Kerja</a>
                <a href="#contact" class="hover:underline">Kontak</a>
            </div>
            <button class="md:hidden text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="text-xl font-bold mb-2">🔍 InfoHilang</div>
            <p class="text-gray-400 mb-4">Menghubungkan harapan, memulihkan yang hilang.</p>
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} InfoHilang. Semua laporan ditangani dengan
                privasi dan kehati-hatian.</p>
        </div>
    </footer>
</body>

</html>
