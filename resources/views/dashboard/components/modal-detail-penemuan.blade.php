@props(['laporans'])

{{-- LOOPING MODAL JEJAK --}}
@forelse($laporans as $laporan)
<div id="modal-jejak-{{ $laporan->id }}" class="h-full hidden fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">

    {{-- Backdrop Hitam --}}
    <div onclick="closeModalJejak('modal-jejak-{{ $laporan->id }}')" class="absolute inset-0 bg-dark/60 backdrop-blur-sm cursor-pointer"></div>

    {{-- Kotak Modal --}}
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300 z-10">

        {{-- Header Modal --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-netral-100 bg-white z-10">
            <h3 class="font-bold text-dark uppercase text-xs tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-location text-primary"></i> Detail Penemuan
            </h3>
            <button type="button" onclick="closeModalJejak('modal-jejak-{{ $laporan->id }}')" class="w-8 h-8 flex items-center justify-center rounded-full bg-netral-50 text-netral-400 hover:bg-danger hover:text-white transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-6 no-scrollbar bg-netral-50/30">

            {{-- Info Penemu & Waktu --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-netral-100 shadow-sm">
                    <p class="text-[10px] text-netral-400 uppercase font-bold tracking-widest mb-1">Informasi Penemu</p>
                    <p class="text-sm font-black text-dark">{{ $laporan->nama_penemu }}</p>
                    <p class="text-xs text-primary font-bold mt-1">
                        <i class="fa-solid fa-phone-volume mr-1"></i> {{ $laporan->kontak_penemu }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-netral-100 shadow-sm">
                    <p class="text-[10px] text-netral-400 uppercase font-bold tracking-widest mb-1">Waktu Penemuan</p>
                    <p class="text-sm font-black text-dark">{{ \Carbon\Carbon::parse($laporan->tanggal_ditemukan)->translatedFormat('d F Y') }}</p>
                    <p class="text-xs text-dark font-medium mt-1">
                        <i class="fa-regular fa-clock text-netral-400 mr-1"></i> Pukul {{ \Carbon\Carbon::parse($laporan->tanggal_ditemukan)->format('H:i') }}
                    </p>
                </div>
            </div>

            {{-- Lokasi & Keterangan --}}
            <div class="bg-white p-5 rounded-2xl border border-netral-100 shadow-sm space-y-4">
                <div>
                    <p class="text-[10px] text-netral-400 uppercase font-bold tracking-widest mb-1">Lokasi Ditemukan</p>
                    <p class="text-sm font-bold text-dark"><i class="fa-solid fa-location-dot text-danger mr-1"></i> {{ $laporan->lokasi_ditemukan }}</p>
                </div>
                <div class="pt-4 border-t border-netral-50">
                    <p class="text-[10px] text-netral-400 uppercase font-bold tracking-widest mb-2">Keterangan / Kronologi</p>
                    <p class="text-sm text-dark leading-relaxed">
                        {{ $laporan->keterangan ?: 'Tidak ada keterangan tambahan yang diberikan.' }}
                    </p>
                </div>
            </div>

            {{-- Bukti Foto --}}
            <div>
                <p class="text-[10px] text-netral-400 uppercase font-bold tracking-widest mb-3">Bukti Foto Penemuan</p>
                @php
                    $buktiImages = is_string($laporan->bukti_ditemukan) ? json_decode($laporan->bukti_ditemukan, true) : $laporan->bukti_ditemukan;
                @endphp

                @if(is_array($buktiImages) && count($buktiImages) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($buktiImages as $img)
                            <a href="{{ asset('storage/' . $img) }}" target="_blank" class="block relative aspect-square rounded-2xl overflow-hidden bg-netral-100 border border-netral-200 group">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </a>
                        @endforeach
                    </div>
                @elseif(is_string($buktiImages) && !empty($buktiImages))
                    <a href="{{ asset('storage/' . $buktiImages) }}" target="_blank" class="block relative w-full sm:w-1/2 aspect-square rounded-2xl overflow-hidden bg-netral-100 border border-netral-200 group">
                        <img src="{{ asset('storage/' . $buktiImages) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </a>
                @else
                    <div class="w-full py-12 bg-white rounded-2xl border border-dashed border-netral-200 flex flex-col items-center justify-center text-netral-400">
                        <i class="fa-solid fa-image-slash text-3xl mb-2 opacity-50"></i>
                        <p class="text-xs font-bold uppercase tracking-widest">Tidak ada foto bukti</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- Footer Modal (Action Buttons) --}}
        <div class="px-6 py-4 border-t border-netral-100 bg-white flex flex-col sm:flex-row items-center justify-end gap-3 z-10">
            <button type="button" onclick="closeModalJejak('modal-jejak-{{ $laporan->id }}')" class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-bold text-xs text-netral-500 hover:bg-netral-100 transition-colors">
                Tutup
            </button>

            @if(!$laporan->is_confirmed)
            <form action="" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full px-6 py-2.5 rounded-xl font-bold text-xs bg-success text-white shadow-lg shadow-success/30 hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check-double"></i> Konfirmasi Valid
                </button>
            </form>
            @endif
        </div>

    </div>
</div>
@empty
@endforelse

@once
<script>
    function openModalJejak(modalId) {
        const modal = document.getElementById(modalId);
        if(modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModalJejak(modalId) {
        const modal = document.getElementById(modalId);
        if(modal) {
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>
@endonce
