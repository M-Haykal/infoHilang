<!DOCTYPE html>
<html lang="id">

<head>
    {{-- <meta name="user-id" content="{{ Auth::user()->id }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
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
            <!-- Logo -->
            <a href="{{ route('start') }}" class="text-2xl font-bold flex items-center">
                <img src="{{ asset('img/logo-infoHilang.png') }}" alt="Logo InfoHilang" srcset=""
                    class="object-fill w-10"> <span class="ml-2">InfoHilang</span>
            </a>

            <!-- Hamburger Button (Mobile) -->
            <button id="mobile-menu-button" class="md:hidden focus:outline-none" aria-label="Toggle mobile menu">
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
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-accent">Dashboard</a>
                            <a href="#" class="block px-4 py-2 hover:bg-accent">Pengaturan</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 hover:bg-danger hover:text-white rounded-b-lg">
                                    Keluar
                                </button>
                            </form>
                            <a href="{{ url('Chat/1') }}" class="block px-4 py-2 hover:bg-accent text-center">Chat
                                testing</a>
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

            <!-- Mobile Menu -->
            <div id="mobile-menu"
                class="hidden md:hidden absolute top-16 left-0 w-full bg-primary text-white shadow-md">
                <div class="flex flex-col items-center space-y-4 py-4">
                    <a href="{{ route('start') }}" class="hover:text-highlight transition">Beranda</a>
                    <a href="#!" class="hover:text-highlight transition">Daftar Hilang</a>
                    <a href="#!" class="hover:text-highlight transition">Blog</a>
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
                                <a href="{{ url('Chat/1') }}" class="block px-4 py-2 hover:bg-accent text-center">Chat
                                    testing</a>
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
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="text-xl font-bold mb-2">InfoHilang</div>
                <p class="text-gray-400 mb-4">Menghubungkan harapan, memulihkan yang hilang.</p>
            </div>
            <div class="mt-6 max-w-3xl mx-auto">
                <h3 class="text-lg font-semibold mb-3 flex items-center justify-center">
                    <span class="mr-2">🌟</span> Visi
                </h3>
                <p class="text-gray-300 text-sm leading-relaxed mb-6 text-center">
                    Menjadi platform digital terpercaya dalam pelaporan dan pencarian kehilangan, yang menghubungkan
                    harapan dan tindakan demi terciptanya masyarakat yang peduli dan tanggap.
                </p>
                <h3 class="text-lg font-semibold mb-3 flex items-center justify-center">
                    <span class="mr-2">🎯</span> Misi
                </h3>
                <ul class="text-gray-300 text-sm leading-relaxed list-disc list-inside text-left mx-auto max-w-xl">
                    <li>Menyediakan layanan pelaporan kehilangan yang cepat, aman, dan mudah digunakan.</li>
                    <li>Mendorong partisipasi aktif masyarakat dalam proses pencarian dan pemulangan.</li>
                    <li>Menjaga privasi dan keamanan data pengguna secara bertanggung jawab.</li>
                    <li>Menghubungkan pelapor, warga sekitar, dan pihak berwenang melalui teknologi yang inklusif.</li>
                    <li>Menumbuhkan budaya empati dan solidaritas dalam menghadapi kehilangan.</li>
                </ul>
            </div>
            <p class="text-sm text-gray-500 mt-6 text-center">&copy; {{ date('Y') }} InfoHilang. Semua laporan
                ditangani dengan privasi dan kehati-hatian.</p>
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @stack('script')
    <script>
        AOS.init();
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = this.querySelector('.menu-icon');
            const closeIcon = this.querySelector('.close-icon');
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        document.getElementById('mobile-profile-button').addEventListener('click', function() {
            const profileDropdown = document.getElementById('mobile-profile-dropdown');
            const profileIcon = document.getElementById('mobile-profile-icon');
            profileDropdown.classList.toggle('hidden');
            profileIcon.classList.toggle('rotate-180');
        });
    </script>
</body>

</html>
