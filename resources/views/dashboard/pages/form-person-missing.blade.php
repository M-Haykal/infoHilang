@extends('dashboard.layouts.index')

@section('title', 'Form Pengaduan Hilang Manusia | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Hilang Orang</h1>
            <p class="text-gray-600">Isi formulir di bawah ini untuk melaporkan kehilangan orang</p>
        </header>

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('form-orang-hilang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Orang -->
                <div class="mb-6">
                    <label for="nama_orang" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_orang" name="nama_orang" value="{{ old('nama_orang') }}"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('nama_orang') border-danger @enderror"
                        placeholder="Masukkan nama lengkap orang yang hilang" required>
                    @error('nama_orang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Orang -->
                <div class="mb-6">
                    <label for="deskripsi_orang" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                        Fisik</label>
                    <textarea id="deskripsi_orang" name="deskripsi_orang" rows="4"
                        class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('deskripsi_orang') border-danger @enderror"
                        placeholder="Contoh: Tinggi 165 cm, berat 60 kg, rambut hitam lurus, dll.">{{ old('deskripsi_orang') }}</textarea>
                    @error('deskripsi_orang')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Umur & Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="umur" class="block text-sm font-semibold text-gray-700 mb-2">Umur</label>
                        <input type="number" id="umur" name="umur" value="{{ old('umur') }}"
                            class="w-full px-4 py-3 border  rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('umur') border-danger @enderror"
                            placeholder="Contoh: 25">
                        @error('umur')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                            Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            required>
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis kelamin
                            </option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                </div>
                <!-- Ciri-Ciri Khusus -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Ciri-Ciri Khusus</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($characteristics as $characteristic)
                            <div>
                                <label for="ciri_ciri_{{ Str::snake($characteristic) }}"
                                    class="block text-xs text-gray-600 mb-1">
                                    {{ $characteristic }}
                                </label>
                                <input type="text" id="ciri_ciri_{{ Str::snake($characteristic) }}"
                                    name="ciri_ciri[{{ $characteristic }}]"
                                    value="{{ old('ciri_ciri.' . $characteristic) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                    placeholder="Masukkan: {{ strtolower($characteristic) }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                @include('dashboard.components.characteristics')

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

                @include('dashboard.components.contacts')

                <!-- Lokasi & Map -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Terakhir Dilihat</label>
                    <input type="text" id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat"
                        value="{{ old('lokasi_terakhir_dilihat') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">

                    @include('dashboard.components.maps')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly
                                value="{{ old('latitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly
                                value="{{ old('longitude') }}"
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition bg-gray-100 cursor-not-allowed">
                    </div>
                </div>

                <!-- Foto Upload -->
                @include('dashboard.components.photo')

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
        function removeField(button) {
            const field = button.closest('.flex');
            if (field) field.remove();
        }
    </script>
@endpush
