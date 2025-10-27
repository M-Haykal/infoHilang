@extends('dashboard.layouts.index')

@section('title', 'Edit Laporan Orang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Edit Laporan Orang Hilang</h1>
            <p class="text-gray-600">Perbarui informasi laporan orang yang hilang di bawah ini</p>
        </header>

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('form-orang-hilang.update', $orangHilang->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Orang -->
                <div class="mb-6">
                    <label for="nama_orang" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama_orang" name="nama_orang"
                        value="{{ old('nama_orang', $orangHilang->nama_orang) }}"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Masukkan nama lengkap orang yang hilang" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="deskripsi_orang" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                        Fisik</label>
                    <textarea id="deskripsi_orang" name="deskripsi_orang" rows="4"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Contoh: tinggi 165 cm, rambut hitam, dll.">{{ old('deskripsi_orang', $orangHilang->deskripsi_orang) }}</textarea>
                </div>

                <!-- Umur dan Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="umur" class="block text-sm font-semibold text-gray-700 mb-2">Umur</label>
                        <input type="number" id="umur" name="umur" value="{{ old('umur', $orangHilang->umur) }}"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                            Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="Laki-laki"
                                {{ old('jenis_kelamin', $orangHilang->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan"
                                {{ old('jenis_kelamin', $orangHilang->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Ciri-Ciri -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Ciri-Ciri Khusus Lainnya</label>
                    <div id="ciriCiriContainer" class="space-y-3">
                        @foreach ($orangHilang->ciri_ciri ?? [] as $key => $value)
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" name="ciri_ciri_keys[]" value="{{ $key }}"
                                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <input type="text" name="ciri_ciri_values[]" value="{{ $value }}"
                                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                                    onclick="removeField(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addCiriCiriField()">
                        + Tambah Ciri-Ciri
                    </button>
                </div>

                <!-- Kontak -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Kontak Darurat Lainnya</label>
                    <div id="kontakContainer" class="space-y-3">
                        @foreach ($orangHilang->kontak ?? [] as $key => $value)
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" name="kontak_keys[]" value="{{ $key }}"
                                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <input type="text" name="kontak_values[]" value="{{ $value }}"
                                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                                    onclick="removeField(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addKontakField()">
                        + Tambah Kontak
                    </button>
                </div>

                <!-- Lokasi -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Terakhir Dilihat</label>
                    <input type="text" id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat"
                        value="{{ old('lokasi_terakhir_dilihat', $orangHilang->lokasi_terakhir_dilihat) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">

                    <!-- Map -->
                    @include('dashboard.components.maps')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly
                                value="{{ old('latitude', $orangHilang->latitude) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly
                                value="{{ old('longitude', $orangHilang->longitude) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Tanggal & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_terakhir_dilihat"
                            class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Terakhir Dilihat</label>
                        <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat"
                            value="{{ old('tanggal_terakhir_dilihat', $orangHilang->tanggal_terakhir_dilihat ? \Carbon\Carbon::parse($orangHilang->tanggal_terakhir_dilihat)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                            <option value="Hilang" {{ $orangHilang->status == 'Hilang' ? 'selected' : '' }}>Hilang
                            </option>
                            <option value="Ditemukan" {{ $orangHilang->status == 'Ditemukan' ? 'selected' : '' }}>
                                Ditemukan</option>
                            <option value="Ditutup" {{ $orangHilang->status == 'Ditutup' ? 'selected' : '' }}>Ditutup
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Foto -->
                <div class="mb-6">
                    <label for="imageInput" class="block text-sm font-semibold text-gray-700 mb-2">Foto (Opsional)</label>
                    <input type="file" id="imageInput" name="foto[]" accept="image/*" multiple
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Maksimal 5 foto. Format: JPG, PNG, GIF.</p>

                    <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                        @foreach ($orangHilang->foto ?? [] as $foto)
                            <div class="relative group rounded-lg overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto"
                                    class="w-full h-32 object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{ $orangHilang->user_id }}">

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit"
                        class="inline-block px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary/80 focus:outline-none focus:ring-4 focus:ring-primary/30 transition transform hover:scale-105">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function removeField(button) {
            const field = button.closest('.flex');
            if (field) field.remove();
        }

        function addCiriCiriField() {
            const container = document.getElementById('ciriCiriContainer');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
                <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                    onclick="removeField(this)">Hapus</button>`;
            container.appendChild(div);
        }

        function addKontakField() {
            const container = document.getElementById('kontakContainer');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
                <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                    onclick="removeField(this)">Hapus</button>`;
            container.appendChild(div);
        }
    </script>
@endpush
