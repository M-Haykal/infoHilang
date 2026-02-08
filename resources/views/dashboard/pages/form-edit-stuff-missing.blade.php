@extends('dashboard.layouts.index')

@section('title', 'Edit Laporan Barang Hilang | InfoHilang')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">

        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Edit Laporan Barang Hilang</h1>
            <nav class="flex justify-center lg:justify-start mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-xs font-medium text-netral-400">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li>
                        <a href="{{ route('missing') }}" class="hover:text-primary transition-colors">Barang Hilang</a>
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
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('form-barang-hilang.update', $barangHilang->slug) }}" method="post" enctype="multipart/form-data" data-confirm-save>
            @csrf
            @method('PUT')

            <!-- Informasi Dasar Barang -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-box mr-2 text-primary"></i>
                    Informasi Dasar Barang
                </h3>
                {{-- Nama Barang --}}
                <div class="mb-6">
                    <label for="nama_barang" class="block text-sm font-semibold text-dark mb-2">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barangHilang->nama_barang) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Masukan nama barang" required>
                </div>

                {{-- Deskripsi Barang --}}
                <div class="mb-4">
                    <label for="deskripsi_barang" class="block text-sm font-semibold text-dark mb-2">Deskripsi
                        Barang</label>
                    <textarea id="deskripsi_barang" name="deskripsi_barang" rows="4" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Contoh: Barang berwarna hitam, merk 'ABC', dll.">{{ old('deskripsi_barang', strip_tags($barangHilang->deskripsi_barang)) }}</textarea>
                </div>

                {{-- Jenis & Merk Barang --}}
                <div class="mb-6 grid grid-cols-2 gap-2">
                    <div>
                        <label for="jenis_barang" class="block text-sm font-semibold text-dark mb-2">Jenis
                            Barang</label>
                        <input type="text" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang', $barangHilang->jenis_barang) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('jenis_barang') border-danger @enderror" placeholder="Masukan jenis barang" required>
                        @error('jenis_barang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="merk_barang" class="block text-sm font-semibold text-dark mb-2">Merk Barang</label>
                        <input type="text" id="merk_barang" name="merk_barang" value="{{ old('merk_barang', $barangHilang->merk_barang) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('merk_barang') border-danger @enderror" placeholder="Masukan merk barang" required>
                        @error('merk_barang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-8 border-netral-200">

            <!-- Detail Fisik Barang -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-message mr-2 text-primary"></i>
                    Detail Fisik Barang
                </h3>
                <div class="mb-6">
                    <label for="warna_barang" class="block text-sm font-semibold text-dark mb-2">Warna Barang</label>
                    <input type="text" id="warna_barang" name="warna_barang" value="{{ old('warna_barang', $barangHilang->warna_barang) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('warna_barang') border-danger @enderror" placeholder="Masukan warna barang" required>
                    @error('warna_barang')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @include('dashboard.components.characteristics', ['ciriCiri' => $barangHilang->ciri_ciri ?? [],])
            </div>

            <hr class="my-8 border-netral-200">

            <!-- Kontak Darurat -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-phone mr-2 text-primary"></i>
                    Kontak Darurat
                </h3>

                @include('dashboard.components.contacts', ['kontak' => $barangHilang->kontak ?? []])
            </div>

            <hr class="my-8 border-netral-200">

            <!-- Lokasi & Waktu -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-map-marker-alt mr-2 text-primary"></i>
                    Lokasi & Waktu
                </h3>

                <!-- Lokasi -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-dark mb-2">Lokasi Terakhir Dilihat</label>
                    <input type="text" id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" value="{{ old('lokasi_terakhir_dilihat', strip_tags($barangHilang->lokasi_terakhir_dilihat)) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">

                    <!-- Map -->
                    @include('dashboard.components.maps')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-dark mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly value="{{ old('latitude', $barangHilang->latitude) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-dark mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly value="{{ old('longitude', $barangHilang->longitude) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Tanggal & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <label for="tanggal_terakhir_dilihat" class="block text-sm font-semibold text-dark mb-2">
                            Tanggal Terakhir Dilihat
                        </label>
                        <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat" value="{{ old('tanggal_terakhir_dilihat', $barangHilang->tanggal_terakhir_dilihat) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-dark mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                            <option value="Hilang" {{ $barangHilang->status == 'Hilang' ? 'selected' : '' }}>Hilang
                            </option>
                            <option value="Ditemukan" {{ $barangHilang->status == 'Ditemukan' ? 'selected' : '' }}>
                                Ditemukan</option>
                            <option value="Ditutup" {{ $barangHilang->status == 'Ditutup' ? 'selected' : '' }}>Ditutup
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-netral-200">

            <!-- Foto, Dokumen & Submit -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-image mr-2 text-primary"></i>
                    Foto, Dokumen & Submit
                </h3>
                @include('dashboard.components.photo', ['foto' => $barangHilang->foto ?? []])

                @include('dashboard.components.documents', [
                'document_pendukung' => $barangHilang->document_pendukung ?? [],
                ])

                <input type="hidden" name="user_id" value="{{ $barangHilang->user_id }}">

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
            </div>
        </form>
    </div>
</div>
@endsection
