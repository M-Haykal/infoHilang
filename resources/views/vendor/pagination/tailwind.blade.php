@if ($paginator->hasPages())
<nav role="navigation" class="flex items-center justify-between border-t border-netral-100 pt-6">
    {{-- Tampilan Mobile (Hanya Panah) --}}
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-netral-400 bg-white border border-netral-200 cursor-default leading-5 rounded-xl shadow-sm">
            <i class="fa-solid fa-chevron-left"></i>
        </span>
        @else
        {{-- Sesuaikan wire:click jika menggunakan Livewire, atau href jika menggunakan Controller --}}
        <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-netral-500 bg-white border border-netral-200 leading-5 rounded-xl hover:bg-netral-50 transition shadow-sm">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        @endif

        @if ($paginator->hasMorePages())
        <button wire:click="nextPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-netral-500 bg-white border border-netral-200 leading-5 rounded-xl hover:bg-netral-50 transition shadow-sm">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        @else
        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-netral-400 bg-white border border-netral-200 cursor-default leading-5 rounded-xl shadow-sm">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        @endif
    </div>

    {{-- Tampilan Desktop (Nomor Halaman) --}}
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-netral-500">
                Menampilkan <span class="font-bold text-primary">{{ $paginator->firstItem() }}</span> - <span class="font-bold text-primary">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-netral-500">{{ $paginator->total() }}</span> hasil
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-xl overflow-hidden border border-netral-200">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-2 bg-slate-50 text-netral-300 cursor-default border-r border-netral-100">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </span>
                @else
                <button wire:click="previousPage" class="relative inline-flex items-center px-3 py-2 bg-white text-netral-500 hover:bg-slate-50 border-r border-netral-100 transition-colors">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($elements as $element)
                @if (is_string($element))
                <span class="relative inline-flex items-center px-4 py-2 bg-white text-netral-500 cursor-default border-r border-netral-100 text-sm">{{ $element }}</span>
                @endif

                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span class="relative inline-flex items-center px-4 py-2 bg-primary text-white font-bold text-sm border-r border-primary">{{ $page }}</span>
                @else
                <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 bg-white text-netral-600 hover:bg-slate-50 border-r border-netral-100 text-sm transition-colors">{{ $page }}</button>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="relative inline-flex items-center px-3 py-2 bg-white text-netral-500 hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
                @else
                <span class="relative inline-flex items-center px-3 py-2 bg-slate-50 text-netral-300 cursor-default">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
