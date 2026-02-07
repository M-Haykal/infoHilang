@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Orang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6" data-page="form-person-missing">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-dark">Laporan Orang Hilang</h1>
            <p class="text-netral-500 max-w-2xl mx-auto mt-2">Isi formulir di bawah ini untuk melaporkan kehilangan orang
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
                            <h3 class="text-sm font-bold text-white">Laporan Ditolak!</h3>
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
            <form action="{{ route('form-orang-hilang.store') }}" method="POST" enctype="multipart/form-data"
                data-confirm-save class="p-6 sm:p-8">
                @csrf

                <!-- Informasi Dasar -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                        <i class="fa-solid fa-user mr-2 text-primary"></i>
                        Informasi Dasar
                    </h3>

                    <!-- Nama Orang -->
                    <div class="mb-6">
                        <label for="nama_orang" class="block text-sm font-semibold text-dark mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_orang" name="nama_orang" value="{{ old('nama_orang') }}"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('nama_orang') border-danger @enderror"
                            placeholder="Masukkan nama lengkap orang yang hilang" required>
                        @error('nama_orang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Orang -->
                    <div class="mb-6">
                        <label for="deskripsi_orang" class="block text-sm font-semibold text-dark mb-2">Deskripsi
                            Fisik</label>
                        <textarea id="deskripsi_orang" name="deskripsi_orang" rows="3"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('deskripsi_orang') border-danger @enderror"
                            placeholder="Contoh: Tinggi 165 cm, berat 60 kg, rambut hitam lurus, dll.">{{ old('deskripsi_orang') }}</textarea>
                        @error('deskripsi_orang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Umur & Jenis Kelamin -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="mb-5 sm:mb-0">
                            <label for="umur" class="block text-sm font-semibold text-dark mb-2">Umur</label>
                            <div class="relative">
                                <input type="number" id="umur" name="umur" value="{{ old('umur') }}"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none appearance-none no-scrollbar @error('umur') border-danger @enderror"
                                    placeholder="Contoh: 25">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-netral-500">
                                    <span class="text-sm">tahun</span>
                                </div>
                            </div>
                            @error('umur')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-semibold text-dark mb-2">Jenis
                                Kelamin</label>
                            <div class="relative">
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none appearance-none cursor-pointer"
                                    required>
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis
                                        kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.2" stroke="currentColor"
                                    class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-netral-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-netral-200">

                <!-- Ciri-Ciri Khusus -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                        <i class="fa-solid fa-message mr-2 text-primary"></i>
                        Ciri-Ciri Khusus
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach ($characteristics as $characteristic)
                            <div class="mb-2">
                                <label for="ciri_ciri_{{ Str::snake($characteristic) }}"
                                    class="block text-xs text-dark mb-1">
                                    {{ $characteristic }}
                                </label>
                                <input type="text" id="ciri_ciri_{{ Str::snake($characteristic) }}"
                                    name="ciri_ciri[{{ $characteristic }}]"
                                    value="{{ old('ciri_ciri.' . $characteristic) }}"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                                    placeholder="Masukkan {{ $characteristic }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                @include('dashboard.components.characteristics', ['ciriCiri' => old('ciri_ciri', [])])

                <hr class="my-8 border-netral-200">

                <!-- Kontak Darurat -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                        <i class="fa-solid fa-phone mr-2 text-primary"></i>
                        Kontak Darurat
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
                        @foreach ($contacts as $contact)
                            <div class="flex-1 mb-2">
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
                </div>

                @include('dashboard.components.contacts', ['kontak' => old('kontak', [])])

                <hr class="my-8 border-netral-200">

                <!-- Lokasi & Tanggal -->
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

                <!-- Foto & Submit -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                        <i class="fa-solid fa-image mr-2 text-primary"></i>
                        Foto & Submit
                    </h3>

                    <!-- Foto Upload -->
                    @include('dashboard.components.photo', ['foto' ?? []])

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
