<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoHilang - Temukan Kembali yang Berharga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <span class="text-2xl font-bold text-slate-800 tracking-tight">Info<span class="text-blue-600">Hilang</span></span>
            </div>
            <div class="hidden md:flex space-x-8 font-medium text-slate-600">
                <a href="#" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#cara-kerja" class="hover:text-blue-600 transition">Cara Kerja</a>
                <a href="#laporan" class="hover:text-blue-600 transition">Cari Laporan</a>
            </div>
            <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold shadow-lg transition">
                Buat Laporan +
            </button>
        </div>
    </nav>

    <header class="bg-blue-600 py-16 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                Menyatukan Kembali yang Hilang
            </h1>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                Platform komunitas untuk melaporkan dan menemukan barang, hewan, atau orang tercinta. Mari saling membantu.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="bg-white text-blue-700 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition">Cari Sesuatu</button>
                <button class="bg-blue-800 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-900 transition border border-blue-400">Lihat Semua Laporan</button>
            </div>
        </div>
    </header>

    <section id="cara-kerja" class="py-20 max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-800">Bagaimana InfoHilang Bekerja?</h2>
            <div class="w-20 h-1 bg-orange-500 mx-auto mt-4"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-12 text-center">
            <div class="p-6">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">1. Buat Laporan</h3>
                <p class="text-slate-600">Unggah detail, foto, dan lokasi terakhir saat kehilangan terjadi.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">2. Sebarkan Informasi</h3>
                <p class="text-slate-600">Komunitas kami akan membantu menyebarkan informasi ke berbagai kanal.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">3. Temukan Kembali</h3>
                <p class="text-slate-600">Hubungkan penemu dengan pemilik asli secara aman dan cepat.</p>
            </div>
        </div>
    </section>

    <section id="laporan" class="py-16 bg-slate-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Laporan Terbaru</h2>
                    <p class="text-slate-600 mt-2">Bantu tetangga kita menemukan apa yang hilang.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm">Semua</button>
                    <button class="bg-white text-slate-600 px-4 py-2 rounded-full text-sm font-medium border hover:border-blue-500 transition shadow-sm">Orang</button>
                    <button class="bg-white text-slate-600 px-4 py-2 rounded-full text-sm font-medium border hover:border-blue-500 transition shadow-sm">Hewan</button>
                    <button class="bg-white text-slate-600 px-4 py-2 rounded-full text-sm font-medium border hover:border-blue-500 transition shadow-sm">Barang</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach(range(1, 4) as $item)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow border border-slate-200">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&q=80&w=400" alt="Missing Item" class="w-full h-48 object-cover">
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Hilang</span>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg text-slate-800">Golden Retriever</h3>
                            <span class="text-xs text-slate-400 font-medium">2 jam lalu</span>
                        </div>
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">Hilang di sekitar Taman Kota Menteng dengan kalung merah bernama "Max".</p>
                        <div class="flex items-center text-xs text-slate-600 mb-4 bg-slate-50 p-2 rounded">
                            <i class="fa-solid fa-location-dot mr-2 text-red-500"></i> Jakarta Pusat
                        </div>
                        <button class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 rounded-lg transition">Detail Laporan</button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="#" class="text-blue-600 font-bold hover:underline">Lihat Semua 150+ Laporan <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-12 px-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <span class="text-2xl font-bold text-white tracking-tight">Info<span class="text-blue-400">Hilang</span></span>
                <p class="mt-2 text-sm">Gotong royong membantu sesama.</p>
            </div>
            <div class="flex space-x-6 text-xl">
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
        <div class="text-center mt-10 pt-8 border-t border-slate-800 text-xs uppercase tracking-widest">
            &copy; 2024 InfoHilang Community. Built with Love.
        </div>
    </footer>

</body>
</html>
