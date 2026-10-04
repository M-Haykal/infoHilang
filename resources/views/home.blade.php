<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoHilang - Temukan Kembali yang Berharga</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js untuk fitur Dropdown Menu Mobile yang interaktif -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 font-sans" x-data="{ mobileMenuOpen: false }">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <span class="text-2xl font-bold text-slate-800 tracking-tight">Info<span class="text-blue-600">Hilang</span></span>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 font-semibold text-slate-600 items-center">
                <a href="#" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#cara-kerja" class="hover:text-blue-600 transition">Cara Kerja</a>
                <a href="#laporan" class="hover:text-blue-600 transition">Cari Laporan</a>
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                    Buat Laporan +
                </button>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 hover:text-blue-600 focus:outline-none p-2">
                    <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                    <i class="fa-solid fa-xmark text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown (AlpineJS) -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-t border-slate-100 absolute w-full shadow-lg" x-cloak>
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#" class="block px-3 py-3 rounded-md text-base font-semibold text-blue-600 bg-blue-50">Beranda</a>
                <a href="#cara-kerja" class="block px-3 py-3 rounded-md text-base font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50">Cara Kerja</a>
                <a href="#laporan" class="block px-3 py-3 rounded-md text-base font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50">Cari Laporan</a>
                <div class="pt-4">
                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition">
                        Buat Laporan +
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER / HERO -->
    <header class="bg-gradient-to-br from-blue-800 via-blue-600 to-blue-500 py-20 px-4 relative overflow-hidden">
        <!-- Abstract Shapes for Background Texture -->
        <div class="absolute inset-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 rounded-full bg-cyan-300 blur-3xl"></div>
        </div>
        
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight drop-shadow-sm">
                Menyatukan Kembali yang Hilang
            </h1>
            <p class="text-blue-50 text-lg md:text-xl mb-10 max-w-2xl mx-auto font-medium">
                Platform komunitas untuk melaporkan dan menemukan barang, hewan, atau orang tercinta. Mari saling membantu.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <button class="bg-white text-blue-700 px-8 py-4 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg shadow-blue-900/20 transform hover:-translate-y-1">Cari Sesuatu</button>
                <button class="bg-blue-900/40 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-900/60 transition border border-blue-400/50 shadow-lg transform hover:-translate-y-1">Lihat Semua Laporan</button>
            </div>
        </div>
    </header>

    <!-- CARA KERJA -->
    <section id="cara-kerja" class="py-24 max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-800">Bagaimana InfoHilang Bekerja?</h2>
            <div class="w-20 h-1.5 bg-orange-500 mx-auto mt-5 rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-12 text-center">
            <div class="p-6">
                <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-sm transform transition hover:scale-110 hover:rotate-3">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">1. Buat Laporan</h3>
                <p class="text-slate-600 leading-relaxed font-medium">Unggah detail, foto, dan lokasi terakhir saat kehilangan terjadi.</p>
            </div>
            <div class="p-6">
                <div class="w-20 h-20 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-sm transform transition hover:scale-110 hover:-rotate-3">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">2. Sebarkan Informasi</h3>
                <p class="text-slate-600 leading-relaxed font-medium">Komunitas kami akan membantu menyebarkan informasi ke berbagai kanal.</p>
            </div>
            <div class="p-6">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-sm transform transition hover:scale-110 hover:rotate-3">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">3. Temukan Kembali</h3>
                <p class="text-slate-600 leading-relaxed font-medium">Hubungkan penemu dengan pemilik asli secara aman dan cepat.</p>
            </div>
        </div>
    </section>

    <!-- LAPORAN TERBARU -->
    <section id="laporan" class="py-20 bg-slate-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-10 gap-6">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Laporan Terbaru</h2>
                    <p class="text-slate-600 mt-2 text-lg font-medium">Bantu tetangga kita menemukan apa yang hilang.</p>
                </div>

                <!-- Tabs/Filters dengan Style Interaktif -->
                <div class="flex flex-wrap gap-2 bg-white p-1.5 rounded-xl shadow-sm border border-slate-200 w-full lg:w-auto">
                    <button class="flex-1 lg:flex-none bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition">Semua</button>
                    <button class="flex-1 lg:flex-none bg-transparent text-slate-600 hover:text-blue-700 hover:bg-blue-50 px-5 py-2.5 rounded-lg text-sm font-bold transition">Orang</button>
                    <button class="flex-1 lg:flex-none bg-transparent text-slate-600 hover:text-blue-700 hover:bg-blue-50 px-5 py-2.5 rounded-lg text-sm font-bold transition">Hewan</button>
                    <button class="flex-1 lg:flex-none bg-transparent text-slate-600 hover:text-blue-700 hover:bg-blue-50 px-5 py-2.5 rounded-lg text-sm font-bold transition">Barang</button>
                </div>
            </div>

            <!-- Grid Card -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Card 1: Status Hilang -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-200 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&q=80&w=400" alt="Missing Item" class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-110">
                        <!-- Gradient Overlay Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <!-- Badge Hilang -->
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm flex items-center gap-1 z-10">
                            <i class="fa-solid fa-circle-exclamation"></i> Hilang
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-1">Golden Retriever</h3>
                            <span class="text-[10px] text-slate-500 font-bold bg-slate-100 px-2 py-1 rounded whitespace-nowrap">2 jam lalu</span>
                        </div>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-1 font-medium">Hilang di sekitar Taman Kota Menteng dengan kalung merah bernama "Max".</p>
                        <div class="flex items-center text-xs text-slate-700 font-medium mb-5 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-location-dot mr-2 text-red-500 text-sm"></i> 
                            <span class="truncate">Taman Menteng, Jakarta Pusat</span>
                        </div>
                        <button class="w-full bg-slate-800 hover:bg-blue-600 text-white font-bold py-2.5 rounded-lg transition-colors duration-300 flex justify-center items-center gap-2">
                            Detail Laporan <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 2: Status Ditemukan -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-200 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&q=80&w=400" alt="Found Item" class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <!-- Badge Ditemukan -->
                        <span class="absolute top-3 left-3 bg-green-600 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm flex items-center gap-1 z-10">
                            <i class="fa-solid fa-check-circle"></i> Ditemukan
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-1">Dompet Kulit Pria</h3>
                            <span class="text-[10px] text-slate-500 font-bold bg-slate-100 px-2 py-1 rounded whitespace-nowrap">5 jam lalu</span>
                        </div>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-1 font-medium">Ditemukan dompet kulit hitam berisi KTP dan ATM. Diamankan di pos satpam.</p>
                        <div class="flex items-center text-xs text-slate-700 font-medium mb-5 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-location-dot mr-2 text-red-500 text-sm"></i> 
                            <span class="truncate">Halte Blok M, Jakarta Selatan</span>
                        </div>
                        <button class="w-full bg-slate-800 hover:bg-blue-600 text-white font-bold py-2.5 rounded-lg transition-colors duration-300 flex justify-center items-center gap-2">
                            Detail Laporan <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 3: Status Hilang -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-200 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&q=80&w=400" alt="Missing Item" class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm flex items-center gap-1 z-10">
                            <i class="fa-solid fa-circle-exclamation"></i> Hilang
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-1">Kucing Persia</h3>
                            <span class="text-[10px] text-slate-500 font-bold bg-slate-100 px-2 py-1 rounded whitespace-nowrap">1 hari lalu</span>
                        </div>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-1 font-medium">Bulu putih lebat, mata biru, memakai kalung lonceng warna biru kehijauan.</p>
                        <div class="flex items-center text-xs text-slate-700 font-medium mb-5 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-location-dot mr-2 text-red-500 text-sm"></i> 
                            <span class="truncate">Komplek Permata, Depok</span>
                        </div>
                        <button class="w-full bg-slate-800 hover:bg-blue-600 text-white font-bold py-2.5 rounded-lg transition-colors duration-300 flex justify-center items-center gap-2">
                            Detail Laporan <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 4: Status Selesai/Dikembalikan -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-200 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                    <div class="relative overflow-hidden">
                        <!-- Tambahkan filter grayscale jika sudah selesai -->
                        <img src="https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&q=80&w=400" alt="Completed" class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-110 opacity-70">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <!-- Badge Selesai -->
                        <span class="absolute top-3 left-3 bg-slate-600 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm flex items-center gap-1 z-10">
                            <i class="fa-solid fa-handshake-angle"></i> Dikembalikan
                        </span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-1">Kunci Motor Honda</h3>
                            <span class="text-[10px] text-slate-500 font-bold bg-slate-100 px-2 py-1 rounded whitespace-nowrap">2 hari lalu</span>
                        </div>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-1 font-medium">Laporan ditutup. Kunci sudah diserahkan kembali kepada pemiliknya pagi ini.</p>
                        <div class="flex items-center text-xs text-slate-700 font-medium mb-5 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-location-dot mr-2 text-slate-500 text-sm"></i> 
                            <span class="truncate">Stasiun KRL Sudirman</span>
                        </div>
                        <button class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg transition-colors duration-300 flex justify-center items-center gap-2">
                            Lihat Riwayat <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div class="text-center mt-16">
                <a href="#" class="inline-flex items-center justify-center bg-white border-2 border-blue-600 text-blue-600 font-bold hover:bg-blue-600 hover:text-white px-8 py-3.5 rounded-xl transition-all duration-300 group shadow-sm">
                    Lihat Semua 150+ Laporan 
                    <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-16 px-4 border-t-4 border-blue-600">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center md:items-start text-center md:text-left">
            <div>
                <span class="text-3xl font-extrabold text-white tracking-tight">Info<span class="text-blue-400">Hilang</span></span>
                <p class="mt-4 text-sm leading-relaxed max-w-xs mx-auto md:mx-0 font-medium">
                    Platform gotong royong komunitas untuk membantu sesama menemukan apa yang hilang atau mengembalikan apa yang ditemukan.
                </p>
            </div>
            
            <div class="flex flex-col items-center md:items-start space-y-3">
                <h4 class="text-white font-bold text-lg mb-2">Tautan Cepat</h4>
                <a href="#" class="hover:text-blue-400 transition font-medium">Tentang Kami</a>
                <a href="#" class="hover:text-blue-400 transition font-medium">Kebijakan Privasi</a>
                <a href="#" class="hover:text-blue-400 transition font-medium">Syarat & Ketentuan</a>
            </div>

            <div class="flex flex-col items-center md:items-start">
                <h4 class="text-white font-bold text-lg mb-4">Ikuti Kami</h4>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-pink-500 hover:text-white transition-colors duration-300"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors duration-300"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-400 hover:text-white transition-colors duration-300"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto text-center mt-12 pt-8 border-t border-slate-800/80 text-sm font-semibold tracking-wide">
            &copy; 2024 InfoHilang Community. Built with <i class="fa-solid fa-heart text-red-500 mx-1"></i> in Indonesia.
        </div>
    </footer>

</body>
</html>
