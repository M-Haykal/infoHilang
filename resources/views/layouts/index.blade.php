<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="InfoHilang adalah platform kemanusiaan tercepat untuk lapor dan temukan Orang Hilang, Hewan Hilang, dan Barang Hilang. Cepat, Gratis, dan Terhubung!">
    <meta name="theme-color" content="#ffd57d">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'InfoHilang' }}</title>
    @stack('style')
    @livewireStyles
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    {{-- Font Awesome --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/all.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body class="bg-netral-50 font-sans">
    @include('components.loading')
    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">

            <a href="{{ route('start') }}" class="flex items-center gap-2 group">
                <div class="bg-primary p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <span class="text-2xl font-black text-dark tracking-tight">Info<span class="text-primary">Hilang</span></span>
            </a>

            <div class="hidden md:flex items-center space-x-8 font-bold text-dark">
                <a href="{{ route('start') }}" class="hover:text-primary transition">Beranda</a>
                <a href="{{ route('start') }}#cara-kerja" class="hover:text-primary transition">Cara Kerja</a>
                <a href="{{ route('start') }}#laporan" class="hover:text-primary transition">Cari Laporan</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                <div class="relative group">
                    <button id="user-menu-button" class="flex items-center space-x-3 bg-netral-50 p-1 pr-3 rounded-full hover:bg-netral-100 transition border border-netral-200">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=ea580c&color=fff' }}" class="h-8 w-8 rounded-full object-cover border-2 border-white shadow-sm" alt="Avatar">
                        <span class="text-sm font-bold text-dark hidden sm:inline-block">{{ Auth::user()->firstname ?? Auth::user()->username }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-netral-400 transition-transform duration-200" id="dropdown-icon"></i>
                    </button>

                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-netral-100 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                        <div class="px-5 py-4 bg-netral-50/50 border-b border-netral-100">
                            <p class="text-xs text-netral-400 uppercase tracking-wider">Akun Saya</p>
                            <p class="font-black text-dark truncate">{{ Auth::user()->username }}</p>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-netral-500 hover:primary-light hover:text-primary rounded-xl transition font-medium">
                                <i class="fa-solid fa-gauge-high text-sm"></i> Dashboard
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 text-netral-500 hover:primary-light hover:text-primary rounded-xl transition font-medium">
                                <i class="fa-solid fa-gear text-sm"></i> Pengaturan
                            </a>
                        </div>
                        <div class="p-2 border-t border-netral-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full text-left px-3 py-2 text-danger hover:bg-danger-light rounded-xl transition font-bold">
                                    <i class="fa-solid fa-right-from-bracket text-sm"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('showLogin') }}" class=" bg-accent hover:bg-accent-hover text-white px-5 py-2 rounded-xl font-bold shadow-lg shadow-orange-200 transition active:scale-95">
                        Buat Laporan +
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-dark text-netral-400 py-12 px-8">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center gap-8">
            <div>
                <a href="{{ route('start') }}" class="inline-block mb-3">
                    <span class="text-3xl font-bold text-white tracking-tight">Info<span class="text-primary">Hilang</span></span>
                </a>
                <p class="text-sm md:text-base max-w-xs mx-auto">
                    Gotong royong untuk membantu sesama.
                </p>
            </div>

            <div class="flex space-x-6 text-2xl">
                <a href="#" class="hover:text-white transition-colors duration-300">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="hover:text-white transition-colors duration-300">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="#" class="hover:text-white transition-colors duration-300">
                    <i class="fa-brands fa-twitter"></i>
                </a>
            </div>

            <div class="w-full mt-2 pt-8 border-t border-dark-soft text-xs uppercase tracking-widest">
                <p>&copy; 2026 <span class="text-white font-semibold">InfoHilang</span>. Built with Love.</p>
            </div>

        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @stack('script')
    <script src="{{ asset('js/start.js') }}"></script>
    <!-- Leaflet Maps -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- Font Awesome --}}
    {{-- <script src="{{ asset('js/all.js') }}"></script> --}}
    <script src="{{ asset('js/all.min.js') }}"></script>

    @livewireScripts
</body>

</html>
