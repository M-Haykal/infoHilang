@extends('dashboard.layouts.index')

@section('title', 'Manajemen Chat | InfoHilang Admin')

@section('content')

    <div class="space-y-6" data-page="admin-chat">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-dark">Manajemen Chat</h1>
                <p class="text-sm text-netral-500 mt-1">Menanggapi chat user ketika AI tidak bisa menjawab</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[600px]">
            {{-- Daftar User Chat --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 border-b bg-netral-50">
                    <h3 class="font-bold text-dark">User Aktif</h3>
                </div>
                <div class="flex-1 overflow-y-auto" id="userList">
                    <div class="p-4 text-center text-netral-500 text-sm">
                        <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat daftar user...
                    </div>
                </div>
            </div>

            {{-- Area Chat --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 border-b bg-netral-50 flex items-center justify-between" id="chatHeader">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-dark" id="chatUserName">Pilih User</h3>
                            <p class="text-xs text-netral-500" id="chatUserStatus">-</p>
                        </div>
                    </div>
                    <button id="markHandledBtn"
                        class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600 transition hidden">
                        <i class="fa-solid fa-check mr-1"></i> Tandai Selesai
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-4 bg-netral-50" id="chatMessages">
                    <div class="text-center text-netral-500 text-sm mt-20">
                        <i class="fa-solid fa-comments text-4xl text-netral-300 mb-3"></i>
                        <p>Pilih user dari daftar disamping untuk melihat percakapan</p>
                    </div>
                </div>

                <div class="p-4 border-t bg-white hidden" id="chatInputArea">
                    <form id="replyForm" class="flex gap-3">
                        @csrf
                        <input type="text" id="replyMessage"
                            class="flex-1 border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                            placeholder="Ketik pesan balasan anda...">
                        <button type="submit"
                            class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-primary-dark transition">
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
            let currentUserId = null;

            // Load daftar user
            function loadUserList() {
                fetch("{{ route('admin.chat.list') }}", {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        const userList = document.getElementById('userList');
                        userList.innerHTML = '';

                        if (data.users && data.users.length > 0) {
                            data.users.forEach(user => {
                                const item = document.createElement('div');
                                item.className =
                                    `p-3 border-b hover:bg-netral-50 cursor-pointer transition ${user.has_awaiting_reply ? 'bg-yellow-50' : ''}`;
                                item.innerHTML = `
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                                ${user.name.charAt(0).toUpperCase()}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-dark text-sm truncate">${user.name}</p>
                                <p class="text-xs text-netral-500 truncate">${user.last_message}</p>
                            </div>
                            ${user.has_awaiting_reply ? '<span class="w-2 h-2 rounded-full bg-yellow-500"></span>' : ''}
                        </div>
                    `;
                                item.addEventListener('click', () => openChat(user.id));
                                userList.appendChild(item);
                            });
                        } else {
                            userList.innerHTML =
                                '<div class="p-4 text-center text-netral-500 text-sm">Tidak ada chat aktif</div>';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                    });
            }

            // Buka chat user
            function openChat(userId) {
                currentUserId = userId;
                document.getElementById('chatInputArea').classList.remove('hidden');
                document.getElementById('markHandledBtn').classList.remove('hidden');

                fetch(`/admin/chat/session/${userId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('chatUserName').textContent = data.user.name;
                            document.getElementById('chatUserStatus').textContent = data.user.email;

                            const chatArea = document.getElementById('chatMessages');
                            chatArea.innerHTML = '';

                            if (data.messages && data.messages.length > 0) {
                                data.messages.forEach(msg => {
                                    const bubble = document.createElement('div');
                                    let positionClass = '';
                                    if (msg.sender === 'user') {
                                        positionClass = 'ml-auto'; // user chat kanan
                                    } else if (msg.sender === 'admin') {
                                        positionClass = 'mr-auto'; // admin chat kiri
                                    } else {
                                        positionClass = 'mr-auto'; // bot chat kiri
                                    }
                                    bubble.className = `mb-3 max-w-[70%] ${positionClass}`;
                                    bubble.innerHTML = `
                            <div class="rounded-xl px-4 py-2 ${msg.is_user ? 'bg-primary text-white rounded-tr-none' : 'bg-white border rounded-tl-none'}">
                                <p class="text-sm">${msg.message}</p>
                                <p class="text-[10px] ${msg.is_user ? 'text-primary-light' : 'text-netral-400'} mt-1">${msg.time}</p>
                            </div>
                        `;
                                    chatArea.appendChild(bubble);
                                });
                                chatArea.scrollTop = chatArea.scrollHeight;
                            } else {
                                chatArea.innerHTML =
                                    '<div class="text-center text-netral-500 text-sm">Belum ada pesan</div>';
                            }
                        }
                    });
            }

            // Kirim balasan admin
            document.getElementById('replyForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const message = document.getElementById('replyMessage').value.trim();

                if (!message || !currentUserId) return;

                fetch(`/admin/chat/reply/${currentUserId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('replyMessage').value = '';
                            openChat(currentUserId);
                        }
                    });
            });

            // Tandai selesai
            document.getElementById('markHandledBtn').addEventListener('click', function() {
                if (!currentUserId) return;

                fetch(`/admin/chat/handled/${currentUserId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            loadUserList();
                            openChat(currentUserId);
                        }
                    });
            });

            // Realtime Websocket Listener untuk admin
            if (window.Echo) {
                window.Echo.channel('admin.chat')
                    .listen('.chat.new.user', (e) => {
                        loadUserList();
                    })
                    .listen('.chat.new.message', (e) => {
                        if (currentUserId === e.sessionId) {
                            openChat(currentUserId);
                        }
                    });
            }

            // Refresh setiap 30 detik
            setInterval(loadUserList, 30000);
            loadUserList();
        });
    </script>
@endpush
