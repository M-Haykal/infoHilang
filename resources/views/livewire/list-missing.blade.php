<div class="py-20 max-w-7xl mx-auto px-4">
    <!-- PageHeading -->
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-dark">Daftar Hilang <span class="text-primary">&amp;</span> Ditemukan</h2>
        <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
    </div>

    <div class="relative">
        <!-- SearchBar -->
        <div class="sticky top-[72px] z-40 bg-netral-50 backdrop-blur-md py-4 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <label class="flex flex-col min-w-40 h-14 w-full">
                    <div class="flex w-full flex-1 items-stretch rounded-2xl h-full shadow-lg bg-white border border-netral-200">
                        <div class="text-netral-500 flex items-center justify-center pl-5">
                            <i class="fa-solid fa-magnifying-glass text-xl"></i>
                        </div>
                        <input wire:model.live.debounce.500ms="search" wire:key="search-input-{{ $search === '' ? 'empty' : 'active' }}" class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-2xl text-dark border-none bg-transparent h-full px-4 pl-3 text-base font-medium placeholder:text-netral-500 focus:outline-none focus:ring-0 focus:border-none focus:shadow-none" placeholder="Cari barang, hewan, atau orang..." type="text" />
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
                        <button wire:click="resetFilters" class="text-sm font-medium text-primary hover:underline transition-colors">
                            Reset
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:flex lg:flex-col gap-6">

                        <!-- Status Filter -->
                        <div class="col-span-1" wire:key="filter-status-container">
                            <h4 class="text-sm font-bold mb-3 text-dark">Status</h4>

                            <div class="lg:hidden">
                                <select wire:model.live="status" wire:key="select-status-{{ $status === '' ? 'reset' : 'active' }}" class="w-full rounded-lg border border-netral-200 text-sm font-medium p-3 transition-all text-netral-500 focus:border-primary focus:ring-primary focus:outline-none">
                                    <option value="">Semua Status</option>
                                    <option value="Hilang">Hilang</option>
                                    <option value="Ditemukan">Ditemukan</option>
                                </select>
                            </div>

                            <div class="hidden lg:flex flex-col gap-2">
                                @foreach (['' => 'Semua Status', 'Hilang' => 'Hilang', 'Ditemukan' => 'Ditemukan'] as $val => $label)
                                <label wire:key="wrapper-status-{{ $val }}" class="flex items-center gap-3 rounded-lg border p-3 cursor-pointer transition-colors {{ $status === $val ? 'border-primary bg-primary/50' : 'border-netral-200 hover:border-primary/50' }}">

                                    <input wire:model.live="status" wire:key="radio-status-{{ $val }}-{{ $status === $val ? 'active' : 'inactive' }}" type="radio" name="status_group_desktop" value="{{ $val }}" class="h-4 w-4 text-primary focus:ring-primary cursor-pointer" />

                                    <p class="text-sm font-medium {{ $status === $val ? 'text-primary' : 'text-netral-500' }}">
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
                                <select wire:model.live="kategori" wire:key="select-kategori-{{ $kategori === '' ? 'reset' : 'active' }}" class="w-full rounded-lg border border-netral-200 text-sm font-medium p-3 transition-all text-netral-500 focus:border-primary focus:ring-primary focus:outline-none">
                                    <option value="">Semua Kategori</option>
                                    <option value="Barang">Barang</option>
                                    <option value="Hewan">Hewan</option>
                                    <option value="Orang">Orang</option>
                                </select>
                            </div>

                            <div class="hidden lg:flex flex-col gap-2">
                                @foreach (['' => 'Semua Kategori', 'Barang' => 'Barang', 'Hewan' => 'Hewan', 'Orang' => 'Orang'] as $val => $label)
                                <label wire:key="wrapper-kategori-{{ $val }}" class="flex items-center gap-3 rounded-lg border p-3 cursor-pointer transition-colors {{ $kategori === $val ? 'border-primary bg-primary/50 shadow-sm' : 'border-netral-200 hover:border-primary/50' }}">

                                    <input wire:model.live="kategori" wire:key="input-kategori-{{ $val }}-{{ $kategori === $val ? 'on' : 'off' }}" value="{{ $val }}" name="kategori_radio_group" type="radio" class="h-4 w-4 text-primary focus:ring-primary cursor-pointer" />

                                    <p class="text-sm font-medium {{ $kategori === $val ? 'text-primary' : 'text-netral-500' }}">
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
                                    <i class="fa-solid fa-location-dot {{ $lokasi ? 'text-primary' : 'text-netral-400' }} transition-colors"></i>
                                </div>
                                <input wire:model.live.debounce.500ms="lokasi" wire:key="filter-lokasi-{{ $lokasi ? 'active' : 'empty' }}" class="form-input w-full rounded-lg border-netral-300 text-sm font-medium {{ $lokasi ? 'text-primary' : 'text-netral-500' }} bg-netral-100 pl-10 py-2 transition-all focus:outline-none focus:border-netral-100" placeholder="Jakarta Selatan" type="text" />
                            </div>
                        </div>

                        <!-- Date Filter -->
                        <div class="col-span-1">
                            <h4 class="text-sm font-bold mb-3 text-dark">Tanggal Dilaporkan</h4>
                            <div class="relative">
                                <div onclick="document.getElementById('filter-date').showPicker()" class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fa-solid fa-calendar {{ $date ? 'text-primary' : 'text-netral-400' }} transition-colors"></i>
                                </div>
                                <input id="filter-date" wire:model.live="date" wire:key="filter-date-{{ $date ? 'active' : 'empty' }}" class="form-input w-full rounded-lg border-netral-300 text-sm font-medium {{ $date ? 'text-primary' : 'text-netral-500' }} bg-netral-100 pl-10 py-2 transition-all focus:outline-none focus:border-netral-100" type="date" onclick="this.showPicker()" />
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="w-full lg:w-3/4 xl:w-4/5 flex flex-col">
                <div class="flex items-center justify-end py-2 sticky top-[152px] z-30 pt-3">
                    <div class="flex items-center gap-1 bg-netral-100 p-1 rounded-xl">
                        <button wire:click="setView('grid')" class="p-2 rounded-lg transition-all {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-primary' : 'text-netral-400 hover:text-netral-500' }}">
                            <i class="fa-solid fa-grip text-lg"></i>
                        </button>
                        <button wire:click="setView('list')" class="p-2 rounded-lg transition-all {{ $viewMode === 'list' ? 'bg-white shadow-sm text-primary' : 'text-netral-400 hover:text-netral-500' }}">
                            <i class="fa-solid fa-list text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="flex-1 flex flex-col mt-4">
                    @if ($reports->count() > 0)
                    <div class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 sm:grid-cols-3 gap-6' : 'flex flex-col gap-4' }}">
                        @foreach ($reports as $report)
                        <div class="group flex {{ $viewMode === 'grid' ? 'flex-col' : 'flex-row' }} overflow-hidden rounded-2xl border bg-white shadow-sm hover:shadow-md transition-all duration-300">

                            <div class="relative overflow-hidden {{ $viewMode === 'grid' ? 'w-full aspect-square' : 'w-[36%] md:w-48 flex-shrink-0' }}">
                                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset($report->foto[0] ?? 'default.jpg') }}" alt="{{ $report->report_name }}" />

                                <span class="absolute top-3 left-3 {{ $report->status == 'Hilang' ? 'bg-danger' : 'bg-success' }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    {{ strtoupper($report->status) }}
                                </span>
                            </div>

                            <div class="{{ $viewMode === 'grid' ? 'w-full' : 'w-2/3 md:w-48' }} flex flex-1 flex-col p-5 justify-between">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-lg font-bold text-dark">{{ $report->report_name }}
                                        </h3>
                                        @if ($viewMode === 'list')
                                        <span class="hidden md:block text-[10px] text-netral-400 font-medium tracking-widest">{{ $report->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <p class="text-sm text-netral-500 line-clamp-2 mb-2">
                                            {{ $report->deskripsi ?? 'Klik detail untuk melihat deskripsi lengkap laporan ini.' }}
                                        </p>
                                        <div class="flex items-center text-xs text-netral-500 bg-netral-50 p-2 rounded-lg border border-netral-100">
                                            <i class="fa-solid fa-location-dot mr-2 text-accent"></i>
                                            <span class="truncate">{{ $report->lokasi_terakhir_dilihat }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 flex {{ $viewMode === 'grid' ? '' : 'justify-end' }}">
                                    <a href="" class="flex items-center justify-center bg-dark hover:bg-dark-hover text-white font-bold text-sm py-2 rounded-lg transition {{ $viewMode === 'grid' ? 'w-full' : 'w-fit px-4' }}">Detail
                                        Laporan</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex-1 flex flex-col items-center justify-center bg-netral-50 rounded-3xl border-2 border-dashed border-netral-200 p-10 text-center min-h-[460px]">
                        <i class="fa-solid fa-magnifying-glass text-5xl text-netral-300 mb-4"></i>
                        <p class="text-netral-500 font-bold text-xl">Tidak ada hasil ditemukan</p>
                        <p class="text-netral-400 mb-6">Coba ubah kata kunci atau gunakan tombol reset untuk mencari
                            ulang.</p>
                        <button wire:click="resetFilters" class="text-primary font-semibold hover:underline">
                            Reset Filter
                        </button>
                    </div>
                    @endif
                    <div class="mt-8 p-4">
                        {{ $reports->links('vendor.pagination.tailwind') }}
                    </div>
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
        <div id="map" wire:ignore class="relative z-10 w-full h-64 mt-4 rounded-lg shadow-inner border mb-6">
        </div>
    </div>
</div>

@push('script')
<script>
    let map;
    let markers = [];

    document.addEventListener('livewire:init', () => {
        navigator.geolocation.getCurrentPosition(pos => {
            Livewire.dispatch('setUserLocation', [
                pos.coords.latitude, pos.coords.longitude
            ]);

            map = L.map('map').setView(
                [pos.coords.latitude, pos.coords.longitude], 14
            );

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
                .addTo(map);

            L.marker([pos.coords.latitude, pos.coords.longitude])
                .addTo(map)
                .bindPopup('Lokasi Anda')
                .openPopup();

            const radiusKm = 5; // ubah ke 1–5 sesuai kebutuhan
            const radiusMeter = radiusKm * 1000;

            window.radiusCircle = L.circle([pos.coords.latitude, pos.coords.longitude], {
                radius: radiusMeter
                , color: '#2563eb'
                , fillColor: '#3b82f6'
                , fillOpacity: 0.15
                , weight: 2
            }).addTo(map);
        });
    });

    Livewire.on('refreshMap', reports => {
        markers.forEach(m => map.removeLayer(m));
        markers = [];

        reports.forEach(r => {
            const marker = L.marker([r.lat, r.lng])
                .addTo(map)
                .bindPopup(`${r.type} • ${r.distance} km`);
            markers.push(marker);
        });
    });

</script>
@endpush
