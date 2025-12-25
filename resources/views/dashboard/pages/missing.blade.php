@extends('dashboard.layouts.index')

@section('title', 'History Laporan Hilang | InfoHilang')

@section('content')
    <div class="space-y-6">
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-accent/800 mb-2">Daftar Laporan Hilang, {{ Auth::user()->username }}!</h1>
            <p class="text-accent/600 max-w-2xl mx-auto">Pantau dan kelola laporan kehilangan anda disini dengan mudah.</p>
        </header>

        <section class="menu-history-hilang max-w-6xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Tab Headers -->
                <div class="flex flex-col sm:flex-row justify-between border-b border-accent/200">
                    <h2 class="text-xl font-semibold text-accent/800 p-6 pb-0">Histori Laporan</h2>

                    <div class="flex space-x-1 sm:space-x-2 p-2">
                        <button
                            class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm rounded-lg transition-all duration-300 active bg-primary/10 text-primary"
                            data-tab="tab1">
                            <i class="fa-solid fa-box mr-2"></i>
                            Barang Hilang
                        </button>
                        <button
                            class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm rounded-lg transition-all duration-300 text-accent/500 hover:bg-accent/100"
                            data-tab="tab2">
                            <i class="fa-solid fa-user mr-2"></i>
                            Orang Hilang
                        </button>
                        <button
                            class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm rounded-lg transition-all duration-300 text-accent/500 hover:bg-accent/100"
                            data-tab="tab3">
                            <i class="fa-solid fa-paw mr-2"></i>
                            Hewan Hilang
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content p-6">
                    <!-- Barang Hilang Tab -->
                    <div id="tab1" class="tab-pane active">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-accent/800">Barang Hilang</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $missingItems->count() }} item
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse ($missingItems as $item)
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-accent/50 rounded-lg border border-accent/200 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . ($item->foto[0] ?? 'default.jpg')) }}"
                                                alt="Barang"
                                                class="w-16 h-16 object-cover rounded-lg border border-accent/200">
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-accent/800 text-lg">{{ $item->nama_barang }}</h4>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                <span class="inline-flex items-center text-sm text-accent/600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $item->lokasi_terakhir_dilihat }}
                                                </span>
                                                <span class="inline-flex items-center text-sm text-accent/600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ date('d M Y H:i', strtotime($item->tanggal_terakhir_dilihat)) }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                @if ($item->status == 'Hilang')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $item->status }}
                                                    </span>
                                                @elseif($item->status == 'Ditemukan')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $item->status }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ $item->status }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('form-barang-hilang.detail', $item->slug) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('form-barang-hilang.edit', $item->slug) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                                            data-confirm-edit>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('form-barang-hilang.destroy', $item->slug) }}"
                                            method="POST" data-confirm-delete class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-accent/400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-accent/900">Belum ada laporan barang hilang</h3>
                                    <p class="mt-1 text-accent/500">Anda belum membuat laporan barang hilang.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('form-barang-hilang') }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                            Buat Laporan Baru
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if ($missingItems->count() > 0)
                            <div class="mt-8 flex justify-center">
                                {{ $missingItems->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Orang Hilang Tab -->
                    <div id="tab2" class="tab-pane hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-accent/800">Orang Hilang</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $missingPersons->count() }} item
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse ($missingPersons as $missingPerson)
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-accent/50 rounded-lg border border-accent/200 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . ($missingPerson->foto[0] ?? 'default.jpg')) }}"
                                                alt="Orang"
                                                class="w-16 h-16 object-cover rounded-lg border border-accent/200">
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-accent/800 text-lg">
                                                {{ $missingPerson->nama_orang }}</h4>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                <span class="inline-flex items-center text-sm text-accent/600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $missingPerson->lokasi_terakhir_dilihat }}
                                                </span>
                                                <span class="inline-flex items-center text-sm text-accent/600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ date('d M Y H:i', strtotime($missingPerson->tanggal_terakhir_dilihat)) }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                @if ($missingPerson->status == 'Hilang')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $missingPerson->status }}
                                                    </span>
                                                @elseif($missingPerson->status == 'Ditemukan')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $missingPerson->status }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ $missingPerson->status }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('form-orang-hilang.detail', $missingPerson->slug) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('form-orang-hilang.edit', $missingPerson->slug) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                                            data-confirm-edit>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('form-orang-hilang.destroy', $missingPerson->slug) }}"
                                            method="POST" data-confirm-delete class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                        <a href="{{ route('form-orang-hilang.print-pdf', ['orangHilang' => $missingPerson->slug]) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Cetak Poster
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-accent/400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-accent/900">Belum ada laporan orang hilang</h3>
                                    <p class="mt-1 text-accent/500">Anda belum membuat laporan orang hilang.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('form-orang-hilang') }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                            Buat Laporan Baru
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if ($missingPersons->count() > 0)
                            <div class="mt-8 flex justify-center">
                                {{ $missingPersons->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Hewan Hilang Tab -->
                    <div id="tab3" class="tab-pane hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-accent/800">Hewan Hilang</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $missingAnimals->count() }} item
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse ($missingAnimals as $missingAnimal)
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-accent/50 rounded-lg border border-accent/200 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . ($missingAnimal->foto[0] ?? 'default.jpg')) }}"
                                                alt="Hewan"
                                                class="w-16 h-16 object-cover rounded-lg border border-accent/200">
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-accent/800 text-lg">
                                                {{ $missingAnimal->nama_hewan }}</h4>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                <span class="inline-flex items-center text-sm text-accent/600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $missingAnimal->lokasi_terakhir_dilihat }}
                                                </span>
                                                <span class="inline-flex items-center text-sm text-accent/600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ date('d M Y H:i', strtotime($missingAnimal->tanggal_terakhir_dilihat)) }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                @if ($missingAnimal->status == 'Hilang')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $missingAnimal->status }}
                                                    </span>
                                                @elseif($missingAnimal->status == 'Ditemukan')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $missingAnimal->status }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ $missingAnimal->status }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <a href=""
                                            class="inline-flex items-center px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <a href=""
                                            class="inline-flex items-center px-4 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                                            data-confirm-edit>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action=""
                                            method="POST" data-confirm-delete class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                        <a href=""
                                            class="inline-flex items-center px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Cetak Poster
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-accent/400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-accent/900">Belum ada laporan hewan hilang</h3>
                                    <p class="mt-1 text-accent/500">Anda belum membuat laporan hewan hilang.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('form-hewan-hilang') }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                            Buat Laporan Baru
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if ($missingAnimals->count() > 0)
                            <div class="mt-8 flex justify-center">
                                {{ $missingAnimals->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <style>
        .tab-button.active {
            color: #1E88E5 !important;
            background-color: rgba(30, 136, 229, 0.1);
        }

        .tab-pane {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('script')
    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'bg-primary/10', 'text-primary');
                    btn.classList.add('text-accent/500');
                });

                // Add active class to clicked button
                button.classList.add('active', 'bg-primary/10', 'text-primary');
                button.classList.remove('text-accent/500');

                // Hide all tab panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.add('hidden');
                });

                // Show the targeted tab pane
                const tabId = button.dataset.tab;
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    </script>
@endpush
