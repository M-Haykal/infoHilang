<div class="tab-content p-6">
    <!-- Barang Hilang Tab -->
    <div id="tab-barang" class="tab-pane active">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-dark">Barang Hilang</h3>
            <span class="bg-blue-100 text-primary text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $missingItems->count() }} barang
            </span>
        </div>

        <div class="space-y-4">
            @forelse ($missingItems as $item)
            <div class="flex flex-wrap flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-accent/50 rounded-lg border border-netral-200 hover:shadow-md transition-all duration-300">

                <div class="flex space-x-4 mb-4 sm:mb-0">
                    <div class="flex-shrink-0">
                        <img src="{{ asset($item->foto[0] ?? 'default.jpg') }}" alt="Barang" class="w-16 h-16 object-cover rounded-lg border border-netral-200">
                    </div>

                    <div>
                        {{-- Nama dan Status --}}
                        <div class="flex items-center flex-wrap gap-2">
                            <h4 class="font-bold text-dark text-lg leading-none">{{ $item->nama_barang }}</h4>

                            <div class="inline-flex">
                                @if ($item->status == 'Hilang')
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-danger text-white">
                                    {{ $item->status }}
                                </span>
                                @elseif($item->status == 'Ditemukan')
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-success text-white">
                                    {{ $item->status }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-yellow-600 text-white">
                                    {{ $item->status }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Lokasi dan Tanggal--}}
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex text-xs">
                                <i class="fa-solid fa-calendar mt-1 mr-1 text-accent"></i>
                                <span class="text-netral-500">{{ date('d M Y H:i',
                                    strtotime($item->tanggal_terakhir_dilihat)) }}</span>
                            </span>
                            <span title="Lokasi terakhir dilihat" class="flex text-xs sm:min-w-0 sm:flex-none sm:max-w-[280px]">
                                <i class="fa-solid fa-location-dot mt-1 mr-1 text-accent sm:flex-shrink-0"></i>
                                <span class="text-netral-500">{{ $item->lokasi_terakhir_dilihat }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 sm:ml-auto sm:self-center justify-end">
                    <a href="{{ route('form-barang-hilang.detail', $item->slug) }}" class="inline-flex items-center px-3 py-2 text-sm bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                        <i class="fa-solid fa-eye mr-1"></i>
                        Detail
                    </a>
                    <a href="{{ route('form-barang-hilang.edit', $item->slug) }}" class="inline-flex items-center px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition" data-confirm-edit>
                        <i class="fa-solid fa-pencil mr-1"></i>
                        Edit
                    </a>
                    <form action="{{ route('form-barang-hilang.destroy', $item->slug) }}" method="POST" data-confirm-delete class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm bg-danger text-white rounded-lg hover:bg-danger-dark transition">
                            <i class="fa-solid fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fa-solid fa-box text-5xl text-netral-300 mb-4"></i>
                <h3 class="mt-4 text-lg font-medium text-netral-500">Belum ada laporan barang hilang</h3>
                <p class="mt-1 text-netral-400">Anda belum membuat laporan barang hilang.</p>
                <div class="mt-6">
                    <a href="{{ route('form-barang-hilang') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark">
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        @if ($missingItems->count() > 0)
        <div class="mt-8 flex justify-center ajax-pagination">
            {{ $missingItems->appends(request()->except('page_item'))->links('vendor.pagination.dashboard') }}
        </div>
        @endif
    </div>

    <!-- Orang Hilang Tab -->
    <div id="tab-orang" class="tab-pane hidden">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-dark">Orang Hilang</h3>
            <span class="bg-blue-100 text-primary text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $missingPersons->count() }} orang
            </span>
        </div>

        <div class="space-y-4">
            @forelse ($missingPersons as $missingPerson)
            <div class="flex flex-wrap flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-accent/50 rounded-lg border border-netral-200 hover:shadow-md transition-all duration-300">
                <div class="flex space-x-4 mb-4 sm:mb-0">
                    <div class="flex-shrink-0">
                        <img src="{{ asset($missingPerson->foto[0] ?? 'default.jpg') }}" alt="Orang" class="w-16 h-16 object-cover rounded-lg border border-netral-200">
                    </div>

                    <div>
                        {{-- Nama dan Status --}}
                        <div class="flex items-center flex-wrap gap-2">
                            <h4 class="font-bold text-dark text-lg leading-none">{{ $missingPerson->nama_orang }}</h4>

                            <div class="inline-flex">
                                @if ($missingPerson->status == 'Hilang')
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-danger text-white">
                                    {{ $missingPerson->status }}
                                </span>
                                @elseif($missingPerson->status == 'Ditemukan')
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-success text-white">
                                    {{ $missingPerson->status }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-yellow-600 text-white">
                                    {{ $missingPerson->status }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Lokasi dan Tanggal--}}
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex text-xs">
                                <i class="fa-solid fa-calendar mt-1 mr-1 text-accent"></i>
                                <span class="text-netral-500">{{ date('d M Y H:i',
                                    strtotime($missingPerson->tanggal_terakhir_dilihat)) }}</span>
                            </span>
                            <span title="Lokasi terakhir dilihat" class="flex text-xs sm:min-w-0 sm:flex-none sm:max-w-[280px]">
                                <i class="fa-solid fa-location-dot mt-1 mr-1 text-accent sm:flex-shrink-0"></i>
                                <span class="text-netral-500">{{ $missingPerson->lokasi_terakhir_dilihat }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 sm:ml-auto sm:self-center justify-end">
                    <a href="{{ route('form-orang-hilang.print-pdf', ['orangHilang' => $missingPerson->slug]) }}" class="inline-flex items-center px-3 py-2 text-sm bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
                        <i class="fa-solid fa-print mr-1"></i>
                        Cetak Poster
                    </a>

                    <a href="{{ route('form-orang-hilang.detail', $missingPerson->slug) }}" class="inline-flex items-center px-3 py-2 text-sm bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                        <i class="fa-solid fa-eye mr-1"></i>
                        Detail
                    </a>

                    <a href="{{ route('form-orang-hilang.edit', $missingPerson->slug) }}" class="inline-flex items-center px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition" data-confirm-edit>
                        <i class="fa-solid fa-pencil mr-1"></i>
                        Edit
                    </a>

                    <form action="{{ route('form-orang-hilang.destroy', $missingPerson->slug) }}" method="POST" data-confirm-delete class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm bg-danger text-white rounded-lg hover:bg-danger-dark transition">
                            <i class="fa-solid fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fa-solid fa-box text-5xl text-netral-300 mb-4"></i>
                <h3 class="mt-4 text-lg font-medium text-netral-500">Belum ada laporan orang hilang</h3>
                <p class="mt-1 text-netral-400">Anda belum membuat laporan orang hilang.</p>
                <div class="mt-6">
                    <a href="{{ route('form-orang-hilang') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark">
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        @if ($missingPersons->count() > 0)
        <div class="mt-8 flex justify-center ajax-pagination">
            {{ $missingPersons->appends(request()->except('page_person'))->links('vendor.pagination.dashboard') }}
        </div>
        @endif
    </div>

    <!-- Hewan Hilang Tab -->
    <div id="tab-hewan" class="tab-pane hidden">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-dark">Hewan Hilang</h3>
            <span class="bg-blue-100 text-primary text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $missingAnimals->count() }} hewan
            </span>
        </div>

        <div class="space-y-4">
            @forelse ($missingAnimals as $missingAnimal)
            <div class="flex flex-wrap flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-accent/50 rounded-lg border border-netral-200 hover:shadow-md transition-all duration-300">
                <div class="flex space-x-4 mb-4 sm:mb-0">
                    <div class="flex-shrink-0">
                        <img src="{{ asset($missingAnimal->foto[0] ?? 'default.jpg') }}" alt="Hewan" class="w-16 h-16 object-cover rounded-lg border border-netral-200">
                    </div>
                    <div>
                        {{-- Nama dan Status --}}
                        <div class="flex items-center flex-wrap gap-2">
                            <h4 class="font-bold text-dark text-lg leading-none">{{ $missingAnimal->nama_hewan }}</h4>

                            <div class="inline-flex">
                                @if ($missingAnimal->status == 'Hilang')
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-danger text-white">
                                    {{ $missingAnimal->status }}
                                </span>
                                @elseif($missingAnimal->status == 'Ditemukan')
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-success text-white">
                                    {{ $missingAnimal->status }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-0.3 rounded-full text-[10px] font-bold bg-yellow-600 text-white">
                                    {{ $missingAnimal->status }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Lokasi dan Tanggal--}}
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex text-xs">
                                <i class="fa-solid fa-calendar mt-1 mr-1 text-accent"></i>
                                <span class="text-netral-500">{{ date('d M Y H:i',
                                    strtotime($missingAnimal->tanggal_terakhir_dilihat)) }}</span>
                            </span>
                            <span title="Lokasi terakhir dilihat" class="flex text-xs sm:min-w-0 sm:flex-none sm:max-w-[280px]">
                                <i class="fa-solid fa-location-dot mt-1 mr-1 text-accent sm:flex-shrink-0"></i>
                                <span class="text-netral-500">{{ $missingAnimal->lokasi_terakhir_dilihat }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 sm:ml-auto sm:self-center justify-end">

                    <a href="" class="inline-flex items-center px-3 py-2 text-sm bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
                        <i class="fa-solid fa-print mr-1"></i>
                        Cetak Poster
                    </a>

                    <a href="" class="inline-flex items-center px-3 py-2 text-sm bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                        <i class="fa-solid fa-eye mr-1"></i>
                        Detail
                    </a>

                    <a href="" class="inline-flex items-center px-3 py-2 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition" data-confirm-edit>
                        <i class="fa-solid fa-pencil mr-1"></i>
                        Edit
                    </a>

                    <form action="" method="POST" data-confirm-delete class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm bg-danger text-white rounded-lg hover:bg-danger-dark transition">
                            <i class="fa-solid fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fa-solid fa-box text-5xl text-netral-300 mb-4"></i>
                <h3 class="mt-4 text-lg font-medium text-netral-500">Belum ada laporan hewan hilang</h3>
                <p class="mt-1 text-netral-400">Anda belum membuat laporan hewan hilang.</p>
                <div class="mt-6">
                    <a href="{{ route('form-hewan-hilang') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark">
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        @if ($missingAnimals->count() > 0)
        <div class="mt-8 flex justify-center ajax-pagination">
            {{ $missingAnimals->appends(request()->except('page_animal'))->links('vendor.pagination.dashboard') }}
        </div>
        @endif
    </div>
</div>
