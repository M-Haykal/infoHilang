@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Hewan Hilang | InfoHilang')

@section('content')
    <div class="space-y-6" data-page="form-animal-missing">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Form Laporan Hewan Hilang</h1>
            <p class="text-gray-600 max-w-2xl mx-auto mt-2">Lengkapi informasi laporan hewan hilang di bawah ini dengan
                teliti</p>
        </header>

        <!-- Form Container -->
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up"
            data-aos-delay="100">
            <form action="{{ route('form-hewan-hilang.store') }}" method="POST" enctype="multipart/form-data"
                data-confirm-save class="p-6 sm:p-8">
                @csrf

                <!-- Informasi Dasar Hewan -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-paw mr-2 text-primary"></i>
                        Informasi Dasar Hewan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Hewan -->
                        <div>
                            <label for="nama_hewan" class="block text-sm font-semibold text-gray-700 mb-2">Nama
                                Hewan</label>
                            <input type="text" id="nama_hewan" name="nama_hewan" value="{{ old('nama_hewan') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('nama_hewan') border-danger @enderror"
                                placeholder="Masukan nama hewan" required>
                            @error('nama_hewan')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span
                                    class="text-danger/500">*</span></label>
                            <div class="relative">
                                <select name="jenis_kelamin"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-3 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih jenis kelamin</option>
                                    <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan
                                    </option>
                                    <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina
                                    </option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.2" stroke="currentColor"
                                    class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Hewan -->
                    <div class="mt-6">
                        <label for="deskripsi_hewan" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                            Hewan</label>
                        <textarea id="deskripsi_hewan" name="deskripsi_hewan" rows="3"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('deskripsi_hewan') border-danger @enderror"
                            placeholder="Contoh: warna bulu, ciri khas, dll.">{{ old('deskripsi_hewan') }}</textarea>
                        @error('deskripsi_hewan')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Jenis dan Ras Hewan -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-message mr-2 text-primary"></i>
                        Jenis dan Ras Hewan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Hewan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Hewan <span class="text-danger/500">*</span>
                            </label>

                            <div class="relative">
                                <select id="jenis_hewan_select" name="jenis_hewan"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-3 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                                    <option value="">Pilih jenis hewan</option>
                                    @foreach ($jenisHewan as $j)
                                        <option value="{{ $j }}"
                                            {{ old('jenis_hewan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.2" stroke="currentColor"
                                    class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
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

                        <!-- Ras Hewan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Ras Hewan <span class="text-danger/500">*</span>
                            </label>

                            <div class="relative">
                                <select name="ras" id="ras_select"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-3 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer disabled:opacity-50"
                                    disabled>
                                    <option value="">Pilih jenis hewan terlebih dahulu</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.2" stroke="currentColor"
                                    class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
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
                        </div>
                    </div>

                    <!-- Input Jenis Baru -->
                    <div id="input-jenis-baru" class="mt-4 hidden">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-medium text-blue-800">Tambah Jenis Hewan Baru</span>
                            </div>
                            <div class="flex gap-3">
                                <input type="text" id="jenis_baru" placeholder="Ketik jenis baru..."
                                    class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                                <button type="button" id="simpan-jenis-baru"
                                    class="bg-success text-white px-4 py-2 rounded-lg hover:bg-success/90 font-medium">Simpan</button>
                                <button type="button" id="batal-jenis-baru"
                                    class="text-gray-600 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Batal</button>
                            </div>
                        </div>
                    </div>

                    <!-- Input Ras Baru -->
                    <div id="input-ras-baru-container" class="mt-4 hidden">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-medium text-blue-800">Tambah Ras Hewan Baru</span>
                            </div>
                            <div class="flex gap-3">
                                <input type="text" id="ras_baru_input" placeholder="Ketik ras baru..."
                                    class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                                <button type="button" id="simpan-ras-baru-btn"
                                    class="bg-success text-white px-4 py-2 rounded-lg hover:bg-success/90 font-medium">Simpan</button>
                                <button type="button" id="batal-ras-baru-btn"
                                    class="text-gray-600 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Detail Fisik Hewan -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-file-lines mr-2 text-primary"></i>
                        Detail Fisik Hewan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Umur -->
                        <div>
                            <label for="umur" class="block text-sm font-semibold text-gray-700 mb-2">Umur</label>
                            <div class="relative">
                                <input type="text" id="umur" name="umur" value="{{ old('umur') }}"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('umur') border-danger @enderror"
                                    placeholder="Contoh: 5">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                    <span class="text-sm">Tahun</span>
                                </div>
                            </div>
                            @error('umur')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Warna -->
                        <div>
                            <label for="warna" class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
                            <input type="text" id="warna" name="warna" value="{{ old('warna') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('warna') border-danger @enderror"
                                placeholder="Contoh: hitam, putih, dll.">
                            @error('warna')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Ciri-Ciri -->
                    @include('dashboard.components.characteristics', ['ciriCiri' => []])

                    <!-- Timeline First Aid -->
                    <div id="first-aid-container" class="mt-6 hidden">
                        <div class="bg-light/50 rounded-lg p-4 border border-success/100">
                            <h3 class="text-lg font-bold text-success/800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-success/600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Langkah Pertolongan Pertama
                            </h3>
                            <ul id="first-aid-list" class="space-y-3 border-l-2 border-success/300 pl-4">
                            </ul>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Kontak & Lokasi -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-location-dot mr-2 text-primary"></i>
                        Kontak & Lokasi
                    </h3>

                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Kontak Darurat</label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($contacts as $contact)
                                <div>
                                    <label for="kontak_{{ Str::snake($contact) }}"
                                        class="block text-xs text-gray-600 mb-1">
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

                    <!-- Kontak Darurat -->
                    @include('dashboard.components.contacts', ['kontak' => []])

                    <!-- Lokasi -->
                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Terakhir Dilihat</label>
                        <textarea id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">{{ old('lokasi_terakhir_dilihat') }}</textarea>

                        @include('dashboard.components.maps')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="latitude"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                                <input type="text" id="latitude" name="latitude" readonly
                                    value="{{ old('latitude') }}"
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

                        <div class="bg-primary/50 border border-primary/200 rounded-lg p-4 mt-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-primary/500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-primary/800">Tips Pelaporan</h3>
                                    <p class="text-sm text-primary/700 mt-1">
                                        Koordinat peta akan otomatis terisi saat Anda klik lokasi di peta.
                                        Semakin akurat lokasi, semakin cepat proses pencarian.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
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
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Foto & Submit -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-image mr-2 text-primary"></i>
                        Foto & Submit
                    </h3>

                    <!-- Foto Upload -->
                    @include('dashboard.components.photo', ['foto' ?? []])

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-end items-center mt-8">
                        <button type="submit"
                            class="px-10 py-4 bg-success text-white font-bold rounded-xl hover:bg-success/90 transition shadow-lg text-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Kirim Laporan
                        </button>

                        <button type="button" id="check-duplicate-btn" data-type="hewan"
                            class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg flex items-center justify-center text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                            Cek Duplikat Laporan
                        </button>
                    </div>
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
            updateRasSection(jenis);
            renderFirstAid(jenis);
        });

        function updateRasSection(jenis) {
            const rasSelect = document.getElementById('ras_select');
            const tambahRasBtn = document.getElementById('tambah-ras-btn');
            const inputContainer = document.getElementById('input-ras-baru-container');

            rasSelect.innerHTML = '<option value="">Pilih ras</option>';
            rasSelect.disabled = true;
            tambahRasBtn.disabled = true;
            inputContainer.classList.add('hidden');

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
            const jenis = document.getElementById('jenis_hewan_select').value;

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
                        document.getElementById('jenis_hewan_select').disabled = false;
                        document.getElementById('input-jenis-baru').classList.add('hidden');
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
                updateRasSection(oldJenis);
                renderFirstAid(oldJenis);
            }
        });
    </script>
@endpush
