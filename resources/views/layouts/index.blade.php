<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'InfoHilang' }}</title>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    @stack('style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col bg-accent font-sans">
    <nav class="bg-primary text-white shadow-md fixed w-full z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="{{ route('start') }}" class="text-2xl font-bold flex items-center">
                <img src="{{ asset('img/logo-infoHilang.png') }}" alt="Logo InfoHilang" srcset=""
                    class="object-fill w-10"> <span class="ml-2">InfoHilang</span>
            </a>

            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('start') }}" class="hover:text-highlight transition">Beranda</a>
                <a href="#!" class="hover:text-highlight transition">Daftar Hilang</a>
                <a href="#!" class="hover:text-highlight transition">Blog</a>

                @auth
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-2 bg-blue-700 px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=1E88E5&color=fff' }}"
                                class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                            <span>{{ Auth::user()->firstname ?? Auth::user()->username }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-150">
                            <div class="px-4 py-3 border-b">
                                <div class="font-semibold">{{ Auth::user()->username }}</div>
                                <div class="text-sm text-gray-500"
                                    style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                    title="{{ Auth::user()->email }}">
                                    {{ Str::limit(Auth::user()->email, 20) }}
                                </div>
                            </div>
                            <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-accent">Profile</a>
                            <a href="#" class="block px-4 py-2 hover:bg-accent">Pengaturan</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 hover:bg-danger hover:text-white rounded-b-lg">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="space-x-3">
                        <a href="{{ route('showLogin') }}"
                            class="bg-highlight text-primary px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition">
                            Masuk
                        </a>
                        <a href="{{ route('showRegister') }}"
                            class="border border-white px-4 py-2 rounded-lg font-semibold hover:bg-white hover:text-primary transition">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>


    <!-- Konten Utama -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="text-xl font-bold mb-2"> InfoHilang</div>
            <p class="text-gray-400 mb-4">Menghubungkan harapan, memulihkan yang hilang.</p>
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} InfoHilang. Semua laporan ditangani dengan
                privasi dan kehati-hatian.</p>
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @stack('script')
    <script>
        AOS.init();
    </script>
</body>

</html>
