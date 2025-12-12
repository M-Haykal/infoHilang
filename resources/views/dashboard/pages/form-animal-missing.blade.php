@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Hewan Hilang | InfoHilang')

@section('content')
    <div class="space-y-6" data-page="form-animal-missing">
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Hewan <span class="text-red-500">*</span>
                        </label>

                        <select id="jenis_hewan_select"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary">
                            <option value="">Pilih jenis hewan</option>
                            @foreach ($jenisHewan as $j)
                                <option value="{{ $j }}">{{ $j }}</option>
                            @endforeach
                        </select>

                        <div class="mt-2">
                            <span class="text-sm text-gray-500">Tidak ada di daftar?</span>
                            <button type="button" id="tambah-jenis-btn"
                                class="text-primary font-medium hover:underline ml-1 text-sm">
                                + Tambah baru
                            </button>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span
                                class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" class="w-full px-4 py-3 border rounded-lg" required>
                            <option value="" disabled selected>Pilih jenis kelamin</option>
                            <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                            <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6 hidden" id="input-jenis-baru">
                    <div class="mt-3 space-y-2">
                        <input type="text" id="jenis_baru" placeholder="Ketik jenis baru..."
                            class="w-full px-1/2 px-4 py-2 border rounded-lg">
                        <div>
                            <button type="button" id="simpan-jenis-baru"
                                class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">Simpan</button>
                            <button>
                                <button type="button" id="batal-jenis-baru"
                                    class="ml-2 text-gray-600 text-sm">Batal</button>
                        </div>
                    </div>

                    <input type="hidden" name="jenis_hewan" id="jenis_hewan_final" required>
                </div>

                <!-- Ras Hewan -->
                <div class="mb-6" id="ras-container" style="display: none;">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ras Hewan <span class="text-red-500">*</span>
                    </label>

                    <select name="ras" id="ras_select" class="w-full px-4 py-3 border rounded-lg">
                        <option value="">Pilih ras</option>
                    </select>

                    <div class="mt-2">
                        <span class="text-sm text-gray-500">Tidak ada di daftar?</span>
                        <button type="button" id="tambah-ras-btn"
                            class="text-primary font-medium hover:underline ml-1 text-sm">
                            + Tambah ras baru
                        </button>
                    </div>

                    <div id="input-ras-baru" class="mt-3 hidden space-y-2">
                        <input type="text" id="ras_baru" placeholder="Ketik ras baru..."
                            class="w-full px-4 py-2 border rounded-lg">
                        <div>
                            <button type="button" id="simpan-ras-baru"
                                class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">Simpan</button>
                            <button type="button" id="batal-ras-baru" class="ml-2 text-gray-600 text-sm">Batal</button>
                        </div>
                    </div>
                </div>

                <!-- Ras Manual (untuk jenis tanpa ras) -->
                <div class="mb-6 hidden" id="ras-manual-container">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ras Hewan (Ketik Manual) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ras" id="ras_manual" value="{{ old('ras') }}"
                        class="w-full px-4 py-3 border rounded-lg" placeholder="Contoh: Campuran">
                </div>

                <!-- Umur dan Warna -->
                <div class="grid grid-cols-2 gap-4 mb-6">
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
                <div class="mb-6 map-container">
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
                            <label for="longitude"
                                class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly
                                value="{{ old('longitude') }}"
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


                <!-- Tombol Submit + Cek Duplikat -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8">
                    <button type="submit"
                        class="px-10 py-4 bg-success text-white font-bold rounded-xl hover:bg-success/90 transition shadow-lg text-lg">
                        Kirim Laporan
                    </button>

                    <button type="button" id="check-duplicate-btn" data-type="hewan"
                        class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg flex items-center gap-3 text-lg">
                        Cek Duplikat dengan AI
                    </button>
                </div>
            </form>
            <div id="duplicate-result" class="mt-6 hidden"></div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const rasHewan = @json($rasHewan); // dari race_animal.json

        // Update hidden field jenis
        document.getElementById('jenis_hewan_select').addEventListener('change', function() {
            const jenis = this.value;
            document.getElementById('jenis_hewan_final').value = jenis;
            updateRasSection(jenis);
        });

        // Fungsi utama update ras
        function updateRasSection(jenis) {
            const rasContainer = document.getElementById('ras-container');
            const rasManual = document.getElementById('ras-manual-container');
            const rasSelect = document.getElementById('ras_select');

            // Reset
            rasContainer.style.display = 'none';
            rasManual.classList.add('hidden');
            rasSelect.innerHTML = '<option value="">Pilih ras</option>';

            if (!jenis) return;

            const punyaRas = rasHewan[jenis] && Array.isArray(rasHewan[jenis]) && rasHewan[jenis].length > 0;

            if (punyaRas) {
                rasContainer.style.display = 'block';
                rasHewan[jenis].forEach(r => {
                    const opt = new Option(r, r);
                    if (r === "{{ old('ras') }}") opt.selected = true;
                    rasSelect.appendChild(opt);
                });
            } else {
                rasManual.classList.remove('hidden');
            }
        }

        // === TAMBAH JENIS BARU ===
        document.getElementById('tambah-jenis-btn').onclick = () => {
            document.getElementById('input-jenis-baru').classList.remove('hidden');
            document.getElementById('jenis_hewan_select').disabled = true;
        };

        document.getElementById('batal-jenis-baru').onclick = () => {
            document.getElementById('input-jenis-baru').classList.add('hidden');
            document.getElementById('jenis_hewan_select').disabled = false;
            document.getElementById('jenis_baru').value = '';
        };

        document.getElementById('simpan-jenis-baru').onclick = () => {
            const nama = document.getElementById('jenis_baru').value.trim();
            if (nama.length < 2) return alert('Minimal 2 huruf!');

            fetch('{{ route('hewan.tambah-jenis') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        jenis: nama
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        const opt = new Option(nama, nama, true, true);
                        document.getElementById('jenis_hewan_select').add(opt);
                        document.getElementById('jenis_hewan_final').value = nama;

                        document.getElementById('input-jenis-baru').classList.add('hidden');
                        document.getElementById('jenis_hewan_select').disabled = false;
                        document.getElementById('jenis_baru').value = '';

                        updateRasSection(nama); // otomatis muncul input manual ras
                        alert('Jenis baru ditambahkan!');
                    }
                });
        };

        // === TAMBAH RAS BARU ===
        document.getElementById('tambah-ras-btn').onclick = () => {
            document.getElementById('input-ras-baru').classList.remove('hidden');
        };

        document.getElementById('batal-ras-baru').onclick = () => {
            document.getElementById('input-ras-baru').classList.add('hidden');
            document.getElementById('ras_baru').value = '';
        };

        document.getElementById('simpan-ras-baru').onclick = () => {
            const ras = document.getElementById('ras_baru').value.trim();
            const jenis = document.getElementById('jenis_hewan_select').value;

            if (ras.length < 2) return alert('Minimal 2 huruf!');
            if (!jenis) return alert('Pilih jenis hewan dulu!');

            fetch('{{ route('hewan.tambah-ras') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        jenis: jenis,
                        ras: ras
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        // Tambah ke dropdown
                        const opt = new Option(ras, ras, true, true);
                        document.getElementById('ras_select').add(opt);

                        document.getElementById('input-ras-baru').classList.add('hidden');
                        document.getElementById('ras_baru').value = '';
                        alert('Ras "' + ras + '" berhasil ditambahkan!');
                    } else {
                        alert(res.message || 'Gagal menambah ras');
                    }
                });
        };

        // Old input support
        document.addEventListener('DOMContentLoaded', () => {
            const oldJenis = "{{ old('jenis_hewan') }}";
            if (oldJenis) {
                document.getElementById('jenis_hewan_select').value = oldJenis;
                document.getElementById('jenis_hewan_final').value = oldJenis;
                updateRasSection(oldJenis);
            }
        });
    </script>
@endpush
