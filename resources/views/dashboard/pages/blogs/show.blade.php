@extends('dashboard.layouts.index')

@section('title', $blog->title . ' | InfoHilang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Detail Artikel</h1>
            <nav class="flex justify-center lg:justify-start mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 text-xs font-medium text-netral-400">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li>
                        <a href="{{ route('artikel') }}" class="hover:text-primary transition-colors">Artikel</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    </li>
                    <li class="text-primary font-bold italic">Detail Artikel</li>
                </ol>
            </nav>
        </div>

        <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-20 pointer-events-auto">
            <a href="{{ route('artikel') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-netral-500 border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-dark hover:border-dark hover:shadow-md transition-all group active:scale-95">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 sm:p-8">
        <h1 class="text-3xl lg:text-4xl font-bold text-dark mb-4">{{ $blog->title }}</h1>

        <div class="flex flex-wrap items-center gap-6 mb-6">
            <div class="flex items-center gap-2 lg:gap-3">
                <div class="w-10 h-10 lg:w-6 lg:h-6 rounded-full bg-accent-surface flex items-center justify-center text-accent text-xs lg:text-[9px] font-bold border border-accent/10">
                    {{ strtoupper(substr($blog->user->fullname, 0, 1)) }}
                </div>

                <div class="text-left">
                    <p class="text-[10px] font-bold text-netral-400 uppercase tracking-widest lg:hidden">Penulis</p>
                    <p class="text-xs font-bold text-dark leading-none mt-1 lg:mt-0">
                        {{ $blog->user->fullname }}
                    </p>
                </div>
            </div>

            <div class="h-6 w-px bg-netral-100 hidden lg:block"></div>

            <div class="text-left">
                <p class="text-[10px] font-bold text-netral-400 uppercase tracking-widest lg:hidden">Diterbitkan</p>
                <p class="text-xs font-bold text-dark lg:text-netral-500 leading-none mt-1 lg:mt-0">
                    {{ $blog->created_at->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>

        @if($blog->image)
        <div class="relative aspect-video rounded-lg overflow-hidden border border-netral-100 mb-4 shadow-inner">
            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
        </div>
        @endif

        <div class="prose prose-lg max-w-none
            prose-headings:text-dark prose-headings:font-black prose-headings:tracking-tight
            prose-p:text-dark/80 prose-p:leading-relaxed prose-p:text-base
            prose-strong:text-dark prose-strong:font-bold
            prose-img:rounded-2xl prose-img:shadow-md">

            {!! $blog->content !!}
        </div>

        <div class="mt-10 pt-8 border-t border-netral-50 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <p class="text-[11px] font-medium text-netral-400 text-center md:text-left leading-relaxed">
                    Bagikan informasi ini untuk membantu sesama pengguna <span class="text-primary font-bold">InfoHilang</span>.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-full bg-netral-50 text-netral-400 hover:bg-success/10 hover:text-success transition-all shadow-sm">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full bg-netral-50 text-netral-400 hover:bg-primary/10 hover:text-primary transition-all shadow-sm">
                    <i class="fa-solid fa-link text-sm"></i>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
