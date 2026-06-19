@extends('dashboard.layouts.index')

@section('title', 'Customer Service Chats | InfoHilang Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-dark">Customer Service Chats</h1>
            <p class="text-sm text-netral-500 mt-1">Tanggapi percakapan dengan user secara realtime</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm text-netral-500">
                <span class="inline-block w-2 h-2 rounded-full bg-danger mr-1"></span>
                {{ $totalUnread }} percakapan belum dibaca
            </span>
        </div>
    </div>

    {{-- Daftar Percakapan --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-netral-50 border-b">
                        <th class="text-left px-4 py-3 font-bold text-dark">User</th>
                        <th class="text-left px-4 py-3 font-bold text-dark">Pesan Terakhir</th>
                        <th class="text-left px-4 py-3 font-bold text-dark">Waktu</th>
                        <th class="text-center px-4 py-3 font-bold text-dark">Status</th>
                        <th class="text-center px-4 py-3 font-bold text-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($conversations as $conv)
                        <tr class="hover:bg-netral-50 transition {{ $conv['unread_count'] > 0 ? 'bg-primary-light/10' : '' }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        @if ($conv['is_guest'])
                                            <i class="fa-solid fa-user"></i>
                                        @else
                                            {{ strtoupper(substr($conv['user_name'], 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-dark">{{ $conv['user_name'] }}</p>
                                        <p class="text-xs text-netral-500">{{ $conv['is_guest'] ? 'Guest' : $conv['user_email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-dark truncate max-w-[200px]">{{ $conv['last_message'] ?: '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-netral-500 text-xs">
                                {{ $conv['last_message_at'] ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($conv['unread_count'] > 0)
                                    <span class="inline-flex items-center gap-1 bg-danger text-white text-xs font-bold px-2 py-1 rounded-full">
                                        <i class="fa-solid fa-circle text-[6px]"></i>
                                        {{ $conv['unread_count'] }} baru
                                    </span>
                                @else
                                    <span class="text-netral-400 text-xs">
                                        <i class="fa-regular fa-circle-check mr-1"></i> Dibaca
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.customer-chats.show', $conv['identifier']) }}"
                                    class="inline-flex items-center gap-1 bg-primary text-white px-3 py-1.5 rounded-lg text-xs hover:bg-primary-dark transition">
                                    <i class="fa-solid fa-reply"></i> Balas
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-netral-500">
                                <i class="fa-solid fa-comments text-4xl text-netral-300 mb-3 block"></i>
                                <p>Belum ada percakapan</p>
                                <p class="text-xs mt-1">Percakapan akan muncul ketika user mengirim pesan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Realtime update: tambah baris baru tanpa reload halaman
    if (window.Echo) {
        window.Echo.private('chat.admin')
            .listen('.NewCustomerChatMessage', (e) => {
                // Update total unread di header
                const unreadEl = document.querySelector('.text-netral-500 span.bg-danger');
                // Reload halaman secara halus setiap 5 detik jika ada pesan baru
                // (karena data tabel cukup kompleks untuk diupdate manual)
                const tbody = document.querySelector('tbody');
                if (tbody) {
                    // Refresh tabel via fetch tanpa reload penuh
                    fetch(window.location.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTbody = doc.querySelector('tbody');
                        const newUnread = doc.querySelector('.text-netral-500 .bg-danger');
                        
                        if (newTbody) {
                            tbody.innerHTML = newTbody.innerHTML;
                        }
                        
                        // Update unread badge di header - cari parent span yang tepat
                        const headerUnread = document.querySelector('.flex.items-center.gap-2 .text-netral-500');
                        if (headerUnread && newUnread) {
                            headerUnread.innerHTML = newUnread.outerHTML;
                        }
                    })
                    .catch(() => {});
                }
            });
    }
</script>
@endpush
