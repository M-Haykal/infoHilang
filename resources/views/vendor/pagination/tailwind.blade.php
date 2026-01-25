@if ($paginator->hasPages())
<nav role="navigation" class="flex items-center justify-between">
    {{-- Tampilan Mobile (Hanya Panah) --}}
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-netral-400 bg-white border border-netral-300 cursor-default leading-5 rounded-xl shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            </span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-netral-500 bg-white border border-netral-300 leading-5 rounded-xl hover:bg-netral-50 transition shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            </button>
        @endif

        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-netral-500 bg-white border border-netral-300 leading-5 rounded-xl hover:bg-netral-50 transition shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
            </button>
        @else
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-netral-400 bg-white border border-netral-300 cursor-default leading-5 rounded-xl shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
            </span>
        @endif
    </div>

    {{-- Tampilan Desktop (Nomor Halaman) --}}
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-netral-500">
                Menampilkan <span class="font-bold text-accent">{{ $paginator->firstItem() }}</span> sampai <span class="font-bold text-accent">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-netral-500">{{ $paginator->total() }}</span> hasil
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-xl overflow-hidden border border-netral-300">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-3 py-2 bg-white text-netral-300 cursor-default">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="relative inline-flex items-center px-3 py-2 bg-white text-netral-500 hover:bg-netral-50">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </button>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="relative inline-flex items-center px-4 py-2 bg-white text-netral-500 cursor-default">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="relative inline-flex items-center px-4 py-2 bg-accent text-white font-bold">{{ $page }}</span>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 bg-white text-netral-500 hover:bg-netral-50 border-l border-netral-200">{{ $page }}</button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" class="relative inline-flex items-center px-3 py-2 bg-white text-netral-500 hover:bg-netral-50 border-l border-netral-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </button>
                @else
                    <span class="relative inline-flex items-center px-3 py-2 bg-white text-netral-300 cursor-default border-l border-netral-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
