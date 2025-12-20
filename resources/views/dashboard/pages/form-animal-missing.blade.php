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
        @if (session('success'))
            <div id="toast-success"
                class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 duration-300 ease-in-out"
                role="alert">
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-success/500 bg-success/100 rounded-lg dark:bg-success/800 dark:text-success/200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('form-hewan-hilang.store') }}" method="POST" enctype="multipart/form-data"
                data-confirm-save>
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
                    <div class="w-full mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Hewan <span class="text-danger/500">*</span>
                        </label>

                        <div class="relative">
                            <select
                                class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
                                id="jenis_hewan_select">
                                <option value="">Pilih jenis hewan</option>
                                @foreach ($jenisHewan as $j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
                                stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </div>

                        <div class="mt-2">
                            <span class="text-sm text-gray-500">Tidak ada di daftar?</span>
                            <button type="button" id="tambah-jenis-btn"
                                class="text-primary font-medium hover:underline ml-1 text-sm">
                                + Tambah baru
                            </button>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="w-full mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span
                                class="text-danger/500">*</span></label>

                        <div class="relative">
                            <select
                                class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih jenis kelamin</option>
                                <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan
                                </option>
                                <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina
                                </option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
                                stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mb-6 hidden" id="input-jenis-baru">
                    <div class="space-y-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <input type="text" id="jenis_baru" placeholder="Ketik jenis baru..."
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                        <div class="flex gap-3">
                            <button type="button" id="simpan-jenis-baru"
                                class="bg-success text-white px-6 py-2 rounded-lg hover:bg-success/90 font-medium">Simpan</button>
                            <button type="button" id="batal-jenis-baru"
                                class="text-gray-600 px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Batal</button>
                        </div>
                    </div>

                    <input type="hidden" name="jenis_hewan" id="jenis_hewan_final" required>
                </div>

                <div class="mb-6" id="ras-container">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ras Hewan <span class="text-danger/500">*</span>
                    </label>

                    <!-- Hint awal -->
                    <p class="text-sm text-gray-500 mt-1 mb-3" id="ras-hint">
                        Pilih jenis hewan terlebih dahulu untuk mengaktifkan pilihan ras.
                    </p>

                    <div class="relative">
                        <select name="ras" id="ras_select"
                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer""
                            disabled>
                            <option value="">Pilih ras</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
                            stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                        </svg>
                    </div>

                    <div class="mt-2">
                        <span class="text-sm text-gray-500">Tidak ada di daftar?</span>
                        <button type="button" id="tambah-ras-btn"
                            class="text-primary font-medium hover:underline ml-1 text-sm" disabled>
                            + Tambah ras baru
                        </button>
                    </div>

                    <!-- Input tambah ras baru (mirip jenis hewan) -->
                    <div id="input-ras-baru-container" class="mb-6 hidden">
                        <div class="space-y-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <input type="text" id="ras_baru_input" placeholder="Ketik ras baru..."
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                            <div class="flex gap-3">
                                <button type="button" id="simpan-ras-baru-btn"
                                    class="bg-success text-white px-6 py-2 rounded-lg hover:bg-success/90 font-medium">
                                    Simpan Ras
                                </button>
                                <button type="button" id="batal-ras-baru-btn"
                                    class="text-gray-600 px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
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

                <!-- Timeline First Aid -->
                <div id="first-aid-container" class="mb-6 hidden">
                    <h3 class="text-lg font-bold text-accent/800 mb-3">
                        Langkah Pertolongan Pertama
                    </h3>

                    <ul id="first-aid-list" class="space-y-3 border-l-2 border-success pl-4">
                    </ul>
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

                <!-- Tombol Submit + Cek Duplikat -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end items-center mt-8">
                    <button type="submit"
                        class="px-10 py-4 bg-success text-secondary font-bold rounded-xl hover:bg-success/90 transition shadow-lg text-lg">
                        Kirim Laporan
                    </button>

                    <button type="button" id="check-duplicate-btn" data-type="hewan"
                        class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-secondary font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg flex items-center gap-3 text-lg">
                        Cek Duplikat Laporan
                    </button>
                </div>
            </form>
            <div id="duplicate-result" class="mt-6 hidden"></div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const rasHewan = @json($rasHewan);
        const firstAidSteps = @json($firstAidSteps);

        function renderFirstAid(jenis) {
            const container = document.getElementById('first-aid-container');
            const list = document.getElementById('first-aid-list');

            list.innerHTML = '';

            if (!jenis) {
                container.classList.add('hidden');
                return;
            }

            const steps = firstAidSteps[jenis] ?? firstAidSteps['Default'] ?? [];

            if (steps.length === 0) {
                container.classList.add('hidden');
                return;
            }

            steps.forEach((step, index) => {
                const li = document.createElement('li');
                li.className = 'relative pl-4';

                li.innerHTML = `
                    <span class="absolute -left-3 top-1 w-6 h-6 bg-success text-white rounded-full flex items-center justify-center text-sm">
                        ${index + 1}
                    </span>
                    <p class="text-gray-700">${step}</p>
                `;

                list.appendChild(li);
            });

            container.classList.remove('hidden');
        }


        document.getElementById('jenis_hewan_select').addEventListener('change', function() {
            const jenis = this.value;
            document.getElementById('jenis_hewan_final').value = jenis;
            updateRasSection(jenis);
            renderFirstAid(jenis);
        });

        function updateRasSection(jenis) {
            const rasSelect = document.getElementById('ras_select');
            const tambahRasBtn = document.getElementById('tambah-ras-btn');
            const inputContainer = document.getElementById('input-ras-baru-container');
            const hint = document.getElementById('ras-hint');

            rasSelect.innerHTML = '<option value="">Pilih ras</option>';
            $('#ras_select').prop('disabled', false).trigger('change.select2');
            tambahRasBtn.disabled = true;
            inputContainer.classList.add('hidden');

            if (hint) hint.style.display = jenis ? 'none' : 'block';
            if (!jenis) return;

            const punyaRas = rasHewan[jenis] && Array.isArray(rasHewan[jenis]) && rasHewan[jenis].length > 0;

            if (punyaRas) {
                rasSelect.disabled = false;
                tambahRasBtn.disabled = false;

                rasHewan[jenis].forEach(r => {
                    const opt = new Option(r, r);
                    if (r === "{{ old('ras') }}") opt.selected = true;
                    rasSelect.appendChild(opt);
                });
            } else {
                inputContainer.classList.remove('hidden');
            }
        }

        document.getElementById('tambah-ras-btn').onclick = () => {
            document.getElementById('input-ras-baru-container').classList.remove('hidden');
        };

        document.getElementById('batal-ras-baru-btn').onclick = () => {
            document.getElementById('input-ras-baru-container').classList.add('hidden');
            document.getElementById('ras_baru_input').value = '';
        };

        document.getElementById('simpan-ras-baru-btn').onclick = () => {
            const rasBaru = document.getElementById('ras_baru_input').value.trim();
            const jenis = document.getElementById('jenis_hewan_final').value || document.getElementById(
                'jenis_hewan_select').value;

            if (rasBaru.length < 2) return alert('Ras minimal 2 huruf!');
            if (!jenis) return alert('Pilih jenis hewan dulu!');

            fetch('{{ route('hewan.tambah-ras') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        jenis: jenis,
                        ras: rasBaru
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        const opt = new Option(rasBaru, rasBaru, true, true);
                        document.getElementById('ras_select').add(opt);
                        const rasSelect = document.getElementById('ras_select');
                        if (rasSelect.disabled) {
                            rasSelect.disabled = false;
                        }
                        document.getElementById('input-ras-baru-container').classList.add('hidden');
                        document.getElementById('ras_baru_input').value = '';

                        alert('Ras baru berhasil ditambahkan!');
                    } else {
                        alert(res.message || 'Gagal menambahkan ras');
                    }
                });
        };

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

                        updateRasSection(nama);
                        alert('Jenis baru ditambahkan!');
                    } else {
                        alert(res.message || 'Gagal menambahkan jenis');
                    }
                });
        };

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
