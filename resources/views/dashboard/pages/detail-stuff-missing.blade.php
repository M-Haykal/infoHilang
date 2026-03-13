@extends('dashboard.layouts.index')

@section('title', 'Detail Laporan Barang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
            <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
                <h1 class="text-3xl font-bold text-dark">Detail Laporan Barang</h1>
                <nav class="flex justify-center lg:justify-start mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-xs font-medium text-netral-400">
                        <li>
                            <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                        </li>
                        <li>
                            <a href="{{ route('missing') }}" class="hover:text-primary transition-colors">Barang Hilang</a>
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
            {{-- Gambar/foto --}}
            <div class="w-full lg:w-5/12 flex flex-col">
                <div class="bg-white rounded-xl shadow-sm border border-netral-100 overflow-hidden p-4 sticky top-24 h-full flex flex-col hover:shadow-md"
                    data-aos="fade-up">
                    @if (is_array($barangHilang->foto) && count($barangHilang->foto) > 0)
                        <div class="space-y-3 flex-1 flex flex-col">
                            {{-- Gambar active --}}
                            <div
                                class="w-full aspect-square bg-netral-100 rounded-lg overflow-hidden flex items-center justify-center border border-netral-200">
                                <div class="relative w-full h-full group overflow-hidden">
                                    <img id="main-preview" src="{{ asset('storage/' . $barangHilang->foto[0]) }}"
                                        alt="Foto Preview"
                                        class="object-cover w-full h-full transition-all duration-500 group-hover:scale-110">

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none">
                                    </div>
                                </div>
                            </div>

                            {{-- List gambar --}}
                            <div class="flex gap-3 flex-wrap">
                                @foreach ($barangHilang->foto as $foto)
                                    @php $urlFull = asset('storage/' . $foto); @endphp
                                    <img src="{{ $urlFull }}" alt="Thumbnail"
                                        onclick="changePreview(this, '{{ $urlFull }}')"
                                        class="thumbnail-item w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition hover:scale-105 {{ $loop->first ? 'border-primary ring-2 ring-blue-300' : 'border-transparent' }}">
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
                <div class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-black text-dark tracking-tight mb-2">{{ $barangHilang->nama_barang }}
                            </h1>
                            <div class="flex items-center gap-2 mt-1">
                                <i class="fa-regular fa-calendar text-netral-400 text-xs"></i>
                                <p class="text-xs font-medium text-netral-500">Dilaporkan pada <span
                                        class="text-dark">{{ $barangHilang->created_at->format('d M Y') }}</span></p>
                            </div>
                        </div>
                        <span
                            class="@if ($barangHilang->status === 'Hilang') bg-danger text-white
                                            @elseif($barangHilang->status === 'Ditemukan') bg-success text-white
                                            @else bg-netral-100 text-dark @endif text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            {{ $barangHilang->status }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 flex-1 hover:shadow-md">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-6 bg-primary rounded-full"></div>
                        <h2 class="font-bold text-dark uppercase tracking-wider italic">
                            Informasi Barang
                        </h2>
                    </div>

                    <ul class="space-y-2 mb-6">
                        <li
                            class="flex items-center justify-between p-3 rounded-xl bg-netral-50 border border-netral-100 hover:shadow-sm">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-tag text-primary"></i>
                                <span class="font-medium text-netral-500 text-sm">Jenis Barang</span>
                            </div>
                            <span class="font-bold text-dark text-sm">{{ $barangHilang->jenis_barang }}</span>
                        </li>
                        <li
                            class="flex items-center justify-between p-3 rounded-xl bg-netral-50 border border-netral-100 hover:shadow-sm">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-copyright text-primary"></i>
                                <span class="font-medium text-netral-500 text-sm">Merek</span>
                            </div>
                            <span class="font-bold text-dark text-sm">{{ $barangHilang->merk_barang }}</span>
                        </li>
                        <li
                            class="flex items-center justify-between p-3 rounded-xl bg-netral-50 border border-netral-100 hover:shadow-sm">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-palette text-primary"></i>
                                <span class="font-medium text-netral-500 text-sm">Warna</span>
                            </div>
                            <span
                                class="px-3 py-1 bg-white border rounded-lg font-bold text-dark text-xs shadow-sm">{{ $barangHilang->warna_barang }}</span>
                        </li>
                    </ul>

                    <div>
                        <div class="flex items-center gap-2 mb-3 text-netral-500">
                            <i class="fa-solid fa-align-left text-xs text-primary"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">Deskripsi Barang</span>
                        </div>
                        <div
                            class="bg-netral-50 rounded-xl p-4 text-dark text-sm leading-relaxed border-2 border-dashed border-netral-200 min-h-[100px] relative overflow-hidden">
                            {!! $barangHilang->deskripsi_barang ?:
                                '<span class="italic text-netral-400">Tidak ada deskripsi tambahan...</span>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Utama -->
        <div class="flex flex-col lg:flex-row gap-6 items-stretch" data-aos="fade-up" data-aos-delay="100">

            <div class="w-full lg:w-5/12 flex flex-col">
                <div
                    class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 h-full transition-all hover:shadow-md">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-6 bg-primary rounded-full"></div>
                        <h2 class="font-bold text-dark uppercase tracking-wider italic">
                            Ciri-Ciri Khusus
                        </h2>
                    </div>

                    @if ($barangHilang->ciri_ciri && count($barangHilang->ciri_ciri) > 0)
                        <ul class="space-y-2 text-sm">
                            @foreach ($barangHilang->ciri_ciri as $key => $value)
                                <li
                                    class="flex items-center justify-between p-3 rounded-xl bg-netral-50 border border-netral-100 hover:shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <i class="fa-solid fa-magnifying-glass-plus text-primary text-xs"></i>
                                        <span
                                            class="font-medium text-netral-500">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                    </div>
                                    <span class="font-bold text-dark text-right ml-4">{{ $value }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div
                            class="flex flex-col items-center justify-center py-12 bg-netral-50 rounded-xl border-2 border-dashed border-netral-200 text-netral-400">
                            <i class="fa-solid fa-ghost text-3xl mb-3 opacity-50"></i>
                            <p class="text-xs font-medium italic">Tidak ada ciri khusus terdaftar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-7/12 flex flex-col">
                <div
                    class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 h-full transition-all hover:shadow-md">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-6 bg-primary rounded-full"></div>
                        <h2 class="font-bold text-dark uppercase tracking-wider italic">
                            Kontak Pelapor
                        </h2>
                    </div>

                    @if ($barangHilang->kontak && count($barangHilang->kontak) > 0)
                        <ul class="space-y-2 text-sm">
                            @foreach ($barangHilang->kontak as $key => $value)
                                <li onclick="copyToClipboard(this, '{{ $value }}')"
                                    class="relative group flex justify-between items-center p-3 rounded-xl bg-netral-50 border border-netral-100 hover:shadow-sm overflow-hidden cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        @if (Str::contains(strtolower($key), 'whatsapp'))
                                            <i class="fa-brands fa-whatsapp text-success text-base"></i>
                                        @elseif(Str::contains(strtolower($key), 'telepon') || Str::contains(strtolower($key), 'hp'))
                                            <i class="fa-solid fa-phone text-primary text-xs"></i>
                                        @else
                                            <i class="fa-solid fa-address-book text-primary text-xs"></i>
                                        @endif
                                        <span class="font-medium text-netral-500">{{ $key }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="font-bold text-dark transition-all duration-300">{{ $value }}</span>
                                        <i class="fa-regular fa-copy text-netral-300 text-xs"></i>
                                    </div>

                                    <div
                                        class="copy-badge absolute inset-0 bg-primary text-white flex items-center justify-center translate-y-full transition-transform duration-300 font-bold text-xs uppercase tracking-widest">
                                        Berhasil Disalin!
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-8">
                            @php
                                $waNumber = preg_replace(
                                    '/[^0-9]/',
                                    '',
                                    $barangHilang->kontak['WhatsApp'] ??
                                        ($barangHilang->kontak['Telepon'] ??
                                            ($barangHilang->kontak['Handphone'] ?? '')),
                                );
                            @endphp
                            <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                class="group flex items-center justify-center gap-3 w-full bg-success text-white py-4 rounded-xl text-sm font-bold shadow-lg shadow-success/20 hover:bg-green-600 hover:-translate-y-1 transition-all duration-300">
                                <i class="fa-brands fa-whatsapp text-xl group-hover:animate-bounce"></i>
                                Hubungi via WhatsApp
                            </a>
                            <p class="text-center text-[10px] text-netral-400 mt-3 italic">
                                *Harap berhati-hati terhadap penipuan yang mengatasnamakan pihak tertentu.
                            </p>
                        </div>
                    @else
                        <div
                            class="flex flex-col items-center justify-center py-12 bg-netral-50 rounded-xl border-2 border-dashed border-netral-200 text-netral-400">
                            <i class="fa-solid fa-phone-slash text-3xl mb-3 opacity-50"></i>
                            <p class="text-xs font-medium italic">Kontak tidak tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lokasi -->
        <div class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 transition-all hover:shadow-md"
            data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-6 bg-primary rounded-full"></div>
                    <h2 class="font-bold text-dark uppercase tracking-wider italic">
                        Lokasi Terakhir
                    </h2>
                </div>
                @if ($barangHilang->latitude && $barangHilang->longitude)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $barangHilang->latitude }},{{ $barangHilang->longitude }}"
                        target="_blank"
                        class="text-[10px] font-bold text-primary hover:underline flex items-center gap-1 uppercase tracking-widest">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka di Maps
                    </a>
                @endif
            </div>

            <div class="flex items-start gap-3 p-4 bg-netral-50 rounded-xl border border-netral-100 mb-4">
                <div class="bg-white p-2 rounded-xl shadow-sm">
                    <i class="fa-solid fa-location-dot text-accent"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-bold text-netral-400 uppercase tracking-tighter mb-1">Alamat</p>
                    <div class="text-sm text-dark leading-relaxed font-medium">
                        {!! $barangHilang->lokasi_terakhir_dilihat ?:
                            '<span class="italic text-netral-400">Lokasi detail tidak diberikan...</span>' !!}
                    </div>
                </div>
            </div>

            @if ($barangHilang->latitude && $barangHilang->longitude)
                <div class="relative group">
                    <div id="map" class="w-full h-56 rounded-xl border-2 border-white shadow-inner z-10"></div>
                    <div
                        class="absolute bottom-3 right-3 z-20 bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg border border-netral-100 text-[9px] font-mono text-netral-500 shadow-sm">
                        {{ number_format($barangHilang->latitude, 6) }}, {{ number_format($barangHilang->longitude, 6) }}
                    </div>
                </div>
            @else
                <div
                    class="flex flex-col items-center justify-center py-10 bg-netral-50 rounded-xl border-2 border-dashed border-netral-200 text-netral-400">
                    <i class="fa-solid fa-map-location-dot text-3xl mb-3 opacity-50"></i>
                    <p class="text-xs font-medium italic">Titik koordinat tidak tersedia.</p>
                </div>
            @endif
        </div>

        {{-- Laporan Penemuan --}}
        <div class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 mt-6 transition-all hover:shadow-md"
            data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-6 bg-primary rounded-full"></div>
                    <h2 class="font-bold text-dark uppercase tracking-wider italic">
                        Laporan Penemuan & Jejak
                    </h2>
                </div>
                <span class="px-2 py-1 bg-netral-50 text-primary text-[10px] font-black rounded-lg border border-primary">
                    {{ $barangHilang->laporanDitemukan->count() }} Laporan
                </span>
            </div>

            <div class="overflow-hidden border border-netral-100 rounded-xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-netral-50 border-b border-netral-100">
                            <th class="px-4 py-3 font-bold text-[10px] text-netral-500 uppercase tracking-widest">Informasi
                                Penemu</th>
                            <th
                                class="px-4 py-3 font-bold text-[10px] text-netral-500 uppercase tracking-widest hidden md:table-cell">
                                Lokasi & Waktu</th>
                            <th
                                class="px-4 py-3 font-bold text-[10px] text-netral-500 uppercase tracking-widest text-center">
                                Status</th>
                            <th
                                class="px-4 py-3 font-bold text-[10px] text-netral-500 uppercase tracking-widest text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-netral-50">
                        @forelse($barangHilang->laporanDitemukan as $laporan)
                            <tr class="hover:bg-netral-50/30 transition-colors group">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl overflow-hidden bg-netral-100 border border-netral-200 shrink-0">
                                            @if ($laporan->bukti_ditemukan)
                                                <img src="{{ asset('storage/' . $laporan->bukti_ditemukan[0]) }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform cursor-pointer">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-netral-300 bg-netral-50">
                                                    <i class="fa-solid fa-image-slash text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-black text-dark truncate">{{ $laporan->nama_penemu }}
                                            </p>
                                            <p
                                                class="text-[10px] text-primary font-bold hover:underline select-all cursor-copy">
                                                <i class="fa-solid fa-phone-volume mr-1"></i>
                                                {{ $laporan->kontak_penemu }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    <p class="text-xs font-bold text-dark italic leading-tight line-clamp-1">
                                        <i class="fa-solid fa-location-crosshairs text-accent mr-1"></i>
                                        {{ $laporan->lokasi_ditemukan }}
                                    </p>
                                    <p class="text-[9px] text-netral-400 font-bold uppercase mt-1">
                                        {{ \Carbon\Carbon::parse($laporan->tanggal_ditemukan)->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if ($laporan->is_confirmed)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-success text-white text-[9px] font-black uppercase rounded-lg shadow-sm shadow-success/30">
                                            <i class="fa-solid fa-certificate"></i> Valid
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-netral-100 text-netral-400 text-[9px] font-black uppercase rounded-lg">
                                            <i class="fa-solid fa-hourglass-half"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="viewLaporanDetail({{ $laporan->id }})"
                                            class="w-8 h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-primary hover:border-primary transition-all shadow-sm">
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                        </button>

                                        {{-- Jika belum dikonfirmasi, pemilik bisa mengonfirmasi --}}
                                        @if (!$laporan->is_confirmed)
                                            <button wire:click="confirmFound({{ $laporan->id }})"
                                                class="w-8 h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-success hover:border-success transition-all shadow-sm"
                                                title="Konfirmasi sebagai temuan asli">
                                                <i class="fa-solid fa-check-double text-[10px]"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-netral-400">
                                    <div class="flex flex-col items-center opacity-40">
                                        <i class="fa-solid fa-route text-3xl mb-3"></i>
                                        <p class="text-xs">Belum ada jejak masuk</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Komentar -->
        <div class="bg-white rounded-xl shadow-sm border border-netral-100 p-6 h-full transition-all hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-1 h-6 bg-primary rounded-full"></div>
                <h2 class="font-bold text-dark uppercase tracking-wider italic">
                    Komentar
                </h2>
            </div>
            @include('dashboard.components.commentars', [
                'model' => $barangHilang,
                'modelName' => 'App\Models\BarangHilang',
            ])
        </div>
    </div>
@endsection

@push('style')
@endpush

@push('script')
    @if ($barangHilang->latitude && $barangHilang->longitude)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([{
                    {
                        $barangHilang - > latitude
                    }
                }, {
                    {
                        $barangHilang - > longitude
                    }
                }], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                L.marker([{
                        {
                            $barangHilang - > latitude
                        }
                    }, {
                        {
                            $barangHilang - > longitude
                        }
                    }])
                    .addTo(map)
                    .bindPopup("Lokasi terakhir terlihat");
            });
        </script>
    @endif
@endpush
