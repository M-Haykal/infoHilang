@extends('dashboard.layouts.index')

@section('title', 'Detail Laporan Orang Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
            <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
                <h1 class="text-3xl font-bold text-dark">Detail Laporan Orang Hilang</h1>
                <nav class="flex justify-center lg:justify-start mt-2" aria-
                label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-xs font-medium text-netral-400">
                        <li>
                            <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                        </li>
                        <li>
                            <a href="{{ route('missing') }}" class="hover:text-primary transition-colors">Orang Hilang</a>
                        </li>
                        <li>
                            
                            <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                        </li>
                        <li class="text-primary font-bold italic">Detail Laporan</li>
                    </ol>
                </nav>
            </div>

            <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-20 pointer-events-auto">
                <a href="{{ route('missing') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-netral-500 border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-dark hover:border-dark hover:shadow-md transition-all group active:scale-95">
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-6 items-stretch">
            <div class="w-full lg:w-5/12 flex flex-col">
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-4 sticky top-24 h-full flex flex-col"
                    data-aos="fade-up">
                    @if ($orangHilang->foto && count($orangHilang->foto) > 0)
                        <div x-data="{ activeImage: '{{ asset('storage/' . $orangHilang->foto[0]) }}' }" class="space-y-4 flex-1 flex flex-col">
                            <div
                                class="w-full aspect-[4/3] bg-netral-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img :src="activeImage" alt="Foto Preview"
                                    class="object-cover w-full h-full transition-all duration-300 hover:scale-[1.02]">
                            </div>

                            <div class="flex gap-3 justify-center flex-wrap">
                                @foreach ($orangHilang->foto as $foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Thumbnail {{ $loop->iteration }}"
                                        @click="activeImage = '{{ asset('storage/' . $foto) }}'"
                                        class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition
                            hover:scale-105 hover:border-primary"
                                        :class="{ 'border-primary ring-2 ring-blue-300': activeImage === '{{ asset('storage/' . $foto) }}' }">
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="w-full flex-1 bg-netral-100 flex items-center justify-center rounded-lg">
                            <div class="text-center">
                                <i class="fa-solid fa-image text-4xl text-netral-300 mb-2 block"></i>
                                <span class="text-netral-500 text-sm">Tidak ada foto</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-7/12 space-y-6 flex flex-col">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-dark mb-1">{{ $orangHilang->nama_orang }}</h1>
                            <p class="text-xs text-netral-500">Dilaporkan pada
                                {{ $orangHilang->created_at->format('d M Y') }}</p>
                        </div>
                        <span
                            class="@if ($orangHilang->status === 'Hilang') bg-danger text-white
                    @elseif($orangHilang->status === 'Ditemukan') bg-success text-white
                    @else bg-netral-100 text-dark @endif text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            {{ $orangHilang->status }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 flex-1">
                    <h2 class="font-bold text-primary mb-4 border-b pb-2 flex items-center">
                        Informasi Pribadi
                    </h2>
                    <ul class="space-y-4 text-sm">
                        <li class="flex justify-between border-b border-netral-50 pb-2">
                            <span class="font-medium text-netral-500">Jenis Kelamin</span>
                            <span class="font-bold text-dark">{{ $orangHilang->jenis_kelamin }}</span>
                        </li>
                        <li class="flex justify-between border-b border-netral-50 pb-2">
                            <span class="font-medium text-netral-500">Usia</span>
                            <span
                                class="font-bold text-dark">{{ $orangHilang->umur ? $orangHilang->umur . ' Tahun' : 'Tidak diketahui' }}</span>
                        </li>
                        <li>
                            <span class="font-medium text-netral-500 block mb-2">Deskripsi Fisik</span>
                            <div class="bg-netral-50 p-4 text-dark leading-relaxed italic border-l-4 border-primary">
                                {!! $orangHilang->deskripsi_orang ?: '–' !!}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Info Utama -->
        <div class="flex flex-col lg:flex-row gap-6 items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="w-full lg:w-1/2 flex flex-col">
                <div class="bg-white rounded-xl shadow-md p-6 h-full">
                    <h2 class="font-bold text-primary mb-4 pb-2 border-b flex items-center">
                        Ciri-Ciri
                    </h2>

                    @if ($orangHilang->ciri_ciri && count($orangHilang->ciri_ciri) > 0)
                        <ul class="space-y-4 text-sm">
                            @foreach ($orangHilang->ciri_ciri as $key => $value)
                                <li class="flex justify-between border-b border-netral-50 pb-2">
                                    <span
                                        class="font-medium text-netral-500">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                    <span class="font-bold text-dark text-right ml-4">{{ $value }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center h-32 text-netral-400">
                            <i class="fa-solid fa-ghost text-2xl mb-2"></i>
                            <p class="text-xs">Tidak ada ciri khusus terdaftar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col">
                <div class="bg-white rounded-xl shadow-md p-6 h-full">
                    <h2 class="font-bold text-success mb-4 pb-2 border-b flex items-center">
                        Kontak Pelapor
                    </h2>

                    @if ($orangHilang->kontak && count($orangHilang->kontak) > 0)
                        <ul class="space-y-4 text-sm">
                            @foreach ($orangHilang->kontak as $key => $value)
                                <li class="flex justify-between border-b border-netral-50 pb-2">
                                    <span class="font-medium text-netral-500">{{ $key }}</span>
                                    <span class="font-bold text-dark select-all">{{ $value }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-6">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $orangHilang->kontak['WhatsApp'] ?? ($orangHilang->kontak['Telepon'] ?? '')) }}"
                                target="_blank"
                                class="block w-full text-center bg-success text-white py-2 rounded-lg text-xs font-bold hover:bg-green-600 transition">
                                <i class="fa-brands fa-whatsapp mr-1"></i> Hubungi via WhatsApp
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-32 text-netral-400">
                            <i class="fa-solid fa-phone-slash text-2xl mb-2"></i>
                            <p class="text-xs">Kontak tidak tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lokasi -->
        <div class="bg-white rounded-xl shadow-md p-6" data-aos="fade-up" data-aos-delay="200">
            <h2 class="font-bold text-primary mb-3">Lokasi Terakhir Terlihat</h2>
            <div class="text-dark mb-3">{!! $orangHilang->lokasi_terakhir_dilihat ?: 'Tidak diketahui' !!}</div>
            @if ($orangHilang->latitude && $orangHilang->longitude)
                <div id="map" class="w-full h-48 rounded-lg border border-netral-200"></div>
            @else
                <p class="text-netral-500 text-sm">Koordinat tidak tersedia.</p>
            @endif
        </div>

        <!-- Komentar -->
        @include('dashboard.components.commentars', [
            'model' => $orangHilang,
            'modelName' => 'App\Models\OrangHilang',
        ])
    </div>
@endsection

@push('style')
@endpush

@push('script')
    @if ($orangHilang->latitude && $orangHilang->longitude)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([{
                    {
                        $orangHilang - > latitude
                    }
                }, {
                    {
                        $orangHilang - > longitude
                    }
                }], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                L.marker([{
                        {
                            $orangHilang - > latitude
                        }
                    }, {
                        {
                            $orangHilang - > longitude
                        }
                    }])
                    .addTo(map)
                    .bindPopup("Lokasi terakhir terlihat");
            });
        </script>
    @endif
@endpush
