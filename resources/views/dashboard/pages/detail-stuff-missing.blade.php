@extends('dashboard.layouts.index')

@section('title', 'Detail Laporan Orang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">{{ $barangHilang->nama_barang }}</h1>
            <p class="text-gray-600 mt-1">
                Dilaporkan hilang sejak
                {{ date('d M Y H:i', strtotime($barangHilang->tanggal_terakhir_dilihat)) }}
            </p>
            <span
                class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full
                    @if ($barangHilang->status === 'Hilang') bg-danger text-secondary
                    @elseif($barangHilang->status === 'Ditemukan') bg-success text-secondary
                    @else bg-gray-100 text-gray-800 @endif">
                {{ $barangHilang->status }}
            </span>
        </header>

        <!-- Foto Gallery -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-4" data-aos="fade-up">
            @if ($barangHilang->foto && count($barangHilang->foto) > 0)
                <div x-data="{ activeImage: '{{ asset('storage/' . $barangHilang->foto[0]) }}' }" class="space-y-4">
                    <!-- Preview Besar -->
                    <div class="w-full h-64 sm:h-80 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                        <img :src="activeImage" alt="Foto Preview"
                            class="object-cover w-full h-full transition-all duration-300 hover:scale-[1.02]">
                    </div>

                    <!-- Thumbnail -->
                    <div class="flex gap-3 justify-center flex-wrap">
                        @foreach ($barangHilang->foto as $foto)
                            <img src="{{ asset('storage/' . $foto) }}" alt="Thumbnail {{ $loop->iteration }}"
                                @click="activeImage = '{{ asset('storage/' . $foto) }}'"
                                class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition
                                hover:scale-105 hover:border-primary"
                                :class="{ 'border-primary ring-2 ring-blue-300': activeImage === '{{ asset('storage/' . $foto) }}' }">
                        @endforeach
                    </div>
                </div>
            @else
                <div class="w-full h-64 sm:h-80 bg-gray-100 flex items-center justify-center">
                    <span class="text-gray-400">Tidak ada foto</span>
                </div>
            @endif
        </div>


        <!-- Info Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="100">
            <!-- Data Pribadi -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Barang</h2>
                <ul class="space-y-3 text-sm text-gray-700">
                    <li class="flex justify-between">
                        <span class="font-medium">Jenis Barang:</span>
                        <span>{{ $barangHilang->jenis_barang }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="font-medium">Merk Barang:</span>
                        <span>{{ $barangHilang->merk_barang }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="font-medium">Warna Barang:</span>
                        <span>{{ $barangHilang->warna_barang }}</span>
                    </li>
                    <li>
                        <span class="font-medium block mb-1">Deskripsi Barang:</span>
                        <p class="text-gray-600">{{ $barangHilang->deskripsi_barang ?: '–' }}</p>
                    </li>
                </ul>
            </div>

            <!-- Ciri-Ciri & Kontak -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="font-semibold text-gray-800 mb-3">Ciri-Ciri Khusus</h2>
                    @if ($barangHilang->ciri_ciri && count($barangHilang->ciri_ciri) > 0)
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach ($barangHilang->ciri_ciri as $key => $value)
                                <li><span class="font-medium">{{ $key }}:</span> {{ $value }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm">Tidak ada ciri khusus.</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h2 class="font-semibold text-gray-800 mb-3">Kontak Pelapor</h2>
                    @if ($barangHilang->kontak && count($barangHilang->kontak) > 0)
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach ($barangHilang->kontak as $key => $value)
                                <li><span class="font-medium">{{ $key }}:</span> {{ $value }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 text-sm">Tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lokasi -->
        <div class="bg-white rounded-xl shadow-sm p-5" data-aos="fade-up" data-aos-delay="200">
            <h2 class="font-semibold text-gray-800 mb-3">Lokasi Terakhir Terlihat</h2>
            <p class="text-gray-700 mb-4">{{ $barangHilang->lokasi_terakhir_dilihat ?: 'Tidak diketahui' }}</p>
            @if ($barangHilang->latitude && $barangHilang->longitude)
                <div id="map" class="w-full h-48 rounded-lg border border-gray-200"></div>
            @else
                <p class="text-gray-500 text-sm">Koordinat tidak tersedia.</p>
            @endif
        </div>

        <!-- Komentar -->
        @include('dashboard.components.commentars', [
            'model' => $barangHilang,
            'modelName' => 'App\Models\BarangHilang',
        ])
    </div>
@endsection

@push('style')
@endpush

@push('script')
    @if ($barangHilang->latitude && $barangHilang->longitude)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([{{ $barangHilang->latitude }}, {{ $barangHilang->longitude }}], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                L.marker([{{ $barangHilang->latitude }}, {{ $barangHilang->longitude }}])
                    .addTo(map)
                    .bindPopup("Lokasi terakhir terlihat");
            });
        </script>
    @endif
@endpush
