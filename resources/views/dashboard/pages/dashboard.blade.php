@extends('dashboard.layouts.index')

@section('title', 'Dashboard | InfoHilang')

@section('content')

<!-- Dashboard Section -->
<div class="space-y-6" data-page="dashboard" id="dashboard">
    <header class="text-center">
        <h1 class="text-2xl font-bold text-dark mb-2">Selamat Datang, {{ Auth::user()->fullname }}!</h1>
        <p class="text-netral-500">Kelola laporan barang, orang, atau hewan hilang.</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md" id="missing-stuff-card">
            <h2 class="text-lg font-semibold text-dark">Pengaduan Barang Hilang </h2>
            <p class="text-2xl font-bold text-accent">{{ $missingItems }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md" id="missing-person-card">
            <h2 class="text-lg font-semibold text-dark">Pengaduan Orang Hilang </h2>
            <p class="text-2xl font-bold text-success">{{ $missingPersons }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md" id="missing-animal-card">
            <h2 class="text-lg font-semibold text-dark">Pengaduan Hewan Hilang </h2>
            <p class="text-2xl font-bold text-danger">{{ $missingAnimals }}</p>
        </div>
    </div>

    <section class="menu-laporan mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100" id="menu-report">
        <h2 class="text-2xl font-semibold text-dark mb-6">Buat Laporan Kehilangan Baru</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('form-barang-hilang') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300" data-aos="zoom-in" data-aos-delay="200" id="add-stuff-missing">
                <img src="{{ asset('img/item.png') }}" alt="Gambar Menu Barang" class="w-full h-48 object-cover bg-primary-light">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-dark">Tambah Laporan Barang Hilang</h3>
                    <p class="text-netral-500 text-sm mt-2">Laporkan barang yang hilang dengan detail dan lokasi.</p>
                </div>
            </a>

            <a href="{{ route('form-orang-hilang') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300" data-aos="zoom-in" data-aos-delay="300" id="add-person-missing">
                <img src="{{ asset('img/people.png') }}" alt="Gambar Menu Orang" class="w-full h-48 object-cover bg-primary-light">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-dark">Tambah Laporan Orang Hilang</h3>
                    <p class="text-netral-500 text-sm mt-2">Laporkan orang hilang dengan informasi lengkap.</p>
                </div>
            </a>

            <a href="{{ route('form-hewan-hilang') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300" data-aos="zoom-in" data-aos-delay="400" id="add-animal-missing">
                <img src="{{ asset('img/animal.png') }}" alt="Gambar Menu Hewan" class="w-full h-48 object-cover bg-primary-light">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-dark">Tambah Laporan Hewan Hilang</h3>
                    <p class="text-netral-500 text-sm mt-2">Laporkan hewan peliharaan yang hilang.</p>
                </div>
            </a>
        </div>
    </section>
</div>
@endsection
