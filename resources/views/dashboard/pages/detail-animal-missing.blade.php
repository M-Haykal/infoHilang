@extends('dashboard.layouts.index')

@section('title', 'Detail Laporan Hewan Hilang | InfoHilang')
@section('content')
    <div class="space-y-6">
        <header class="text-center mb-8">
            <h1 class="text-2xl font-bold text-dark">{{ $hewanHilang->nama_hewan }}</h1>
            <p class="text-netral-500 mt-1">
                Dilaporkan hilang sejak
                {{ date('d M Y H:i', strtotime($hewanHilang->tanggal_terakhir_dilihat)) }}
            </p>
            <span
                class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full
                    @if ($hewanHilang->status === 'Hilang') bg-danger text-white
                    @elseif($hewanHilang->status === 'Ditemukan') bg-success text-white
                    @else bg-netral-100 text-dark @endif">
                {{ $hewanHilang->status }}
            </span>
        </header>

        <div class="bg-white rounded-xl shadow-md overflow-hidden p-4" data-aos="fade-up">
            @if ($hewanHilang->foto && count($hewanHilang->foto) > 0)
                <div x-data="{ activeImage: '{{ asset('storage/' . $hewanHilang->foto[0]) }}' }" class="space-y-4">
                    <!-- Preview Besar -->
                    <div class="w-full h-64 sm:h-80 bg-netral-100 rounded-lg overflow-hidden flex items-center justify-center">
                        <img :src="activeImage" alt="Foto Preview"
                            class="object-cover w-full h-full transition-all duration-300 hover:scale-[1.02]">
                    </div>

                    <!-- Thumbnail -->
                    <div class="flex gap-3 justify-center flex-wrap">
                        @foreach ($hewanHilang->foto as $foto)
                            <img src="{{ asset('storage/' . $foto) }}" alt="Thumbnail {{ $loop->iteration }}"
                                @click="activeImage = '{{ asset('storage/' . $foto) }}'"
                                class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition
                                hover:scale-105 hover:border-primary"
                                :class="{ 'border-primary ring-2 ring-blue-300': activeImage === '{{ asset('storage/' . $foto) }}' }">
                        @endforeach
                    </div>
                </div>
            @else
                <div class="w-full h-64 sm:h-80 bg-netral-100 flex items-center justify-center">
                    <span class="text-netral-500">Tidak ada foto</span>
                </div>
            @endif
        </div>

        <!-- Info Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="100">
            <!-- Data Pribadi -->
            <div class="bg-white rounded-xl shadow-md p-5">
                <h2 class="font-semibold text-primary mb-4 border-b pb-2">Informasi Pribadi</h2>
                <ul class="space-y-3 text-sm text-dark">
                    <li class="flex justify-between">
                        <span class="font-medium">Jenis Kelamin:</span>
                        <span>{{ $hewanHilang->jenis_kelamin }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="font-medium">Usia:</span>
                        <span>{{ $hewanHilang->umur ? $hewanHilang->umur . ' tahun' : 'Tidak diketahui' }}</span>
                    </li>
                    <li>
                        <span class="font-medium block mb-1">Deskripsi Fisik:</span>
                        <p>{!! $hewanHilang->deskripsi_hewan ?: '–' !!}</p>
                    </li>
                </ul>
            </div>

            <!-- Ciri-Ciri & Kontak -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-md p-5">
                    <h2 class="font-semibold text-primary mb-3">Ciri-Ciri Khusus</h2>
                    @if ($hewanHilang->ciri_ciri && count($hewanHilang->ciri_ciri) > 0)
                        <ul class="space-y-2 text-sm text-dark">
                            @foreach ($hewanHilang->ciri_ciri as $key => $value)
                                <li><span class="font-medium">{{ $key }}:</span> {{ $value }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-netral-500 text-sm">Tidak ada ciri khusus.</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-md p-5">
                    <h2 class="font-semibold text-primary mb-3">Kontak Pelapor</h2>
                    @if ($hewanHilang->kontak && count($hewanHilang->kontak) > 0)
                        <ul class="space-y-2 text-sm text-dark">
                            @foreach ($hewanHilang->kontak as $key => $value)
                                <li><span class="font-medium">{{ $key }}:</span> {{ $value }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-netral-500 text-sm">Tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lokasi -->
        <div class="bg-white rounded-xl shadow-md p-5" data-aos="fade-up" data-aos-delay="200">
            <h2 class="font-semibold text-primary mb-3">Lokasi Terakhir Terlihat</h2>
            <p class="text-dark mb-4">{!! $hewanHilang->lokasi_terakhir_dilihat ?: 'Tidak diketahui' !!}</p>
            @if ($hewanHilang->latitude && $hewanHilang->longitude)
                <div id="map" class="w-full h-48 rounded-lg border border-netral-200"></div>
            @else
                <p class="text-netral-500 text-sm">Koordinat tidak tersedia.</p>
            @endif
        </div>

        <!-- Komentar -->
        @include('dashboard.components.commentars', [
            'model' => $hewanHilang,
            'modelName' => 'App\Models\HewanHilang',
        ])
    </div>
@endsection
