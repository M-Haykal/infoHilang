<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="description"
        content="InfoHilang adalah platform kemanusiaan tercepat untuk lapor dan temukan Orang Hilang, Hewan Hilang, dan Barang Hilang. Cepat, Gratis, dan Terhubung!">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'InfoHilang' }}</title>
    @stack('style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

</head>

<body class="min-h-screen flex flex-col bg-accent font-sans">
    @include('components.loading')
    <nav class="bg-secondary text-white shadow-md fixed w-full z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('start') }}" class="text-2xl font-bold flex items-center">
                <img src="{{ asset('img/logo-infoHilang.png') }}" alt="Logo InfoHilang" srcset=""
                    class="object-fill w-10">
                <h1 class="text-xl font-bold text-primary md:block hidden">Info<span
                        class="text-highlight">Hilang</span>
                </h1>
            </a>

            <!-- Hamburger Button (Mobile) -->
            <button id="mobile-menu-button" class="md:hidden focus:outline-none text-primary"
                aria-label="Toggle mobile menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"
                        class="menu-icon"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"
                        class="close-icon hidden"></path>
                </svg>
            </button>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('start') }}" class="text-primary hover:text-highlight transition">Beranda</a>
                <a href="{{ route('list-missing') }}" class="text-primary hover:text-highlight transition">Daftar
                    Hilang</a>
                <a href="#!" class="text-primary hover:text-highlight transition">Blog</a>

                @auth
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-2 bg-primary px-3 py-2 rounded-lg hover:bg-primary transition">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=' . Str::random('6', '0123456789ABCDEF') . '&color=fff' }}"
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
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-accent">Dashboard</a>
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
                            class="border border-primary text-primary px-4 py-2 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden absolute top-16 left-0 w-full bg-accent text-white shadow-md">
                <div class="flex flex-col items-center space-y-4 py-4">
                    <a href="{{ route('start') }}" class="text-primary hover:text-highlight transition">Beranda</a>
                    <a href="{{ route('list-missing') }}" class="text-primary hover:text-highlight transition">Daftar
                        Hilang</a>
                    <a href="#!" class="text-primary hover:text-highlight transition">Blog</a>
                    @auth
                        <div class="w-full px-4">
                            <!-- Profile Dropdown for Mobile -->
                            <button id="mobile-profile-button"
                                class="flex items-center justify-center w-full space-x-2 bg-blue-700 px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=1E88E5&color=fff' }}"
                                    class="h-8 w-8 rounded-full border border-white" alt="Avatar">
                                <span>{{ Auth::user()->firstname ?? Auth::user()->username }}</span>
                                <svg id="mobile-profile-icon" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="mobile-profile-dropdown"
                                class="hidden mt-2 w-full bg-white text-gray-700 rounded-lg shadow-lg transition-all duration-150">
                                <div class="px-4 py-3 border-b">
                                    <div class="font-semibold text-center">{{ Auth::user()->username }}</div>
                                    <div class="text-sm text-gray-500 text-center"
                                        style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                        title="{{ Auth::user()->email }}">
                                        {{ Str::limit(Auth::user()->email, 20) }}
                                    </div>
                                </div>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 hover:bg-accent text-center">Dashboard</a>
                                <a href="#" class="block px-4 py-2 hover:bg-accent text-center">Pengaturan</a>
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-center px-4 py-2 hover:bg-danger hover:text-white rounded-b-lg">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col space-y-3 w-full px-4">
                            <a href="{{ route('showLogin') }}"
                                class="bg-highlight text-primary px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition text-center">
                                Masuk
                            </a>
                            <a href="{{ route('showRegister') }}"
                                class="border border-white px-4 py-2 rounded-lg font-semibold hover:bg-white hover:text-primary transition text-center">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex flex-1 justify-center py-5">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-secondary dark:bg-background-dark/50 border-t border-border-light dark:border-border-dark mt-16">
        <div class="max-w-6xl mx-auto py-12 px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="size-6 text-primary">
                            <img src="{{ asset('img/logo-infoHilang.png') }}" alt="" srcset="">
                        </div>
                        <h2 class="text-text-light dark:text-text-dark text-xl font-bold">InfoHilang</h2>
                    </div>
                    <p class="text-sm text-subtext-light dark:text-subtext-dark">Membantu menyatukan kembali yang
                        terpisah.</p>
                </div>
                <div class="md:col-span-3 grid grid-cols-2 lg:grid-cols-3 gap-8">
                    <div>
                        <h3 class="font-bold text-text-light dark:text-text-dark mb-4">Tautan Cepat</h3>
                        <ul class="space-y-2">
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="#">FAQ</a></li>
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="#">Kontak Kami</a></li>
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="#">Kebijakan Privasi</a></li>
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="#">Syarat &amp; Ketentuan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-light dark:text-text-dark mb-4">Layanan</h3>
                        <ul class="space-y-2">
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="{{ route('dashboard') }}">Lapor Kehilangan</a></li>
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="#">Lapor Penemuan</a></li>
                            <li><a class="text-sm text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                    href="{{ route('list-missing') }}">Lihat Semua Laporan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-text-light dark:text-text-dark mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a class="text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                href="#">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <a class="text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                href="#">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                </svg>
                            </a>
                            <a class="text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors"
                                href="#">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect height="20" rx="5" ry="5" width="20" x="2" y="2">
                                    </rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mt-8 border-t border-border-light dark:border-border-dark pt-6 text-center text-sm text-subtext-light dark:text-subtext-dark">
                <p>© 2024 InfoHilang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @stack('script')
    <script src="{{ asset('js/start.js') }}"></script>

    {{-- Font Awesome --}}
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
</body>

</html>
