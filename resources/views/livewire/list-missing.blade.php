<div class="py-20 max-w-7xl mx-auto px-4">
    <!-- PageHeading -->
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">Daftar Hilang <span
                class="text-blue-600">&amp;</span> Ditemukan</h2>
        <div class="w-20 h-1 bg-orange-500 mx-auto mt-4"></div>
    </div>

    <!-- SearchBar -->
    <div class="sticky top-[72px] z-40 bg-slate-50 backdrop-blur-md py-4 transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            <label class="flex flex-col min-w-40 h-14 w-full">
                <div
                    class="flex w-full flex-1 items-stretch rounded-2xl h-full shadow-lg bg-white dark:bg-secondary border border-slate-200">
                    <div class="text-slate-400 flex items-center justify-center pl-5">
                        <i class="fa-solid fa-magnifying-glass text-xl"></i>
                    </div>
                    <input wire:model.live.debounce.500ms="search"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-2xl text-slate-800
           border-none bg-transparent h-full px-4 pl-3 text-base font-medium
           placeholder:text-slate-400
           /* Hilangkan Semua Outline/Border/Ring saat Active */
           focus:outline-none focus:ring-0 focus:border-none focus:shadow-none"
                        placeholder="Cari barang, hewan, atau orang..." type="text" />
                </div>
            </label>
        </div>
    </div>

    <div class="flex flex-col gap-8 lg:flex-row">
        <!-- Filters Sidebar -->
        <aside class="w-full lg:w-1/4 xl:w-1/5 py-4">
            <div class="sticky top-[160px] z-30 bg-white rounded-xl shadow-md p-5 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold leading-tight tracking-[-0.015em] text-gray-800 dark:text-black">Filter
                    </h3>
                    <button wire:click="resetFilters"
                        class="text-sm font-medium text-primary hover:underline transition-colors">
                        Reset
                    </button>
                </div>

                <div class="flex flex-col gap-6">
                    <!-- Status Filter -->
                    <div>
                        <h4 class="text-base font-bold mb-3 text-black-700 dark:text-black-300">Status</h4>
                        <div class="flex flex-col gap-2">
                            <label
                                class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-600 p-3 cursor-pointer hover:border-primary/50 transition-colors">
                                <input wire:model.live="status" value="Hilang" name="status"
                                    class="h-4 w-4 text-primary focus:ring-primary" type="radio" />
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-600">Hilang</p>
                            </label>
                            <label
                                class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-600 p-3 cursor-pointer hover:border-primary/50 transition-colors">
                                <input wire:model.live="status" value="Ditemukan" name="status"
                                    class="h-4 w-4 text-primary focus:ring-primary" type="radio" />
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-600">Ditemukan</p>
                            </label>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <h4 class="text-base font-bold mb-3 text-black-700 dark:text-black-300">Kategori</h4>
                        <div class="flex flex-col gap-2">
                            <label
                                class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-600 p-3 cursor-pointer hover:border-primary/50 transition-colors">
                                <input wire:model.live="kategori" value="Barang" name="kategori"
                                    class="h-4 w-4 text-primary focus:ring-primary" type="radio" />
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-600">Barang</p>
                            </label>
                            <label
                                class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-600 p-3 cursor-pointer hover:border-primary/50 transition-colors">
                                <input wire:model.live="kategori" value="Hewan" name="kategori"
                                    class="h-4 w-4 text-primary focus:ring-primary" type="radio" />
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-600">Hewan</p>
                            </label>
                            <label
                                class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-600 p-3 cursor-pointer hover:border-primary/50 transition-colors">
                                <input wire:model.live="kategori" value="Orang" name="kategori"
                                    class="h-4 w-4 text-primary focus:ring-primary" type="radio" />
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-600">Orang</p>
                            </label>
                            <label
                                class="flex items-center gap-3 rounded-lg border border-gray-200 dark:border-gray-600 p-3 cursor-pointer hover:border-primary/50 transition-colors">
                                <input wire:model.live="kategori" value="" name="kategori"
                                    class="h-4 w-4 text-primary focus:ring-primary" type="radio" />
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-600">Semua Kategori</p>
                            </label>
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <h4 class="text-base font-bold mb-3 text-black-700 dark:text-black-300">Lokasi</h4>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                            </div>
                            <input wire:model.live.debounce.500ms="lokasi"
                                class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-100 focus:border-primary focus:ring-primary/50 pl-10 py-2 text-sm"
                                placeholder="e.g. Jakarta Selatan" type="text" />
                        </div>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <h4 class="text-base font-bold mb-3 text-black-700 dark:text-black-300">Tanggal Dilaporkan</h4>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fa-solid fa-calendar text-gray-400"></i>
                            </div>
                            <input wire:model.live="date"
                                class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-100 focus:border-primary focus:ring-primary/50 pl-10 py-2 text-sm"
                                type="date" />
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <div class="w-full lg:w-3/4 xl:w-4/5">
            {{-- <div class="flex items-center justify-between py-2 bg-slate-50 backdrop-blur-md sticky top-[152px] z-30">
                <p class="text-sm text-slate-500 font-medium">Menampilkan <span class="text-slate-900">{{ $reports->count() }}</span> dari {{ $reports->total() }} hasil</p>
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                    <button wire:click="setView('grid')" class="p-2 rounded-lg transition-all {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-grip text-lg"></i>
                    </button>
                    <button wire:click="setView('list')" class="p-2 rounded-lg transition-all {{ $viewMode === 'list' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-list text-lg"></i>
                    </button>
                </div>
            </div> --}}
            <div class="flex items-center justify-end py-2 sticky top-[152px] z-30 pt-3">
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                    <button wire:click="setView('grid')"
                        class="p-2 rounded-lg transition-all {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-orange-600' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-grip text-lg"></i>
                    </button>
                    <button wire:click="setView('list')"
                        class="p-2 rounded-lg transition-all {{ $viewMode === 'list' ? 'bg-white shadow-sm text-orange-600' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-list text-lg"></i>
                    </button>
                </div>
            </div>

            <div
                class="py-4 {{ $viewMode === 'grid' ? 'grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-3 gap-6' : 'flex flex-col gap-4' }}">
                @forelse ($reports as $report)
                    <div
                        class="group flex {{ $viewMode === 'grid' ? 'flex-col' : 'flex-row' }} overflow-hidden rounded-2xl border bg-white shadow-sm hover:shadow-md transition-all duration-300">

                        <div
                            class="relative overflow-hidden {{ $viewMode === 'grid' ? 'w-full aspect-square' : 'w-[36%] md:w-48 flex-shrink-0' }}">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="{{ asset($report->foto[0] ?? 'default.jpg') }}" alt="{{ $report->report_name }}" />

                            <span
                                class="absolute top-3 left-3 {{ $report->status == 'Hilang' ? 'bg-red-600' : 'bg-green-600' }} text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ strtoupper($report->status) }}
                            </span>
                        </div>

                        <div
                            class="{{ $viewMode === 'grid' ? 'w-full' : 'w-2/3 md:w-48' }} flex flex-1 flex-col p-5 justify-between">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">{{ $report->report_name }}</h3>
                                    @if ($viewMode === 'list')
                                        <span
                                            class="hidden md:block text-[10px] text-slate-400 font-medium tracking-widest">{{ $report->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    <p class="text-sm text-slate-500 line-clamp-2 mb-2">
                                        {{ $report->deskripsi ?? 'Klik detail untuk melihat deskripsi lengkap laporan ini.' }}
                                    </p>
                                    <div
                                        class="flex items-center text-xs text-slate-600 bg-slate-50 p-2 rounded-lg border border-slate-100">
                                        <i class="fa-solid fa-location-dot mr-2 text-green-600"></i>
                                        <span class="truncate">{{ $report->lokasi_terakhir_dilihat }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex {{ $viewMode === 'grid' ? '' : 'justify-end' }}">
                                <a href=""
                                    class="flex items-center justify-center bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm py-2 rounded-lg transition {{ $viewMode === 'grid' ? 'w-full' : 'w-fit px-4' }}">Detail
                                    Laporan</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                        <i class="fa-solid fa-magnifying-glass text-5xl text-slate-300 mb-4"></i>
                        <p class="text-slate-500 font-bold text-xl">Tidak ada hasil ditemukan</p>
                        <p class="text-slate-400">Coba ubah kata kunci atau reset filter Anda.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 p-4">
                {{ $reports->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
    <!-- MAP SECTION -->
    <div class="px-4 mt-6">
        <h1 class="text-3xl font-black">Peta</h1>
        <p class="">Laporan hilang di sekitarmu</p>
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
                    radius: radiusMeter,
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.15,
                    weight: 2
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
