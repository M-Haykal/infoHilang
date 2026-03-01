@extends('dashboard.layouts.index')

@section('title', 'Edit Laporan Hewan Hilang | InfoHilang')

@section('content')
<div class="space-y-6" data-page="form-animal-missing-edit">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">

        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Edit Laporan Hewan Hilang</h1>
            <nav class="flex justify-center lg:justify-start mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-xs font-medium text-netral-400">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li>
                        <a href="{{ route('missing') }}" class="hover:text-primary transition-colors">Hewan Hilang</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li class="text-primary font-bold italic">Edit Laporan</li>
                </ol>
            </nav>
        </div>

        <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-20 pointer-events-auto">
            <a href="{{ route('missing') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-netral-500 border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-dark hover:border-dark hover:shadow-md transition-all group active:scale-95">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('form-hewan-hilang.update', $hewanHilang->slug) }}" method="POST" enctype="multipart/form-data" data-confirm-save class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <!-- Informasi Dasar Hewan -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-paw mr-2 text-primary"></i>
                    Informasi Dasar
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Nama Hewan -->
                    <div>
                        <label for="nama_hewan" class="block text-sm font-semibold text-dark mb-2">Nama
                            Hewan</label>
                        <input type="text" id="nama_hewan" name="nama_hewan" value="{{ old('nama_hewan', $hewanHilang->nama_hewan) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('nama_hewan') border-danger @enderror" placeholder="Masukan nama hewan" required>
                        @error('nama_hewan')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-2">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="relative">
                            <select name="jenis_kelamin" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none appearance-none cursor-pointer">
                                <option value="" disabled>Pilih jenis kelamin</option>
                                <option value="Jantan" {{ old('jenis_kelamin', $hewanHilang->jenis_kelamin) == 'Jantan' ? 'selected' : '' }}>
                                    Jantan
                                </option>
                                <option value="Betina" {{ old('jenis_kelamin', $hewanHilang->jenis_kelamin) == 'Betina' ? 'selected' : '' }}>
                                    Betina
                                </option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Hewan -->
                <div class="mt-6">
                    <label for="deskripsi_hewan" class="block text-sm font-semibold text-dark mb-2">Deskripsi
                        Hewan</label>
                    <textarea id="deskripsi_hewan" name="deskripsi_hewan" rows="3" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('deskripsi_hewan') border-danger @enderror" placeholder="Contoh: warna bulu, ciri khas, dll.">{{ old('deskripsi_hewan', strip_tags($hewanHilang->deskripsi_hewan)) }}</textarea>
                    @error('deskripsi_hewan')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            <!-- Jenis dan Ras Hewan -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-message mr-2 text-primary"></i>
                    Jenis dan Ras Hewan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Jenis Hewan - DISABLED -->
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-2">
                            Jenis Hewan <span class="text-danger">*</span>
                        </label>

                        <div class="relative">
                            <select id="jenis_hewan_select" name="jenis_hewan" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none appearance-none cursor-not-allowed" disabled>
                                <option value="">Pilih jenis hewan</option>
                                @foreach ($jenisHewan as $j)
                                <option value="{{ $j }}" {{ old('jenis_hewan', $hewanHilang->jenis_hewan) == $j ? 'selected' : '' }}>
                                    {{ $j }}</option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </div>

                        <input type="hidden" name="jenis_hewan" value="{{ old('jenis_hewan', $hewanHilang->jenis_hewan) }}">
                    </div>

                    <!-- Ras Hewan - DISABLED -->
                    <div>
                        <label class="block text-sm font-semibold text-dark mb-2">
                            Ras Hewan <span class="text-danger">*</span>
                        </label>

                        <div class="relative">
                            <select name="ras" id="ras_select" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none appearance-none cursor-not-allowed" disabled>
                                <option value="">Pilih ras</option>
                                @if (isset($rasHewan[$hewanHilang->jenis_hewan]))
                                @foreach ($rasHewan[$hewanHilang->jenis_hewan] as $r)
                                <option value="{{ $r }}" {{ old('ras', $hewanHilang->ras) == $r ? 'selected' : '' }}>
                                    {{ $r }}</option>
                                @endforeach
                                @endif
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="h-5 w-5 ml-1 absolute top-3.5 right-2.5 text-slate-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </div>

                        <input type="hidden" name="ras" value="{{ old('ras', $hewanHilang->ras) }}">
                    </div>
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            <!-- Detail Fisik Hewan -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-file-lines mr-2 text-primary"></i>
                    Detail Fisik Hewan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Umur -->
                    <div>
                        <label for="umur" class="block text-sm font-semibold text-dark mb-2">Umur</label>
                        <div class="relative">
                            <input type="text" id="umur" name="umur" value="{{ old('umur', $hewanHilang->umur) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('umur') border-danger @enderror" placeholder="Contoh: 5">
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
                        <label for="warna" class="block text-sm font-semibold text-dark mb-2">Warna</label>
                        <input type="text" id="warna" name="warna" value="{{ old('warna', $hewanHilang->warna) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('warna') border-danger @enderror" placeholder="Contoh: hitam, putih, dll.">
                        @error('warna')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Ciri-Ciri -->
                @include('dashboard.components.characteristics', [
                'ciriCiri' => $hewanHilang->ciri_ciri ?? [],
                ])

                <!-- Timeline First Aid -->
                <div id="first-aid-container" class="mt-6 hidden">
                    <div class="bg-light/50 rounded-lg p-4 border border-success/100">
                        <h3 class="text-lg font-bold text-success/800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-success/600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
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
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-location-dot mr-2 text-primary"></i>
                    Kontak & Lokasi
                </h3>

                @include('dashboard.components.contacts', ['kontak' => $hewanHilang->kontak ?? []])

                <!-- Lokasi -->
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-dark mb-2">Lokasi Terakhir Dilihat</label>
                    <textarea id="lokasi_terakhir_dilihat" name="lokasi_terakhir_dilihat" rows="3" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Contoh: Stasiun Gambir, Jakarta Pusat">{{ old('lokasi_terakhir_dilihat', strip_tags($hewanHilang->lokasi_terakhir_dilihat)) }}</textarea>

                    @include('dashboard.components.maps', [
                    'latitude' => old('latitude', $hewanHilang->latitude),
                    'longitude' => old('longitude', $hewanHilang->longitude),
                    ])

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 mb-2">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-dark mb-2">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly value="{{ old('latitude', $hewanHilang->latitude) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-dark mb-2">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly value="{{ old('longitude', $hewanHilang->longitude) }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                        </div>
                    </div>

                    <div class="bg-accent-surface border border-accent rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-circle-exclamation text-accent"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-accent">Tips Pelaporan</h3>
                                <p class="text-sm text-accent mt-1">
                                    Foto kualitas tinggi sangat membantu. Hindari foto buram, gelap, atau terlalu jauh.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="tanggal_terakhir_dilihat" class="block text-sm font-semibold text-dark mb-2">
                            Tanggal Terakhir Dilihat
                        </label>
                        <input type="datetime-local" id="tanggal_terakhir_dilihat" name="tanggal_terakhir_dilihat" value="{{ old('tanggal_terakhir_dilihat', $hewanHilang->tanggal_terakhir_dilihat ? \Carbon\Carbon::parse($hewanHilang->tanggal_terakhir_dilihat)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-dark mb-2">Status
                            Laporan</label>
                        <input type="text" id="status" name="status" value="{{ old('status', $hewanHilang->status) }}" readonly class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-netral-200 text-sm text-netral-500 transition-all outline-none cursor-not-allowed">
                    </div>
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            <!-- Foto & Submit -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-dark mb-4 flex items-center">
                    <i class="fa-solid fa-image mr-2 text-primary"></i>
                    Foto & Submit
                </h3>

                <!-- Foto Upload -->
                @include('dashboard.components.photo', ['foto' => $hewanHilang->foto ?? []])

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end items-center mt-8">
                    <a href="{{ route('missing') }}" class="px-6 py-3 text-lg font-semibold text-netral-500">Batal</a>
                    <button type="submit" class="px-10 py-4 bg-primary text-white text-lg font-bold rounded-xl hover:bg-primary-dark hover:shadow-primary hover:-translate-y-0.5 transition-all shadow-lg flex items-center justify-center group active:scale-95">
                        <i class="fa-regular fa-circle-check mr-2"></i>
                        Perbarui Laporan
                    </button>
                </div>
            </div>
        </form>
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

        const steps = firstAidSteps[jenis] ? ? firstAidSteps['Default'] ? ? [];

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
                    <p class="text-dark">${step}</p>
                `;

            list.appendChild(li);
        });

        container.classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const jenis = "{{ $hewanHilang->jenis_hewan }}";
        renderFirstAid(jenis);
    });

</script>
@endpush
