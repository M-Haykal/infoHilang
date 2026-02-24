@extends('dashboard.layouts.index')

@section('title', $blog->title . ' | InfoHilang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-6 p-1">
        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto flex-1">
            <h1 class="text-3xl font-bold text-dark mb-4">{{ $blog->title }}</h1>
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6">
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
        </div>

        <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-50 pointer-events-auto">
            <a href="{{ route('artikel') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-netral-500 border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-dark hover:border-dark hover:shadow-md transition-all group active:scale-95">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 sm:p-8">
        <div class="relative aspect-video rounded-lg overflow-hidden border border-netral-100 mb-3">
            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
        </div>

        <div class="mb-6 prose prose-lg max-w-none
            prose-headings:text-dark prose-headings:font-black prose-headings:tracking-tight
            prose-p:text-dark prose-p:leading-relaxed prose-p:text-base
            prose-strong:text-dark prose-strong:font-bold
            prose-img:rounded-xl">

            {!! $blog->content !!}

        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <p class="text-[10px] text-netral-400 text-center md:text-left">
                Bagikan informasi ini untuk membantu sesama pengguna InfoHilang.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button class="text-netral-400 hover:text-primary transition-all">
                <i class="fa-brands fa-whatsapp"></i>
            </button>
            <button class="text-netral-400 hover:text-primary transition-all">
                <i class="fa-solid fa-link"></i>
            </button>
        </div>
    </div>
    </div>


</div>
@endsection
