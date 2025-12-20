<div class="w-full max-w-7xl py-20">
    <!-- PageHeading -->
    <div class="flex flex-wrap justify-between gap-3 p-4">
        <p class="text-4xl font-black leading-tight tracking-[-0.033em] min-w-72">
            Daftar Hilang &amp; Ditemukan
        </p>
    </div>

    <!-- MAP SECTION -->
    <div class="px-4 mt-6">
        <h1 class="text-3xl font-black">Peta</h1>
        <p class="">Laporan hilang di sekitarmu</p>
        <div id="map" wire:ignore class="w-full h-64 mt-4 rounded-lg shadow-inner border mb-6 z-[-1]"></div>
    </div>

    <!-- SearchBar -->
    <div class="px-4 py-3">
        <label class="flex flex-col min-w-40 h-14 w-full">
            <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm bg-white dark:bg-secondary">
                <div class="text-text-secondary flex items-center justify-center pl-4">
                    <i class="fa-solid fa-magnifying-glass text-2xl"></i>
                </div>
                <input wire:model.live.debounce.500ms="search"
                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-text-primary dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border-none bg-transparent h-full placeholder:text-text-secondary px-4 pl-2 text-base font-normal leading-normal dark:placeholder:text-gray-500"
                    placeholder="Cari barang, hewan, atau orang..." type="text" />
            </div>
        </label>
    </div>

    <div class="flex flex-col gap-8 lg:flex-row">
        <!-- Filters Sidebar -->
        <aside class="w-full lg:w-1/4 xl:w-1/5 p-4">
            <div
                class="sticky top-24 bg-white dark:bg-secondary-800 rounded-xl shadow-md p-5 border border-gray-200 dark:border-gray-700">
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

        <!-- Gallery Grid -->
        <div class="w-full lg:w-3/4 xl:w-4/5">
            <div class="flex items-center justify-between p-4">
                <p class="text-sm text-text-secondary">
                    Menampilkan {{ $reports->count() }} dari {{ $reports->total() }} hasil
                </p>
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-lg bg-primary/20 text-primary dark:bg-primary/30 dark:text-white">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                    <button
                        class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <i class="fa-solid fa-list"></i>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 p-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($reports as $report)
                    <div
                        class="flex flex-col overflow-hidden rounded-xl border {{ $report->status == 'Hilang' ? 'border-danger/200' : 'border-success/200' }} bg-white dark:bg-gray-800 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
                        <div class="relative">
                            <img class="aspect-square w-full object-cover"
                                src="{{ asset('storage/' . $report->foto[0] ?? 'default.jpg') }}"
                                alt="{{ $report->report_name }}" />

                            <span
                                class="absolute top-3 left-3 inline-flex items-center rounded-full {{ $report->status == 'Hilang' ? 'bg-danger' : 'bg-success' }} px-3 py-1 text-xs font-bold text-white">
                                {{ strtoupper($report->status) }}
                            </span>

                            <span
                                class="absolute top-3 right-3 inline-flex items-center rounded-full bg-primary/20 text-primary px-3 py-1 text-xs font-bold">
                                {{ strtoupper($report->report_type) }}
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-4 bg-secondary/90">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $report->report_name }}</h3>
                            <div class="mt-2 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $report->location }}</span>
                            </div>
                            <div class="mt-1 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <i class="fa-solid fa-calendar"></i>
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            <a href=""
                                class="mt-4 w-full flex items-center justify-center rounded-lg h-10 px-4 bg-primary/20 text-primary dark:bg-primary/30 dark:text-white text-sm font-bold hover:bg-primary/30 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <i class="fa-solid fa-search text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada laporan ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex items-center justify-center p-4">
                {{ $reports->links() }}
            </div>
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
                    pos.coords.latitude,
                    pos.coords.longitude
                ]);

                map = L.map('map').setView(
                    [pos.coords.latitude, pos.coords.longitude],
                    14
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
