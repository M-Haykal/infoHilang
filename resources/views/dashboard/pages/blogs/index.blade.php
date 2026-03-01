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
                    <thead>
                        <tr class="bg-netral-50/50 border-b border-netral-100">
                            <th class="px-6 py-4 font-medium text-sm text-netral-500">Artikel</th>
                            <th class="px-6 py-4 font-medium text-sm text-netral-500">Tanggal Publish</th>
                            <th class="px-6 py-4 font-medium text-sm text-netral-500">Penulis</th>
                            <th class="px-6 py-4 font-medium text-sm text-netral-500 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-netral-50">
                        @forelse($blogs as $blog)
                        <tr class="hover:bg-netral-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-12 rounded-md overflow-hidden bg-netral-100 shrink-0 border border-netral-50">
                                        <img src="{{ asset('storage/' . $blog->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="max-w-xs">
                                        <p class="text-sm font-bold text-dark leading-tight truncate">{{ $blog->title }}</p>

                                        <p class="text-[10px] text-netral-400 font-medium mt-1 truncate">
                                            {{ Str::limit(strip_tags($blog->content), 60) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-bold text-dark">{{ $blog->created_at->translatedFormat('d M Y') }}</p>
                                <p class="text-[10px] text-netral-400 font-medium uppercase">{{ $blog->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-6 h-6 rounded-full bg-accent-surface flex items-center justify-center text-accent text-[10px] font-bold">
                                        {{ strtoupper(substr($blog->user->fullname ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="text-xs font-bold text-dark">{{ $blog->user->fullname ?? 'Admin' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('artikel.show', $blog->slug) }}" class="w-8 h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-primary hover:border-primary transition-all shadow-sm">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('artikel.edit', $blog->slug) }}"
                                        class="w-8 h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-yellow-500 hover:border-yellow-500 transition-all shadow-sm"
                                        data-confirm-edit
                                        data-title="Edit Artikel"
                                        data-message="Apakah kamu ingin mengubah data artikel ini?">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('artikel.destroy', $blog->slug) }}" method="POST"
                                        data-confirm-delete
                                        data-title="Hapus Artikel"
                                        data-message="Data ini akan dihapus secara permanen!"
                                        >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-white border border-netral-200 flex items-center justify-center text-netral-400 hover:text-danger hover:border-danger transition-all shadow-sm">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="py-20 flex flex-col items-center justify-center text-center">
                                    <div class="mb-6 group">
                                        <i class="fa-solid fa-newspaper text-4xl text-netral-400 group-hover:text-primary/20 transition-colors duration-500"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-dark">Belum ada artikel</h3>
                                    <p class="text-xs text-netral-400 mt-1">Mulai tulis pengalaman atau tipsmu.</p>
                                    <a href="{{ route('artikel.create') }}" class="mt-6 px-6 py-2 bg-primary text-white text-sm font-bold rounded-lg shadow-lg hover:scale-105 transition-all">Tulis Artikel</a>
                                </div>
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
