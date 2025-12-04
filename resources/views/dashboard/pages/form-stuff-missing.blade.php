@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Barang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Barang Hilang</h1>
            <p class="text-gray-600">Isi formulir di bawah ini untuk melaporkan kehilangan Barang</p>
        </header>

        @if ($errors->has('duplicate'))
            <div class="mb-6 p-5 bg-red-100 border-l-4 border-red-500 text-red-800 rounded-r-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-bold text-lg">Laporan Ditolak – Terdeteksi Duplikat!</p>
                        <p class="mt-1">{{ $errors->first('duplicate') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('form-barang-hilang.store') }}" method="POST" enctype="multipart/form-data"
                data-confirm-save>
                @csrf

                <!-- Nama Barang -->
                <div class="mb-6">
                    <label for="nama_barang" class="block text-sm font-semibold text-gray-700 mb-2">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('nama_barang') border-danger @enderror"
                        placeholder="Masukan nama barang" required>
                    @error('nama_barang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Barang -->
                <div class="mb-6">
                    <label for="deskripsi_barang" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                        Barang</label>
                    <textarea id="deskripsi_barang" name="deskripsi_barang" rows="4"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('deskripsi_barang') border-danger @enderror"
                        placeholder="Contoh: Barang berwarna hitam, merk 'ABC', dll.">{{ old('deskripsi_barang') }}</textarea>
                    @error('deskripsi_barang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis & Merk Barang -->
                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_barang" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                            Barang</label>
                        <input type="text" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang') }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('jenis_barang') border-danger @enderror"
                            placeholder="Masukan jenis barang" required>
                        @error('jenis_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="merk_barang" class="block text-sm font-semibold text-gray-700 mb-2">Merk Barang</label>
                        <input type="text" id="merk_barang" name="merk_barang" value="{{ old('merk_barang') }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('merk_barang') border-danger @enderror"
                            placeholder="Masukan merk barang" required>
                        @error('merk_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Warna Barang -->
                <div class="mb-6">
                    <label for="warna_barang" class="block text-sm font-semibold text-gray-700 mb-2">Warna Barang</label>
                    <input type="text" id="warna_barang" name="warna_barang" value="{{ old('warna_barang') }}"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('warna_barang') border-danger @enderror"
                        placeholder="Masukan warna barang" required>
                    @error('warna_barang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ciri-Ciri Barang -->
                @include('dashboard.components.characteristics', ['ciriCiri' => []])

                <!-- Kontak Darurat -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Kontak Darurat</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($contacts as $contact)
                            <div>
                                <label for="kontak_{{ Str::snake($contact) }}" class="block text-xs text-gray-600 mb-1">
                                    {{ $contact }}
                                </label>
                                <input type="text" id="kontak_{{ Str::snake($contact) }}"
                                    name="kontak[{{ $contact }}]" value="{{ old('kontak.' . $contact) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                    placeholder="Masukkan {{ strtolower($contact) }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                @include('dashboard.components.contacts', ['kontak' => []])

                <!-- Lokasi Terakhir Terlihat -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Terakhir Dilihat</label>
                    <textarea id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">{{ old('lokasi_terakhir_dilihat') }}</textarea>

                    @include('dashboard.components.maps')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly value="{{ old('latitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly value="{{ old('longitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Tanggal & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_terakhir_dilihat" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Terakhir Dilihat
                        </label>
                        <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat"
                            value="{{ old('tanggal_terakhir_dilihat') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status
                            Laporan</label>
                        <input type="text" id="status" name="status" value="Hilang" readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                    </div>
                </div>

                <!-- Foto Upload -->
                @include('dashboard.components.photo', ['foto' => []])

                <!-- Document Upload -->
                @include('dashboard.components.documents', ['dokumen' => []])

                <!-- Hidden User ID -->
                <input type="hidden" name="user_id" value="{{ $userId }}">

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="inline-block px-8 py-3 bg-success text-white font-semibold rounded-lg hover:bg-success/80 focus:outline-none focus:ring-4 focus:ring-primary/30 transition transform hover:scale-105">
                        Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Fungsi umum untuk menghapus field
    </script>
@endpush
