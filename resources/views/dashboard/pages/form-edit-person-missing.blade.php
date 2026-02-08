@extends('dashboard.layouts.index')

@section('title', 'Edit Laporan Orang Hilang | InfoHilang')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">

        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Edit Laporan Orang Hilang</h1>
            <nav class="flex justify-center lg:justify-start mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-xs font-medium text-netral-400">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li>
                        <a href="{{ route('missing') }}" class="hover:text-primary transition-colors">Orang Hilang</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li class="text-primary font-bold italic">Edit Laporan</li>
                </ol>
            </nav>
        </div>

        <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-50 pointer-events-auto">
            <a href="{{ route('missing') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-dark border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-primary hover:border-primary hover:shadow-md transition-all group active:scale-95">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    @if ($errors->any())
    <div class="bg-danger text-white p-4 rounded mb-6">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('form-orang-hilang.update', $orangHilang->slug) }}" method="POST" enctype="multipart/form-data" data-confirm-save>
            @csrf
            @method('PUT')
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-user mr-2 text-primary"></i>Informasi Dasar
                </h3>

                <!-- Nama Orang -->
                <div class="mb-6">
                    <label for="nama_orang" class="block text-sm font-semibold text-dark mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_orang" name="nama_orang" value="{{ old('nama_orang', $orangHilang->nama_orang) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Masukkan nama lengkap orang yang hilang" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi_orang" class="block text-sm font-semibold text-dark mb-2">Deskripsi
                        Fisik</label>
                    <textarea id="deskripsi_orang" name="deskripsi_orang" rows="4" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Contoh: tinggi 165 cm, rambut hitam, dll.">{{ old('deskripsi_orang', strip_tags($orangHilang->deskripsi_orang)) }}</textarea>
                </div>

                <!-- Umur dan Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <label for="umur" class="block text-sm font-semibold text-dark mb-2">Umur</label>
                        <input type="number" id="umur" name="umur" value="{{ old('umur', $orangHilang->umur) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-dark mb-2">Jenis
                            Kelamin</label>
                        <input type="text" id="jenis_kelamin" name="jenis_kelamin" value="{{ old('jenis_kelamin', $orangHilang->jenis_kelamin) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" readonly>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-netral-200">

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-message mr-2 text-primary"></i>
                    Ciri-Ciri Khusus
                </h3>

                <!-- Ciri-Ciri -->
                @include('dashboard.components.characteristics', [
                'ciriCiri' => $orangHilang->ciri_ciri ?? [],
                ])
            </div>

            <hr class="my-8 border-netral-200">

            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-phone mr-2 text-primary"></i>
                    Kontak Darurat
                </h3>

                <!-- Kontak -->
                @include('dashboard.components.contacts', ['kontak' => $orangHilang->kontak ?? []])
            </div>

            <hr class="my-8 border-netral-200">

            <!-- Lokasi & Tanggal -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-map-marker-alt mr-2 text-primary"></i>
                    Lokasi & Waktu
                </h3>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-dark mb-2">Lokasi Terakhir Dilihat</label>
                    <input type="text" id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" value="{{ old('lokasi_terakhir_dilihat', strip_tags($orangHilang->lokasi_terakhir_dilihat)) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">

                    <!-- Map -->
                    @include('dashboard.components.maps')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-dark mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly value="{{ old('latitude', $orangHilang->latitude) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-dark mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly value="{{ old('longitude', $orangHilang->longitude) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Tanggal & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
                    <div>
                        <label for="tanggal_terakhir_dilihat" class="block text-sm font-semibold text-dark mb-2">Tanggal
                            Terakhir Dilihat</label>
                        <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat" value="{{ old('tanggal_terakhir_dilihat', $orangHilang->tanggal_terakhir_dilihat ? \Carbon\Carbon::parse($orangHilang->tanggal_terakhir_dilihat)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-dark mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                            <option value="Hilang" {{ $orangHilang->status == 'Hilang' ? 'selected' : '' }}>Hilang
                            </option>
                            <option value="Ditemukan" {{ $orangHilang->status == 'Ditemukan' ? 'selected' : '' }}>
                                Ditemukan</option>
                            <option value="Ditutup" {{ $orangHilang->status == 'Ditutup' ? 'selected' : '' }}>Ditutup
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-netral-200">

            <!-- Foto -->
            @include('dashboard.components.photo', ['foto' => $orangHilang->foto ?? []])

            <input type="hidden" name="user_id" value="{{ $orangHilang->user_id }}">

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end items-center mt-8">
                <button type="submit" class="px-10 py-4 bg-success text-white font-bold rounded-xl hover:bg-success-dark transition shadow-lg text-lg flex items-center justify-center">
                    <i class="fa-regular fa-circle-check mr-2"></i>
                    Perbarui Laporan
                </button>

                <a href="{{ route('missing') }}" class="px-10 py-4 bg-netral-400 text-white font-bold rounded-xl hover:bg-netral-500 transition shadow-lg flex items-center justify-center text-lg group">
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1 mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script></script>
@endpush
