<div>
    {{-- Toggle Button --}}
    <button type="button"
        wire:click="toggleChat"
        class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-primary text-white shadow-lg hover:bg-primary-dark transition-all duration-300 flex items-center justify-center {{ $isOpen ? 'scale-0 opacity-0' : 'scale-100 opacity-100' }}"
        id="chat-toggle-btn"
        aria-label="Buka Chat">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>

        {{-- Unread Badge --}}
        @if ($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-danger text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-bounce">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Close Button (when open) --}}
    <button type="button"
        wire:click="toggleChat"
        class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-danger text-white shadow-lg hover:bg-red-600 transition-all duration-300 flex items-center justify-center {{ $isOpen ? 'scale-100 opacity-100' : 'scale-0 opacity-0' }}"
        aria-label="Tutup Chat">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- Chat Popup --}}
    <div class="fixed bottom-24 right-6 z-50 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-300 {{ $isOpen ? 'scale-100 opacity-100 translate-y-0' : 'scale-75 opacity-0 translate-y-4 pointer-events-none' }}"
        id="chat-popup">
        {{-- Header --}}
        <div class="bg-primary px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-sm">Customer Support</h3>
                    <p class="text-white/70 text-xs">Kami siap membantu Anda</p>
                </div>
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="h-80 overflow-y-auto p-4 bg-gray-50 space-y-3" id="chat-messages" x-data x-ref="chatMessages">
            @if (count($messages) === 0)
                <div class="flex flex-col items-center justify-center h-full text-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-sm font-medium">Belum ada pesan</p>
                    <p class="text-xs mt-1">Silakan kirim pesan untuk memulai</p>
                </div>
            @else
                @foreach ($messages as $msg)
                    @php
                        $isUser = is_array($msg) ? ($msg['sender_type'] ?? '') === 'user' : $msg->sender_type === 'user';
                        $messageText = is_array($msg) ? ($msg['message'] ?? '') : $msg->message;
                        $createdAt = is_array($msg) ? ($msg['created_at_diff'] ?? ($msg['created_at'] ?? '')) : $msg->created_at->diffForHumans();
                        $msgId = is_array($msg) ? ($msg['id'] ?? '') : $msg->id;
                    @endphp
                    <div class="flex {{ $isUser ? 'justify-end' : 'justify-start' }}" wire:key="msg-{{ $msgId }}">
                        <div class="max-w-[80%] {{ $isUser ? 'bg-primary text-white rounded-2xl rounded-tr-sm' : 'bg-white border border-gray-200 rounded-2xl rounded-tl-sm' }} px-3 py-2 shadow-sm">
                            <p class="text-sm {{ $isUser ? 'text-white' : 'text-gray-800' }}">{{ $messageText }}</p>
                            <p class="text-[10px] mt-1 {{ $isUser ? 'text-white/70' : 'text-gray-400' }}">{{ $createdAt }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Input Area --}}
        <div class="border-t border-gray-200 p-3 bg-white">
            <form wire:submit="sendMessage" class="flex gap-2">
                <input type="text"
                    wire:model="message"
                    placeholder="Ketik pesan..."
                    class="flex-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    id="chat-input">
                <button type="submit"
                    class="bg-primary text-white px-4 py-2 rounded-xl text-sm hover:bg-primary-dark transition font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- JavaScript untuk session_id localStorage dan scroll --}}
    <script>
        document.addEventListener('livewire:init', () => {
            // Initialize session dari localStorage
            const storedSession = localStorage.getItem('customer_chat_session_id');
            if (storedSession) {
                @this.setSession(storedSession);
            }

            // Listen untuk event init-session dari Livewire
            Livewire.on('init-session', () => {
                const session = localStorage.getItem('customer_chat_session_id');
                if (session) {
                    @this.setSession(session);
                }
            });

            // Listen untuk event store-session dari Livewire
            Livewire.on('store-session', (data) => {
                if (data.sessionId) {
                    localStorage.setItem('customer_chat_session_id', data.sessionId);
                }
            });
        });

        // Scroll to bottom function
        document.addEventListener('scroll-to-bottom', () => {
            const container = document.getElementById('chat-messages');
            if (container) {
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 50);
            }
        });
    </script>
</div>