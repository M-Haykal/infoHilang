@extends('dashboard.layouts.index')

@section('title', 'Detail Chat | InfoHilang Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.customer-chats.index') }}" class="text-netral-500 hover:text-primary transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-dark">Percakapan: {{ $conversationName }}</h1>
            <p class="text-sm text-netral-500 mt-1">Balas pesan user secara realtime</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[600px]">
        {{-- Daftar Percakapan --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-4 border-b bg-netral-50">
                <h3 class="font-bold text-dark">Percakapan Lain</h3>
            </div>
            <div class="flex-1 overflow-y-auto" id="conversationList">
                <div class="p-4 text-center text-netral-500 text-sm">
                    <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat...
                </div>
            </div>
        </div>

        {{-- Area Chat --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
            {{-- Header --}}
            <div class="p-4 border-b bg-netral-50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($conversationName, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-bold text-dark" id="chatUserName">{{ $conversationName }}</h3>
                    <p class="text-xs text-netral-500" id="chatUserStatus">
                        {{ $userId ? 'User Terdaftar' : 'Guest' }}
                    </p>
                </div>
            </div>

            {{-- Messages --}}
            <div class="flex-1 overflow-y-auto p-4 bg-netral-50 space-y-3" id="chatMessages">
                @forelse ($messages as $msg)
                    @php
                        $isUser = $msg->sender_type === 'user';
                    @endphp
                    <div class="flex {{ $isUser ? 'justify-end' : 'justify-start' }} message-item" data-id="{{ $msg->id }}">
                        <div class="max-w-[70%] {{ $isUser ? 'bg-primary text-white rounded-2xl rounded-tr-sm' : 'bg-white border rounded-2xl rounded-tl-sm' }} px-4 py-2 shadow-sm">
                            <p class="text-sm {{ $isUser ? 'text-white' : 'text-dark' }}">{{ $msg->message }}</p>
                            <p class="text-[10px] mt-1 {{ $isUser ? 'text-white/70' : 'text-netral-400' }}">{{ $msg->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-netral-500 text-sm mt-20" id="emptyMessage">
                        <i class="fa-solid fa-comments text-4xl text-netral-300 mb-3"></i>
                        <p>Belum ada pesan</p>
                    </div>
                @endforelse
            </div>

            {{-- Input Reply (AJAX) --}}
            <div class="p-4 border-t bg-white">
                <form id="replyForm" class="flex gap-3">
                    @csrf
                    <input type="text" name="message" id="replyInput" required
                        class="flex-1 border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Ketik pesan balasan..." autofocus>
                    <button type="submit" id="sendReplyBtn"
                        class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-primary-dark transition font-medium">
                        <i class="fa-solid fa-paper-plane mr-1"></i> Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const identifier = '{{ $identifier }}';
        const chatMessages = document.getElementById('chatMessages');
        const replyForm = document.getElementById('replyForm');
        const replyInput = document.getElementById('replyInput');
        const sendBtn = document.getElementById('sendReplyBtn');

        // Scroll to bottom
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Auto focus input
        if (replyInput) {
            replyInput.focus();
        }

        // ========== KIRIM PESAN VIA AJAX ==========
        replyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = replyInput.value.trim();
            if (!message) return;

            // Disable button sementara
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mengirim...';

            fetch('{{ route("admin.customer-chats.reply", $identifier) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Tambah bubble pesan admin langsung tanpa nunggu broadcast
                    const bubble = createMessageBubble(message, 'admin');
                    chatMessages.appendChild(bubble);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    replyInput.value = '';
                    replyInput.focus();
                } else {
                    alert('Gagal mengirim pesan');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan');
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fa-solid fa-paper-plane mr-1"></i> Kirim';
            });
        });

        function createMessageBubble(text, senderType) {
            const isAdmin = senderType === 'admin';
            const div = document.createElement('div');
            div.className = `flex ${isAdmin ? 'justify-start' : 'justify-end'} message-item`;
            div.innerHTML = `
                <div class="max-w-[70%] ${isAdmin ? 'bg-white border rounded-2xl rounded-tl-sm' : 'bg-primary text-white rounded-2xl rounded-tr-sm'} px-4 py-2 shadow-sm">
                    <p class="text-sm ${isAdmin ? 'text-dark' : 'text-white'}">${escapeHtml(text)}</p>
                    <p class="text-[10px] mt-1 ${isAdmin ? 'text-netral-400' : 'text-white/70'}">baru saja</p>
                </div>
            `;
            return div;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ========== LOAD SIDEBAR ==========
        function loadConversations() {
            const container = document.getElementById('conversationList');
            if (!container) return;

            fetch('{{ route("admin.customer-chats.index") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const rows = doc.querySelectorAll('tbody tr');
                container.innerHTML = '';

                if (rows.length === 0) {
                    container.innerHTML = '<div class="p-4 text-center text-netral-500 text-sm">Tidak ada percakapan lain</div>';
                    return;
                }

                rows.forEach(row => {
                    const link = row.querySelector('a[href]');
                    const isActive = link && link.getAttribute('href') === window.location.href;
                    const clone = row.cloneNode(true);
                    if (isActive) {
                        clone.style.borderLeft = '4px solid #ea580c';
                        clone.style.backgroundColor = '#fff7ed';
                    }
                    container.appendChild(clone);
                });
            })
            .catch(() => {
                container.innerHTML = '<div class="p-4 text-center text-netral-500 text-sm">Gagal memuat</div>';
            });
        }
        loadConversations();

        // ========== REALTIME ECHO ==========
        if (window.Echo) {
            window.Echo.private('chat.admin')
                .listen('.NewCustomerChatMessage', (e) => {
                    // Cek apakah pesan milik percakapan ini
                    const isCurrent = (
                        (e.user_id && '{{ $userId }}' == e.user_id) ||
                        (e.session_id && '{{ $sessionId }}' === e.session_id)
                    );

                    if (isCurrent) {
                        // Cek duplikasi
                        const existing = chatMessages.querySelector(`.message-item[data-id="${e.id}"]`);
                        if (!existing) {
                            const bubble = createMessageBubble(e.message, e.sender_type);
                            bubble.dataset.id = e.id;
                            chatMessages.appendChild(bubble);
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }
                    } else {
                        // Update sidebar
                        loadConversations();
                    }
                });
        }
    });
</script>
@endpush