@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Barang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6" data-page="form-stuff-missing">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-dark">Laporan Barang Hilang</h1>
            <p class="text-netral-500 max-w-2xl mx-auto mt-2">Isi formulir di bawah ini untuk melaporkan kehilangan barang
                dengan lengkap dan teliti</p>
        </header>

        <!-- Error Message -->
        @if ($errors->has('duplicate'))
            <div class="max-w-5xl mx-auto">
                <div class="bg-danger p-4 mb-6 rounded-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-xmark text-white"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-white">Laporan Ditolak – Terdeteksi Duplikat!</h3>
                            <div class="mt-2 text-sm text-white">
                                <p>{{ $errors->first('duplicate') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up"
            data-aos-delay="100">
            <form action="{{ route('form-barang-hilang.store') }}" method="POST" enctype="multipart/form-data"
                data-confirm-save class="p-6 sm:p-8">
                @csrf

                <!-- Informasi Dasar Barang -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                        <i class="fa-solid fa-box mr-2 text-primary"></i>
                        Informasi Dasar Barang
                    </h3>

                    <!-- Nama Barang -->
                    <div class="mb-6">
                        <label for="nama_barang" class="block text-sm font-semibold text-dark mb-2">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('nama_barang') border-danger @enderror"
                            placeholder="Masukan nama barang" required>
                        @error('nama_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Barang -->
                    <div class="mb-6">
                        <label for="deskripsi_barang" class="block text-sm font-semibold text-dark mb-2">Deskripsi
                            Barang</label>
                        <textarea id="deskripsi_barang" name="deskripsi_barang" rows="3"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('deskripsi_barang') border-danger @enderror"
                            placeholder="Contoh: Barang berwarna hitam, merk 'ABC', dll.">{{ old('deskripsi_barang') }}</textarea>
                        @error('deskripsi_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis & Merk Barang -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="mb-5 sm:mb-0">
                            <label for="jenis_barang" class="block text-sm font-semibold text-dark mb-2">Jenis
                                Barang</label>
                            <input type="text" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang') }}"
                                class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('jenis_barang') border-danger @enderror"
                                placeholder="Masukan jenis barang" required>
                            @error('jenis_barang')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="merk_barang" class="block text-sm font-semibold text-dark mb-2">Merk
                                Barang</label>
                            <input type="text" id="merk_barang" name="merk_barang" value="{{ old('merk_barang') }}"
                                class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('merk_barang') border-danger @enderror"
                                placeholder="Masukan merk barang" required>
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

                    <!-- Warna Barang -->
                    <div class="mb-6">
                        <label for="warna_barang" class="block text-sm font-semibold text-dark mb-2">Warna
                            Barang</label>
                        <input type="text" id="warna_barang" name="warna_barang" value="{{ old('warna_barang') }}"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('warna_barang') border-danger @enderror"
                            placeholder="Masukan warna barang" required>
                        @error('warna_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ciri-Ciri Barang -->
                    @include('dashboard.components.characteristics', ['ciriCiri' => []])
                </div>

                <hr class="my-8 border-netral-200">

                <!-- Kontak Darurat -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                        <i class="fa-solid fa-phone mr-2 text-primary"></i>
                        Kontak Darurat
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
                        @foreach ($contacts as $contact)
                            <div class="mb-2">
                                <label for="kontak_{{ Str::snake($contact) }}" class="block text-xs text-dark mb-1">
                                    {{ $contact }}
                                </label>
                                <input type="text" id="kontak_{{ Str::snake($contact) }}"
                                    name="kontak[{{ $contact }}]" value="{{ old('kontak.' . $contact) }}"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                                    placeholder="Masukkan {{ $contact }}">
                            </div>
                        @endforeach
                    </div>

                    @include('dashboard.components.contacts', ['kontak' => old('kontak', [])])
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
                        <textarea id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" rows="3"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                            placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">{{ old('lokasi_terakhir_dilihat') }}</textarea>

                        @include('dashboard.components.maps')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-4">
                            <div>
                                <label for="latitude"
                                    class="block text-sm font-semibold text-dark mb-2">Latitude</label>
                                <input type="text" id="latitude" name="latitude" readonly
                                    value="{{ old('latitude') }}"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                            </div>
                            <div>
                                <label for="longitude"
                                    class="block text-sm font-semibold text-dark mb-2">Longitude</label>
                                <input type="text" id="longitude" name="longitude" readonly
                                    value="{{ old('longitude') }}"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                            </div>
                        </div>

                        <div class="bg-accent-surface border border-accent rounded-lg p-4 mt-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-circle-exclamation text-accent"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-accent">Tips Pelaporan</h3>
                                    <p class="text-sm text-accent mt-1">
                                        Koordinat peta akan otomatis terisi saat Anda klik lokasi di peta.
                                        Semakin akurat lokasi, semakin cepat proses pencarian.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <label for="tanggal_terakhir_dilihat" class="block text-sm font-semibold text-dark mb-2">
                                Tanggal Terakhir Dilihat
                            </label>
                            <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat"
                                value="{{ old('tanggal_terakhir_dilihat') }}"
                                class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-dark mb-2">Status
                                Laporan</label>
                            <input type="text" id="status" name="status" value="Hilang" readonly
                                class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
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

                    <!-- Foto Upload -->
                    @include('dashboard.components.photo', ['foto' => []])

                    <!-- Document Upload -->
                    @include('dashboard.components.documents', ['dokumen' => []])

                    <!-- Hidden User ID -->
                    <input type="hidden" name="user_id" value="{{ $userId }}">

                    <!-- Submit Button + Cek Duplikat -->
                    <div class="flex flex-col sm:flex-row gap-5 justify-end items-center mt-8">
                        <button type="submit"
                            class="px-10 py-4 bg-success text-white font-bold rounded-xl hover:bg-success-dark transition shadow-lg text-lg flex items-center justify-center">
                            <i class="fa-regular fa-circle-check mr-2"></i>
                            Kirim Laporan
                        </button>

                        <button type="button" id="check-duplicate-btn" data-type="barang"
                            class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg flex items-center justify-center text-lg">
                            <i class="fa-solid fa-microchip mr-2"></i>
                            Cek Duplikat Laporan
                        </button>
                    </div>
                </div>
            </form>
            <div id="duplicate-result" class="mt-8 hidden"></div>
        </div>
    </div>
@endsection
