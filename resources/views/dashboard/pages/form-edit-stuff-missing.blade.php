@extends('dashboard.layouts.index')

@section('title', 'Edit Laporan Barang Hilang | InfoHilang')
@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Edit Laporan Barang Hilang</h1>
            <p class="text-gray-600">Isi formulir di bawah ini untuk melaporkan kehilangan Barang</p>
        </header>

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
            <form action="{{ route('form-barang-hilang.update', $barangHilang->slug) }}" method="post"
                enctype="multipart/form-data" data-confirm-save>
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nama_barang" class="block text-sm font-semibold text-gray-700 mb-2">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang"
                        value="{{ old('nama_barang', $barangHilang->nama_barang) }}"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Masukan nama barang" required>
                </div>

                <div class="mb-6">
                    <label for="deskripsi_barang" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                        Barang</label>
                    <textarea id="deskripsi_barang" name="deskripsi_barang" rows="4"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Contoh: Barang berwarna hitam, merk 'ABC', dll.">{{ old('deskripsi_barang', $barangHilang->deskripsi_barang) }}</textarea>
                </div>

                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_barang" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                            Barang</label>
                        <input type="text" id="jenis_barang" name="jenis_barang"
                            value="{{ old('jenis_barang', $barangHilang->jenis_barang) }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('jenis_barang') border-danger @enderror"
                            placeholder="Masukan jenis barang" required>
                        @error('jenis_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="merk_barang" class="block text-sm font-semibold text-gray-700 mb-2">Merk Barang</label>
                        <input type="text" id="merk_barang" name="merk_barang"
                            value="{{ old('merk_barang', $barangHilang->merk_barang) }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('merk_barang') border-danger @enderror"
                            placeholder="Masukan merk barang" required>
                        @error('merk_barang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="warna_barang" class="block text-sm font-semibold text-gray-700 mb-2">Warna Barang</label>
                    <input type="text" id="warna_barang" name="warna_barang"
                        value="{{ old('warna_barang', $barangHilang->warna_barang) }}"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('warna_barang') border-danger @enderror"
                        placeholder="Masukan warna barang" required>
                    @error('warna_barang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @include('dashboard.components.characteristics', [
                    'ciriCiri' => $barangHilang->ciri_ciri ?? [],
                ])

                @include('dashboard.components.contacts', ['kontak' => $barangHilang->kontak ?? []])

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Terakhir Dilihat</label>
                    <input type="text" id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat"
                        value="{{ old('lokasi_terakhir_dilihat', $barangHilang->lokasi_terakhir_dilihat) }}"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">

                    <!-- Map -->
                    @include('dashboard.components.maps')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly
                                value="{{ old('latitude', $barangHilang->latitude) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly
                                value="{{ old('longitude', $barangHilang->longitude) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_terakhir_dilihat" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Terakhir Dilihat
                        </label>
                        <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat"
                            value="{{ old('tanggal_terakhir_dilihat', $barangHilang->tanggal_terakhir_dilihat) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="Hilang" {{ $barangHilang->status == 'Hilang' ? 'selected' : '' }}>Hilang
                            </option>
                            <option value="Ditemukan" {{ $barangHilang->status == 'Ditemukan' ? 'selected' : '' }}>
                                Ditemukan</option>
                            <option value="Ditutup" {{ $barangHilang->status == 'Ditutup' ? 'selected' : '' }}>Ditutup
                            </option>
                        </select>
                    </div>
                </div>

                @include('dashboard.components.photo', ['foto' => $barangHilang->foto ?? []])

                @include('dashboard.components.documents', [
                    'document_pendukung' => $barangHilang->document_pendukung ?? [],
                ])

                <input type="hidden" name="user_id" value="{{ $barangHilang->user_id }}">

                <div class="text-center">
                    <button type="submit"
                        class="inline-block px-8 py-3 bg-highlight text-white font-semibold rounded-lg hover:bg-highlight/80 focus:outline-none focus:ring-4 focus:ring-highlight/30 transition transform hover:scale-105">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
