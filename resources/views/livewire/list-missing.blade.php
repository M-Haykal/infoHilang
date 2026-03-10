<div class="max-w-7xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
    <!-- PageHeading -->
    <div class="text-center mb-10">
        <h2 class="text-4xl md:text-5xl font-extrabold text-dark">Daftar Hilang <span class="text-primary">&amp;</span>
            Ditemukan</h2>
        <p class="text-netral-500 max-w-xl mx-auto mt-4">
            Pusat informasi kehilangan dan penemuan. Mari saling membantu mempertemukan kembali mereka yang terpisah.
        </p>
        <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
    </div>
    {{-- <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-dark">Daftar Hilang <span class="text-primary">&amp;</span> Ditemukan</h2>
        <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
    </div> --}}

    <div class="relative">
        <!-- SearchBar -->
        <div class="sticky top-[72px] z-40 bg-netral-50 backdrop-blur-md py-4 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <label class="flex flex-col min-w-40 h-14 w-full">
                    <div
                        class="flex w-full flex-1 items-stretch rounded-2xl h-full shadow-lg bg-white border border-netral-200">
                        <div class="text-netral-500 flex items-center justify-center pl-5">
                            <i class="fa-solid fa-magnifying-glass text-xl"></i>
                        </div>
                        <input wire:model.live.debounce.500ms="search"
                            wire:key="search-input-{{ $search === '' ? 'empty' : 'active' }}"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-2xl text-dark border-none bg-transparent h-full px-4 pl-3 text-base font-medium placeholder:text-netral-500 focus:outline-none focus:ring-0 focus:border-none focus:shadow-none"
                            placeholder="Cari barang, hewan, atau orang..." type="text" />
                    </div>
                </label>
            </div>
        </div>

        <div class="flex flex-col gap-8 lg:flex-row items-stretch">
            <!-- Filters Sidebar -->
            <aside class="w-full lg:w-1/4 xl:w-1/5 py-4">
                <div class="sticky top-[160px] z-30 bg-white rounded-xl shadow-md p-5 border border-netral-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold leading-tight tracking-[-0.015em] text-dark">Filter</h3>
                        <button wire:click="resetFilters"
                            class="text-sm font-medium text-primary hover:underline transition-colors">
                            Reset
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:flex lg:flex-col gap-6">

                        <!-- Status Filter -->
                        <div class="col-span-1" wire:key="filter-status-container">
                            <h4 class="text-sm font-bold mb-3 text-dark">Status</h4>

                            <div class="lg:hidden">
                                <select wire:model.live="status"
                                    wire:key="select-status-{{ $status === '' ? 'reset' : 'active' }}"
                                    class="w-full rounded-lg border border-netral-200 text-sm font-medium p-3 transition-all text-netral-500 focus:border-primary focus:ring-primary focus:outline-none">
                                    <option value="">Semua Status</option>
                                    <option value="Hilang">Hilang</option>
                                    <option value="Ditemukan">Ditemukan</option>
                                </select>
                            </div>

                            <div class="hidden lg:flex flex-col gap-2">
                                @foreach (['' => 'Semua Status', 'Hilang' => 'Hilang', 'Ditemukan' => 'Ditemukan'] as $val => $label)
                                    <label wire:key="wrapper-status-{{ $val }}"
                                        class="flex items-center gap-3 rounded-lg border p-3 cursor-pointer transition-colors {{ $status === $val ? 'border-primary bg-primary/50' : 'border-netral-200 hover:border-primary/50' }}">

                                        <input wire:model.live="status"
                                            wire:key="radio-status-{{ $val }}-{{ $status === $val ? 'active' : 'inactive' }}"
                                            type="radio" name="status_group_desktop" value="{{ $val }}"
                                            class="h-4 w-4 text-primary focus:ring-primary cursor-pointer" />

                                        <p
                                            class="text-sm font-medium {{ $status === $val ? 'text-primary' : 'text-netral-500' }}">
                                            {{ $label }}
                                        </p>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="col-span-1" wire:key="filter-kategori-container">
                            <h4 class="text-sm font-bold mb-3 text-dark">Kategori</h4>

                            <div class="lg:hidden">
                                <select wire:model.live="kategori"
                                    wire:key="select-kategori-{{ $kategori === '' ? 'reset' : 'active' }}"
                                    class="w-full rounded-lg border border-netral-200 text-sm font-medium p-3 transition-all text-netral-500 focus:border-primary focus:ring-primary focus:outline-none">
                                    <option value="">Semua Kategori</option>
                                    <option value="Barang">Barang</option>
                                    <option value="Hewan">Hewan</option>
                                    <option value="Orang">Orang</option>
                                </select>
                            </div>

                            <div class="hidden lg:flex flex-col gap-2">
                                @foreach (['' => 'Semua Kategori', 'Barang' => 'Barang', 'Hewan' => 'Hewan', 'Orang' => 'Orang'] as $val => $label)
                                    <label wire:key="wrapper-kategori-{{ $val }}"
                                        class="flex items-center gap-3 rounded-lg border p-3 cursor-pointer transition-colors {{ $kategori === $val ? 'border-primary bg-primary/50 shadow-sm' : 'border-netral-200 hover:border-primary/50' }}">

                                        <input wire:model.live="kategori"
                                            wire:key="input-kategori-{{ $val }}-{{ $kategori === $val ? 'on' : 'off' }}"
                                            value="{{ $val }}" name="kategori_radio_group" type="radio"
                                            class="h-4 w-4 text-primary focus:ring-primary cursor-pointer" />

                                        <p
                                            class="text-sm font-medium {{ $kategori === $val ? 'text-primary' : 'text-netral-500' }}">
                                            {{ $label }}
                                        </p>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Location Filter -->
                        <div class="col-span-1">
                            <h4 class="text-sm font-bold mb-3 text-dark">Lokasi</h4>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i
                                        class="fa-solid fa-location-dot {{ $lokasi ? 'text-primary' : 'text-netral-400' }} transition-colors"></i>
                                </div>
                                <input wire:model.live.debounce.500ms="lokasi"
                                    wire:key="filter-lokasi-{{ $lokasi ? 'active' : 'empty' }}"
                                    class="form-input w-full rounded-lg border-netral-300 text-sm font-medium {{ $lokasi ? 'text-primary' : 'text-netral-500' }} bg-netral-100 pl-10 py-2 transition-all focus:outline-none focus:border-netral-100"
                                    placeholder="Jakarta Selatan" type="text" />
                            </div>
                        </div>

                        <!-- Date Filter -->
                        <div class="col-span-1">
                            <h4 class="text-sm font-bold mb-3 text-dark">Tanggal Dilaporkan</h4>
                            <div class="relative">
                                <div onclick="document.getElementById('filter-date').showPicker()"
                                    class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i
                                        class="fa-solid fa-calendar {{ $date ? 'text-primary' : 'text-netral-400' }} transition-colors"></i>
                                </div>
                                <input id="filter-date" wire:model.live="date"
                                    wire:key="filter-date-{{ $date ? 'active' : 'empty' }}"
                                    class="form-input w-full rounded-lg border-netral-300 text-sm font-medium {{ $date ? 'text-primary' : 'text-netral-500' }} bg-netral-100 pl-10 py-2 transition-all focus:outline-none focus:border-netral-100"
                                    type="date" onclick="this.showPicker()" />
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="w-full lg:w-3/4 xl:w-4/5 flex flex-col">
                <div class="flex items-center justify-end py-2 sticky top-[152px] z-30 pt-3">
                    <div class="flex items-center gap-1 bg-netral-100 p-1 rounded-xl">
                        <button wire:click="setView('grid')"
                            class="p-2 rounded-lg transition-all {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-primary' : 'text-netral-400 hover:text-netral-500' }}">
                            <i class="fa-solid fa-grip text-lg"></i>
                        </button>
                        <button wire:click="setView('list')"
                            class="p-2 rounded-lg transition-all {{ $viewMode === 'list' ? 'bg-white shadow-sm text-primary' : 'text-netral-400 hover:text-netral-500' }}">
                            <i class="fa-solid fa-list text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="flex-1 flex flex-col mt-4">
                    @if ($reports->count() > 0)
                        <div
                            class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 sm:grid-cols-3 gap-6' : 'flex flex-col gap-4' }}">
                            @foreach ($reports as $report)
                                <div
                                    class="group flex {{ $viewMode === 'grid' ? 'flex-col' : 'flex-row' }} overflow-hidden rounded-2xl border bg-white shadow-sm hover:shadow-md transition-all duration-300">

                                    <div
                                        class="relative overflow-hidden {{ $viewMode === 'grid' ? 'w-full aspect-square' : 'w-[36%] md:w-48 aspect-square flex-shrink-0' }} group">
                                        @if ($report->foto && count($report->foto) > 0)
                                            {{-- Gambar utama dengan fallback --}}
                                            <img src="{{ asset('storage/' . $report->foto[0]) }}"
                                                alt="{{ $report->display_name }}"
                                                class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                            {{-- Placeholder kalau file di storage rusak/hilang --}}
                                            <div
                                                class="hidden absolute inset-0 bg-netral-50 flex-col items-center justify-center text-netral-400">
                                                <i class="fa-solid fa-triangle-exclamation text-2xl mb-2"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-tighter">Image
                                                    Error</span>
                                            </div>
                                        @else
                                            {{-- Placeholder kalau memang tidak ada foto di database --}}
                                            <div
                                                class="absolute inset-0 bg-netral-50 flex flex-col items-center justify-center text-netral-300">
                                                <i class="fa-solid fa-image text-3xl mb-2"></i>
                                                <span
                                                    class="text-[10px] font-bold uppercase tracking-tighter text-netral-400">No
                                                    Photo Available</span>
                                            </div>
                                            {{-- Placeholder kalau file di storage rusak/hilang --}}
                                            <div
                                                class="hidden absolute inset-0 bg-netral-50 flex-col items-center justify-center text-netral-400">
                                                <i class="fa-solid fa-triangle-exclamation text-2xl mb-2"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-tighter">Image
                                                    Error</span>
                                            </div>
                                        @endif

                                        {{-- Overlay gradasi (supaya teks/badge/status lebih kontras) --}}
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                                        </div>

                                        {{-- Status badge --}}
                                        <span
                                            class="absolute top-3 left-3 {{ $report->status == 'Hilang' ? 'bg-danger' : 'bg-success' }} text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm z-10">
                                            {{ $report->status }}
                                        </span>
                                    </div>

                                    <div
                                        class="{{ $viewMode === 'grid' ? 'w-full' : 'w-2/3 md:w-48' }} flex flex-1 flex-col p-5 justify-between">
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <h3 class="text-lg font-bold text-dark group-hover:text-primary">
                                                    {{ $report->report_name }}
                                                </h3>
                                                @if ($viewMode === 'list')
                                                    <span
                                                        class="hidden md:block text-[10px] text-netral-400 font-medium tracking-widest">{{ $report->created_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                            <div class="space-y-2">
                                                <div class="text-sm text-netral-500 line-clamp-2 mb-2 prose-compact">
                                                    {!! $report->deskripsi ?? 'Klik detail untuk melihat deskripsi lengkap laporan ini.' !!}
                                                </div>
                                                <div title="Lokasi terakhir dilihat"
                                                    class="flex items-center text-xs text-netral-500 bg-netral-50 p-2 rounded-lg border border-netral-100">
                                                    <i class="fa-solid fa-location-dot mr-2 text-accent"></i>
                                                    <span class="block truncate"
                                                        title="{{ strip_tags($report->lokasi_terakhir_dilihat) }}">
                                                        {{ strip_tags($report->lokasi_terakhir_dilihat) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex {{ $viewMode === 'grid' ? '' : 'justify-end' }}">
                                            <a href="{{ route('detail-missing', [strtolower($report->report_type), $report->slug]) }}"
                                                class="flex items-center justify-center bg-dark hover:bg-primary text-white font-bold text-sm py-2 rounded-lg transition-all duration-300 {{ $viewMode === 'grid' ? 'w-full' : 'w-fit px-4' }}">Detail
                                                Laporan</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="flex-1 flex flex-col items-center justify-center bg-netral-50 rounded-3xl border-2 border-dashed border-netral-200 p-10 text-center min-h-[460px]">
                            <i class="fa-solid fa-magnifying-glass text-5xl text-netral-300 mb-4"></i>
                            <p class="text-netral-500 font-bold text-xl">Tidak ada hasil ditemukan</p>
                            <p class="text-netral-400 mb-6">Coba ubah kata kunci atau gunakan tombol reset untuk
                                mencari
                                ulang.</p>
                            <button wire:click="resetFilters" class="text-primary font-semibold hover:underline">
                                Reset Filter
                            </button>
                        </div>
                    @endif
                </div>
                <div class="mt-8 p-4">
                    {{ $reports->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <!-- MAP SECTION -->
    <div class="mt-20 pt-10">
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-dark">Peta</h2>
            <p class="text-netral-500 max-w-2xl mx-auto leading-relaxed mt-2">
                Laporan hilang di sekitarmu
            </p>
            <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
        </div>

        <!-- Map Container -->
        <div class="relative mt-4">
            <!-- Maps container -->
            <div id="map" wire:ignore
                class="relative z-10 w-full h-80 rounded-xl shadow-inner border bg-netral-100">
            </div>

            <!-- Overlay untuk Loading & Permission Denied - Style sama -->
            <div id="map-overlay"
                class="absolute inset-0 z-20 bg-netral-100/95 backdrop-blur-sm rounded-xl border flex flex-col items-center justify-center">

                <!-- Loading State -->
                <div id="overlay-loading" class="flex flex-col items-center justify-center">
                    <div class="relative">
                        <div class="animate-spin rounded-full h-12 w-12 border-4 border-netral-200 border-t-primary">
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-primary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-netral-500 font-medium mt-4">Mendeteksi lokasi Anda...</p>
                    <p class="text-netral-400 text-xs mt-1">Mohon izinkan akses lokasi</p>
                </div>

                <!-- Permission Denied State - Style sama seperti loading -->
                <div id="overlay-denied" class="hidden flex flex-col items-center justify-center">
                    <div class="relative mb-4">
                        <div class="w-12 h-12 rounded-full bg-danger/10 flex items-center justify-center">
                            <i class="fa-solid fa-location-pin-lock text-danger text-xl"></i>
                        </div>
                    </div>
                    <p class="text-netral-600 font-medium">Akses lokasi ditolak</p>
                    <p class="text-netral-400 text-xs mt-1 mb-4">Izinkan akses untuk melihat laporan di sekitar</p>

                    <button onclick="retryLocationPermission()"
                        class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white font-semibold text-sm px-5 py-2.5 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-rotate-right"></i>
                        Izinkan Lokasi
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        let map;
        let markers = [];
        let userLocation = null;
        let isMapInitialized = false;

        // Default location (Jakarta Pusat - Monas)
        const DEFAULT_LOCATION = {
            lat: -6.1754,
            lng: 106.8272,
            name: 'Jakarta Pusat',
            zoom: 12
        };

        document.addEventListener('livewire:init', () => {
            Livewire.on('refreshMap', (payload) => {
                const reports = payload.reports || payload;
                if (!map) return;

                // Clear existing markers
                markers.forEach(m => map.removeLayer(m));
                markers = [];

                // Add markers for reports
                reports.forEach(r => {
                    const popupContent = `
                        <div class="popup-card" style="min-width: 220px; font-family: sans-serif;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                <strong style="font-size: 14px; color: #1e293b; max-width: 140px; overflow: hidden; text-overflow: ellipsis;">${r.name}</strong>
                                <span style="font-size: 10px; background: ${r.type === 'Hilang' ? '#fee2e2' : '#dcfce7'}; color: ${r.type === 'Hilang' ? '#991b1b' : '#166534'}; padding: 2px 8px; border-radius: 999px; font-weight: 600; text-transform: uppercase;">
                                    ${r.type}
                                </span>
                            </div>

                            <p style="font-size: 12px; color: #475569; margin: 4px 0 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                ${r.description || '<em style="color: #94a3b8;">Tanpa deskripsi</em>'}
                            </p>

                            <div style="font-size: 11px; color: #64748b; margin-bottom: 8px; display: flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-location-dot" style="color: #f59e0b;"></i>
                                <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 180px;">${r.location}</span>
                            </div>

                            <div style="display: flex; gap: 8px; align-items: center; font-size: 11px; justify-content: space-between;">
                                <span style="color: #2563eb; font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-route"></i> ${r.distance} km
                                </span>
                                ${r.url ? `<a href="${r.url}" style="color: #059669; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 4px;">Detail <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i></a>` : ''}
                            </div>
                        </div>
                    `;

                    const marker = L.marker([r.lat, r.lng])
                        .addTo(map)
                        .bindPopup(popupContent, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });

                    markers.push(marker);
                });
            });

            // Initialize map on load
            initMap();
        });

        function initMap() {
            const overlay = document.getElementById('map-overlay');
            const loadingState = document.getElementById('overlay-loading');
            const deniedState = document.getElementById('overlay-denied');

            // Reset states
            loadingState.classList.remove('hidden');
            deniedState.classList.add('hidden');
            overlay.classList.remove('hidden');

            // Check if geolocation is supported
            if (!navigator.geolocation) {
                loadingState.classList.add('hidden');
                deniedState.classList.remove('hidden');
                showNotification('Browser tidak mendukung geolocation', 'error');
                return;
            }

            // Try to get user location
            navigator.geolocation.getCurrentPosition(
                // SUCCESS
                (position) => {
                    const {
                        latitude,
                        longitude
                    } = position.coords;
                    userLocation = {
                        lat: latitude,
                        lng: longitude
                    };

                    // HIDE OVERLAY - ini yang diperbaiki
                    overlay.classList.add('hidden');

                    // Initialize map with user location
                    initializeMap(latitude, longitude, 15, true);
                },
                // ERROR
                (error) => {
                    console.error('Geolocation error:', error);

                    if (error.code === 1) {
                        // PERMISSION_DENIED - tampilkan state ditolak
                        loadingState.classList.add('hidden');
                        deniedState.classList.remove('hidden');
                    } else if (error.code === 2) {
                        // POSITION_UNAVAILABLE
                        showNotification('Lokasi tidak tersedia', 'warning');
                        overlay.classList.add('hidden');
                        initializeMap(DEFAULT_LOCATION.lat, DEFAULT_LOCATION.lng, DEFAULT_LOCATION.zoom, false);
                    } else if (error.code === 3) {
                        // TIMEOUT
                        showNotification('Waktu habis', 'warning');
                        overlay.classList.add('hidden');
                        initializeMap(DEFAULT_LOCATION.lat, DEFAULT_LOCATION.lng, DEFAULT_LOCATION.zoom, false);
                    } else {
                        showNotification('Error tidak dikenal', 'error');
                        overlay.classList.add('hidden');
                        initializeMap(DEFAULT_LOCATION.lat, DEFAULT_LOCATION.lng, DEFAULT_LOCATION.zoom, false);
                    }
                },
                // OPTIONS
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        }

        function retryLocationPermission() {
            const overlay = document.getElementById('map-overlay');
            const loadingState = document.getElementById('overlay-loading');
            const deniedState = document.getElementById('overlay-denied');

            // Show loading, hide denied
            deniedState.classList.add('hidden');
            loadingState.classList.remove('hidden');

            // Try again
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const {
                        latitude,
                        longitude
                    } = position.coords;
                    userLocation = {
                        lat: latitude,
                        lng: longitude
                    };

                    // HIDE OVERLAY
                    overlay.classList.add('hidden');

                    // Remove old map and create new one
                    if (map) {
                        map.remove();
                        map = null;
                        markers = [];
                    }

                    initializeMap(latitude, longitude, 15, true);
                    showNotification('Lokasi berhasil didapatkan!', 'success');
                },
                (error) => {
                    if (error.code === 1) {
                        // Still denied - tetap tampilkan denied state
                        loadingState.classList.add('hidden');
                        deniedState.classList.remove('hidden');
                        showNotification('Permission masih ditolak', 'error');
                    } else {
                        // Error lain, gunakan default
                        overlay.classList.add('hidden');
                        if (map) {
                            map.remove();
                            map = null;
                            markers = [];
                        }
                        initializeMap(DEFAULT_LOCATION.lat, DEFAULT_LOCATION.lng, DEFAULT_LOCATION.zoom, false);
                    }
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        }

        function initializeMap(lat, lng, zoom, isUserLocation = false) {
            // Dispatch to Livewire
            Livewire.dispatch('setUserLocation', {
                lat: lat,
                lng: lng
            });

            // Create map
            map = L.map('map', {
                zoomControl: true,
                dragging: true,
                touchZoom: true,
                scrollWheelZoom: true,
                doubleClickZoom: true,
                boxZoom: true
            }).setView([lat, lng], zoom);

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Custom marker icon
            const markerHtml = isUserLocation ?
                `<div style="background-color: #2563eb; width: 28px; height: 28px; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); position: relative;">
                     <div style="position: absolute; inset: -8px; border: 2px solid #2563eb; border-radius: 50%; animation: pulse 2s infinite;"></div>
                   </div>` :
                `<div style="background-color: #f59e0b; width: 28px; height: 28px; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);"></div>`;

            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: markerHtml,
                iconSize: [28, 28],
                iconAnchor: [14, 14],
                popupAnchor: [0, -14]
            });

            // Add marker
            const popupText = isUserLocation ? 'Lokasi Anda' : `Lokasi Default: ${DEFAULT_LOCATION.name}`;
            L.marker([lat, lng], {
                    icon: customIcon
                })
                .addTo(map)
                .bindPopup(popupText)
                .openPopup();

            // Add radius circle for user location
            if (isUserLocation) {
                L.circle([lat, lng], {
                    radius: 3000,
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.1,
                    weight: 2,
                    dashArray: '5, 10'
                }).addTo(map);
            }

            // Add pulse animation style
            if (!document.getElementById('map-pulse-style')) {
                const style = document.createElement('style');
                style.id = 'map-pulse-style';
                style.textContent = `
                    @keyframes pulse {
                        0% { transform: scale(1); opacity: 1; }
                        100% { transform: scale(1.5); opacity: 0; }
                    }
                    .custom-popup .leaflet-popup-content-wrapper {
                        border-radius: 12px;
                        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
                    }
                    .custom-popup .leaflet-popup-content {
                        margin: 0;
                        padding: 0;
                    }
                    .custom-popup .leaflet-popup-tip {
                        background: white;
                    }
                `;
                document.head.appendChild(style);
            }

            isMapInitialized = true;

            // Load reports
            Livewire.dispatch('loadNearbyReports');
        }

        function showNotification(message, type = 'info') {
            const colors = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning text-dark',
                info: 'bg-primary'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-circle-xmark',
                warning: 'fa-triangle-exclamation',
                info: 'fa-circle-info'
            };

            const toast = document.createElement('div');
            toast.className =
                `fixed bottom-6 right-6 ${colors[type]} text-white px-5 py-3 rounded-xl shadow-2xl z-50 transform transition-all duration-500 translate-y-20 opacity-0 flex items-center gap-3 min-w-[300px] max-w-md`;
            toast.innerHTML = `
                <i class="fa-solid ${icons[type]} text-lg"></i>
                <span class="text-sm font-medium">${message}</span>
            `;

            document.body.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-20', 'opacity-0');
            });

            // Remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // Handle tab visibility change
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden && map) {
                map.invalidateSize();
            }
        });
    </script>
@endpush
