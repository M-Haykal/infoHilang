@if ($paginator->hasPages())
<nav role="navigation" class="flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-4 w-full max-w-5xl mx-auto">

    {{-- Info Menampilkan (di atas saat mobile, kiri saat di laptop) --}}
    <div class="order-2 lg:order-1">
        <p class="text-sm text-netral-500 text-center lg:text-left">
            Menampilkan <span class="font-bold text-primary">{{ $paginator->firstItem() }}</span> - <span class="font-bold text-primary">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-netral-500">{{ $paginator->total() }}</span> laporan
        </p>
    </div>

    {{-- Nomor Halaman (di bawah saat mobile, kanan saat di laptop) --}}
    <div class="order-1 lg:order-2">
        <span class="relative z-0 inline-flex flex-wrap justify-center shadow-sm rounded-xl overflow-hidden border border-netral-200">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-2 bg-slate-50 text-netral-300 cursor-default border-r border-netral-100">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 bg-white text-netral-500 hover:bg-netral-50 border-r border-netral-100 transition-colors">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            @endif

            {{-- Nomor Halaman (Muncul di semua ukuran) --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="relative inline-flex items-center px-4 py-2 bg-white text-netral-500 cursor-default border-r border-netral-100 text-sm">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="relative inline-flex items-center px-4 py-2 bg-primary text-white font-bold text-sm border-r border-primary">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 bg-white text-netral-600 hover:bg-netral-50 border-r border-netral-100 text-sm transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 bg-white text-netral-500 hover:bg-netral-50 transition-colors">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="relative inline-flex items-center px-3 py-2 bg-netral-50 text-netral-300 cursor-default">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </span>
            @endif
        </span>
    </div>
</nav>
@endif
