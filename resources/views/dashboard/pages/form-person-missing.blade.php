@extends('dashboard.layouts.index')

@section('title', 'Form Laporan Orang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6" data-page="form-person-missing">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Laporan Orang Hilang</h1>
            <p class="text-gray-600 max-w-2xl mx-auto mt-2">Isi formulir di bawah ini untuk melaporkan kehilangan orang
                dengan lengkap dan teliti</p>
        </header>

        <!-- Error Message -->
        @if ($errors->has('duplicate'))
            <div class="max-w-5xl mx-auto">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Laporan Ditolak!</h3>
                            <div class="mt-2 text-sm text-red-700">
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Dasar
                    </h3>

                    <!-- Nama Orang -->
                    <div class="mb-6">
                        <label for="nama_orang" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_orang" name="nama_orang" value="{{ old('nama_orang') }}"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('nama_orang') border-danger @enderror"
                            placeholder="Masukkan nama lengkap orang yang hilang" required>
                        @error('nama_orang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Orang -->
                    <div class="mb-6">
                        <label for="deskripsi_orang" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi
                            Fisik</label>
                        <textarea id="deskripsi_orang" name="deskripsi_orang" rows="3"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('deskripsi_orang') border-danger @enderror"
                            placeholder="Contoh: Tinggi 165 cm, berat 60 kg, rambut hitam lurus, dll.">{{ old('deskripsi_orang') }}</textarea>
                        @error('deskripsi_orang')
                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Umur & Jenis Kelamin -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="umur" class="block text-sm font-semibold text-gray-700 mb-2">Umur</label>
                            <div class="relative">
                                <input type="number" id="umur" name="umur" value="{{ old('umur') }}"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition @error('umur') border-danger @enderror"
                                    placeholder="Contoh: 25">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                    <span class="text-sm">tahun</span>
                                </div>
                            </div>
                            @error('umur')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-2">Jenis
                                Kelamin</label>
                            <div class="relative">
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-3 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
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
                                    class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <!-- Ciri-Ciri Khusus -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Ciri-Ciri Khusus
                    </h3>

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

                <hr class="my-8 border-gray-200">

                <!-- Kontak Darurat -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Kontak Darurat
                    </h3>

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

                <hr class="my-8 border-gray-200">

                <!-- Lokasi & Tanggal -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi & Waktu
                    </h3>

                    <!-- Lokasi -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Terakhir Dilihat</label>
                        <textarea id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                            placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">{{ old('lokasi_terakhir_dilihat') }}</textarea>

                        @include('dashboard.components.maps')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
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

                    <!-- Tanggal & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Foto & Submit
                    </h3>

                    <!-- Foto Upload -->
                    @include('dashboard.components.photo', ['foto' ?? []])

                    <!-- Hidden User ID -->
                    <input type="hidden" name="user_id" value="{{ $userId }}">

                    <!-- Submit Button + Cek Duplikat -->
                    <div class="flex flex-col sm:flex-row gap-5 justify-end items-center mt-8">
                        <button type="submit"
                            class="px-10 py-4 bg-success text-white font-bold rounded-xl hover:bg-success/90 transition shadow-lg text-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Kirim Laporan
                        </button>

                        <button type="button" id="check-duplicate-btn" data-type="orang"
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
            <div id="duplicate-result" class="mt-8 hidden"></div>
        </div>
    </div>
@endsection
