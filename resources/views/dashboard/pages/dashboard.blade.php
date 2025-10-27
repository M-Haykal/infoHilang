@extends('dashboard.layouts.index')

@section('title', 'Dashboard | InfoHilang')

@section('content')

    <!-- Dashboard Section -->
    <div class="space-y-6">
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->username }}!</h1>
            <p class="text-gray-600">Here's what's happening with your account today.</p>
        </header>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Pengaduan Barang Hilang </h2>
                <p class="text-2xl font-bold text-highlight">{{ $missingItems }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Pengaduan Orang Hilang </h2>
                <p class="text-2xl font-bold text-success">{{ $missingPersons }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Pengaduan Hewan Hilang </h2>
                <p class="text-2xl font-bold text-danger">{{ $missingAnimals }}</p>
            </div>
        </div>


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
    </div>
@endsection
