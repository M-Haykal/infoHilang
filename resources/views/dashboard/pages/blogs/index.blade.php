@extends('dashboard.layouts.index')

@section('title', 'Artikel | InfoHilang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Daftar Artikel</h1>
            <p class="text-xs font-medium text-netral-400 mt-2">Kelola dan publikasikan artikel bermanfaat untuk mempercepat proses penemuan.</p>
        </div>
        <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-20 pointer-events-auto">
            <a href="{{ route('artikel.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white border border-primary rounded-xl font-bold text-sm hover:bg-primary-dark hover:border-primary-dark hover:shadow-lg hover:shadow-primary-dark hover:scale-105 transition-all group active:scale-95">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
                <span>Tambah Artikel</span>
            </a>
        </div>
    </div>
    <section class="max-w-6xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead class="">
                        <tr class="border-b border-netral-100">
                            <th class="px-6 py-4 font-medium text-sm text-netral-500">Artikel</th>
                            <th class="hidden md:table-cell px-6 py-4 font-medium text-sm text-netral-500">Tanggal Publish</th>
                            @if(auth()->user()->role === 'admin')
                            <th class="hidden md:table-cell px-6 py-4 font-medium text-sm text-netral-500">Penulis</th>
                            @endif
                            <th class="hidden md:table-cell px-6 py-4 font-medium text-sm text-netral-500 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-netral-50 flex flex-col md:table-row-group">
                        @forelse($blogs as $blog)
                        <tr class="hover:bg-netral-50/30 transition-colors group flex flex-col md:table-row p-4 md:p-0 relative">
                            {{-- Kolom Artikel --}}
                            <td class="px-0 md:px-6 py-2 md:py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-14 md:w-16 md:h-12 rounded-lg overflow-hidden bg-netral-100 shrink-0 border border-netral-50">
                                        <img src="{{ asset('storage/' . $blog->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="max-w-xs">
                                        <p class="text-sm font-bold text-dark leading-tight line-clamp-2 md:truncate">{{ $blog->title }}</p>
                                        <p class="hidden md:block text-netral-500 text-[10px] font-medium mt-1 truncate">
                                            {{ Str::limit(strip_tags($blog->content), 60) }}
                                        </p>
                                        {{-- Info tanggal muncul di bawah judul hanya saat mobile --}}
                                        <p class="md:hidden text-netral-500 text-[10px] uppercase mt-1 font-bold">
                                            {{ $blog->created_at->translatedFormat('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Tanggal (hide di mobile karena dipindah ke atas) --}}
                            <td class="hidden md:table-cell px-6 py-4">
                                <p class="text-xs font-bold text-dark">{{ $blog->created_at->translatedFormat('d M Y H:i') }}</p>
                                <p class="text-netral-500 text-[10px]">{{ $blog->created_at->diffForHumans() }}</p>
                            </td>

                            @if(auth()->user()->role === 'admin')
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if(auth()->id() === $blog->user_id)
                                    {{-- Jika Admin melihat artikel buatannya sendiri --}}
                                    <div class="flex items-center gap-2 px-2 py-1 bg-primary/5 rounded-lg border border-primary/10">
                                        <i class="fa-solid fa-user-check text-[10px] text-primary"></i>
                                        <span class="text-[10px] font-bold text-primary uppercase tracking-tight">Saya</span>
                                    </div>
                                    @else
                                    {{-- Jika Admin melihat artikel buatan user lain --}}
                                    <div class="w-6 h-6 rounded-full bg-netral-100 flex items-center justify-center text-netral-400 text-[10px] font-black border border-netral-200">
                                        {{ strtoupper(substr($blog->user->fullname ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="text-xs font-bold text-dark">{{ $blog->user->fullname ?? 'User' }}</span>
                                    @endif
                                </div>
                            </td>
                            @endif

                            {{-- Kolom Aksi --}}
                            <td class="px-0 md:px-6 py-4 md:py-4">
                                <div class="flex flex-col md:flex-row items-end md:items-center md:justify-center gap-2">
                                    <div class="flex items-center justify-end md:justify-center gap-2 w-full md:w-auto">
                                        <a href="{{ route('artikel.show', $blog->slug) }}" class="flex-1 md:flex-none h-9 md:w-8 md:h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-primary hover:border-primary transition-all shadow-sm gap-2 px-3 md:px-0">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                            <span class="md:hidden text-[10px] font-bold">Lihat</span>
                                        </a>

                                        <a href="{{ route('artikel.edit', $blog->slug) }}" class="flex-1 md:flex-none h-9 md:w-8 md:h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-yellow-500 hover:border-yellow-500 transition-all shadow-sm gap-2 px-3 md:px-0">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            <span class="md:hidden text-[10px] font-bold">Edit</span>
                                        </a>

                                        <form action="{{ route('artikel.destroy', $blog->slug) }}" method="POST" class="flex-1 md:flex-none">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full md:w-8 h-9 md:h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-danger hover:border-danger transition-all shadow-sm gap-2">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                <span class="md:hidden text-[10px] font-bold">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="flex flex-col">
                            <td class="px-6 py-20 text-center">
                                <div class="mb-6 group">
                                    <i class="fa-solid fa-newspaper text-4xl text-netral-400 group-hover:text-primary/20 transition-colors duration-500"></i>
                                </div>
                                <h3 class="text-lg font-bold text-dark">Belum ada artikel</h3>
                                <p class="text-xs text-netral-400 mt-1">Mulai tulis pengalaman atau tipsmu.</p>
                                <a href="{{ route('artikel.create') }}" class="mt-6 px-6 py-2 bg-primary text-white text-sm font-bold rounded-lg shadow-lg hover:scale-105 transition-all">Tulis Artikel</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
