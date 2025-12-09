@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Hewan Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Form Laporan Hewan Hilang</h1>
            <p class="text-gray-600">Lengkapi informasi laporan hewan hilang di bawah ini</p>
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
            <form action="" method="POST" enctype="multipart/form-data" data-confirm-save>
                @csrf

                <!-- Nama Hewan -->
                <div class="mb-6">
                    <label for="nama_hewan" class="block text-sm font-semibold text-gray-700 mb-2">Nama Hewan</label>
                    <input type="text" id="nama_hewan" name="nama_hewan" value="{{ old('nama_hewan') }}"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('nama_hewan') border-danger @enderror"
                        placeholder="Masukan nama hewan" required>
                    @error('nama_hewan')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Hewan -->
                <div class="mb-6">
                    <label for="deskripsi_hewan" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                        Hewan</label>
                    <textarea id="deskripsi_hewan" name="deskripsi_hewan" rows="4"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('deskripsi_hewan') border-danger @enderror"
                        placeholder="Contoh: warna bulu, ciri khas, dll.">{{ old('deskripsi_hewan') }}</textarea>
                    @error('deskripsi_hewan')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Jenis Hewan -->
                    <div class="mb-6">
                        <label for="jenis_hewan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Hewan
                        </label>

                        <select name="jenis_hewan" id="hewan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            required>
                            <option value="" disabled selected>Pilih Jenis Hewan</option>
                            @foreach ($animals as $animal)
                                <option value="{{ $animal }}" {{ old('jenis_hewan') == $animal ? 'selected' : '' }}>
                                    {{ $animal }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-6">
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                            Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            required>
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis kelamin
                            </option>
                            <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan
                            </option>
                            <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Ras Hewan -->
                <div class="mb-6">
                    <label for="ras" class="block text-sm font-semibold text-gray-700 mb-2">Ras</label>
                    <input type="text" id="ras" name="ras" value="{{ old('ras') }}"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('ras') border-danger @enderror"
                        placeholder="Masukan ras hewan" required>
                    @error('ras')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Umur dan Warna -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="umur" class="block text-sm font-semibold text-gray-700 mb-2">Umur</label>
                        <input type="number" id="umur" name="umur" value="{{ old('umur') }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('umur') border-danger @enderror"
                            placeholder="Contoh: 5">
                        @error('umur')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="warna" class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
                        <input type="text" id="warna" name="warna" value="{{ old('warna') }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('warna') border-danger @enderror"
                            placeholder="Contoh: hitam, putih, dll.">
                        @error('warna')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Ciri-Ciri -->
                @include('dashboard.components.characteristics', ['ciriCiri' => []])

                <!-- Kontak Darurat -->
                @include('dashboard.components.contacts', ['kontak' => []])

                <!-- Lokasi -->
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-100 cursor-not-allowed">
                    </div>
                </div>

                <!-- Foto Upload -->
                @include('dashboard.components.photo', ['foto' ?? []])

                <input type="hidden" name="user_id" value="{{ $userId }}">

                <!-- submit button -->
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
