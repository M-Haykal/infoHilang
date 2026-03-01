@extends('dashboard.layouts.index')

@section('title', 'Buat Artikel Baru | InfoHilang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1 isolate">
        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Buat Artikel Baru</h1>
            <p class="text-xs font-medium text-netral-400 mt-2">Berbagi edukasi atau tips pencarian untuk komunitas.</p>
        </div>

        <div class="order-1 lg:order-2 flex justify-center lg:justify-end">
            <a href="{{ route('artikel') }}"
            class="relative z-[60] inline-flex items-center gap-2 px-5 py-2.5 bg-white text-netral-500 border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-dark hover:border-dark hover:shadow-md transition-all group active:scale-95">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf

            <!-- Judul -->
            <div class="mb-6">
                <label for="judul_artikel" class="block text-sm font-semibold text-dark mb-2">Judul Artikel</label>
                <input type="text" id="judul_artikel" name="judul_artikel" value="{{ old('judul_artikel') }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('judul_artikel') border-danger @enderror" placeholder="Contoh: Tips Aman Menemukan Kucing" required>
                @error('judul_artikel')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Gambar --}}
            <div>
                @include('dashboard.components.photo', [
                    'max' => 1,
                    'multiple' => true,
                    'foto' => $blog->images ?? []
                ])
            </div>

            {{-- Trix Editor --}}
            <div>
                <label for="isi_artikel" class="block text-sm font-semibold text-dark mb-2">Isi Artikel</label>
                <input id="isi_artikel" type="hidden" name="isi_artikel">
                <trix-editor input="isi_artikel" class="trix-content min-h-[300px] max-w-none px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm prose transition-all outline-none @error('isi_artikel') border-danger @enderror"></trix-editor>
            </div>

            <div class="flex justify-end gap-3 pt-6">
                <a href="{{ route('artikel') }}" class="px-6 py-3 text-lg font-semibold text-netral-500">Batal</a>
                <button type="submit" class="px-10 py-4 bg-primary text-white text-lg font-bold rounded-xl hover:bg-primary-dark hover:shadow-primary hover:-translate-y-0.5 transition-all shadow-lg flex items-center justify-center group active:scale-95">
                    <i class="fa-regular fa-circle-check mr-2"></i>
                    Terbitkan Artikel
                </button>
            </div>
        </form>
    </div>

</div>

@stack('scripts')
<script>
    document.addEventListener("trix-file-accept", function(event) {
        // Off-in fungsi drag-and-drop gambar
        event.preventDefault();
        alert("Fitur upload gambar langsung di editor belum tersedia.");
    });

</script>

<style>
    /* Hide tombol attachment di toolbar */
    .trix-button--icon-attach {
        display: none !important;
    }

</style>
@endsection
