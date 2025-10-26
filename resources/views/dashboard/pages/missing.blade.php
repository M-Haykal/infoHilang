@extends('dashboard.layouts.index')

@section('title', 'History Laporan Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Laporan Hilang, {{ Auth::user()->username }}!</h1>
            <p class="text-gray-600">Pantau dan kelola laporan kehilangan anda disini dengan mudah.</p>
        </header>

        <section class="menu-laporan max-w-6xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Buat Laporan Kehilangan Baru</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="#card1"
                    class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
                    data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('img/item.png') }}" alt="Gambar Menu Barang" class="w-full h-48 object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Laporan Barang</h3>
                        <p class="text-gray-500 text-sm mt-2">Laporkan barang yang hilang dengan detail dan lokasi.</p>
                    </div>
                </a>

                <a href="{{ route('form-orang-hilang') }}"
                    class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
                    data-aos="zoom-in" data-aos-delay="300">
                    <img src="{{ asset('img/people.png') }}" alt="Gambar Menu Orang" class="w-full h-48 object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Laporan Orang</h3>
                        <p class="text-gray-500 text-sm mt-2">Laporkan orang hilang dengan informasi lengkap.</p>
                    </div>
                </a>

                <a href="#card3"
                    class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
                    data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('img/animal.png') }}" alt="Gambar Menu Hewan" class="w-full h-48 object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Laporan Hewan</h3>
                        <p class="text-gray-500 text-sm mt-2">Laporkan hewan peliharaan yang hilang.</p>
                    </div>
                </a>
            </div>
        </section>

        <section class="menu-history-hilang max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="600"
            data-aos-delay="200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Histori Laporan</h2>

            <div class="flex justify-center space-x-10 border-b border-gray-200 mb-6">
                <button
                    class="tab-button px-4 sm:px-6 py-3 -mb-px font-medium text-sm text-gray-500 border-b-2 border-transparent hover:text-primary hover:border-primary focus:outline-none active border-primary"
                    data-tab="tab1">
                    Barang Hilang
                </button>
                <button
                    class="tab-button px-4 sm:px-6 py-3 -mb-px font-medium text-sm text-gray-500 border-b-2 border-transparent hover:text-primary hover:border-primary focus:outline-none"
                    data-tab="tab2">
                    Orang Hilang
                </button>
                <button
                    class="tab-button px-4 sm:px-6 py-3 -mb-px font-medium text-sm text-gray-500 border-b-2 border-transparent hover:text-primary hover:border-primary focus:outline-none"
                    data-tab="tab3">
                    Hewan Hilang
                </button>
            </div>


            <div class="tab-content bg-white rounded-xl shadow-lg p-6">
                <div id="tab1" class="tab-pane active">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Barang Hilang</h3>
                    <div class="space-y-4">

                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <img src="{{ asset('img/item.png') }}" alt="Barang" class="w-16 h-16 object-cover rounded">
                            <div>
                                <h4 class="font-semibold text-gray-800">Dompet Kulit</h4>
                                <p class="text-sm text-gray-600">Hilang di: Pasar Senen, Jakarta | 12 Okt 2025</p>
                                <p class="text-sm text-gray-500">Status: Belum Ditemukan</p>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm text-center mt-4">Belum ada laporan lain.</p>
                    </div>
                </div>
                <div id="tab2" class="tab-pane hidden">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Orang Hilang</h3>
                    <div class="space-y-4">

                        @forelse ($missingPersons as $missingPerson)
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <img src="{{ asset('storage/' . ($missingPerson->foto[0] ?? 'default.jpg')) }}"
                                    alt="Orang" class="w-16 h-16 object-cover rounded">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $missingPerson->nama_orang }}</h4>
                                    <p class="text-sm text-gray-600">Hilang di:
                                        {{ $missingPerson->lokasi_terakhir_dilihat }} |
                                        {{ $missingPerson->tanggal_terakhir_dilihat }}</p>
                                    <p class="text-sm text-gray-500">Status: {{ $missingPerson->status }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm text-center mt-4">Belum ada laporan lain.</p>
                        @endforelse
                    </div>
                </div>
                <div id="tab3" class="tab-pane hidden">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Hewan Hilang</h3>
                    <div class="space-y-4">

                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <img src="{{ asset('img/animal.png') }}" alt="Hewan" class="w-16 h-16 object-cover rounded">
                            <div>
                                <h4 class="font-semibold text-gray-800">Kucing Persia</h4>
                                <p class="text-sm text-gray-600">Hilang di: Surabaya, Jawa Timur | 8 Okt 2025</p>
                                <p class="text-sm text-gray-500">Status: Belum Ditemukan</p>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm text-center mt-4">Belum ada laporan lain.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <style>
        .tab-button.active {
            color: #1E88E5 !important;
            border-color: #1E88E5 !important;
        }
    </style>
@endpush

@push('script')
    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'text-primary', 'border-primary');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                button.classList.add('active', 'text-primary', 'border-primary');
                button.classList.remove('text-gray-500', 'border-transparent');


                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.add('hidden');
                });

                document.getElementById(button.dataset.tab).classList.remove('hidden');
            });
        });
    </script>
@endpush
