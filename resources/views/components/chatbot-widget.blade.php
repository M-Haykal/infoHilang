{{-- resources/views/components/chatbot-widget.blade.php --}}

<div id="chatbot-widget" class="fixed bottom-6 right-6 z-50">
    {{-- Toggle Button --}}
    <button onclick="toggleChatbot()" id="chatbot-toggle"
        class="w-14 h-14 bg-primary hover:bg-primary-dark text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center group relative">
        <i class="fa-solid fa-robot text-2xl group-hover:scale-110 transition-transform" id="chatbot-icon"></i>
        
        {{-- Notification Badge --}}
        <span id="chatbot-badge" class="hidden absolute -top-1 -right-1 w-5 h-5 bg-danger text-white text-xs rounded-full flex items-center justify-center font-bold">!</span>
    </button>

    {{-- Chat Window --}}
    <div id="chatbot-window"
        class="hidden absolute bottom-16 right-0 w-96 h-[500px] bg-white rounded-2xl shadow-2xl border border-netral-200 overflow-hidden flex flex-col">

        {{-- Header (fixed height) --}}
        <div class="bg-primary text-white p-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center relative">
                    <i class="fa-solid fa-headset text-lg" id="header-icon"></i>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-success border-2 border-primary rounded-full"></span>
                </div>
                <div>
                    <h4 class="font-bold text-sm" id="header-title">InfoHilang Assistant</h4>
                    <p class="text-xs text-white/80" id="header-status">AI • Database Scope</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="resetToAI()" id="reset-btn" class="hidden text-white/80 hover:text-white transition-colors" title="Kembali ke AI">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button onclick="toggleChatbot()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Scope Indicator (fixed height) --}}
        <div id="scope-indicator" class="bg-netral-100 px-4 py-2 text-xs text-netral-500 flex items-center justify-between flex-shrink-0">
            <span><i class="fa-solid fa-database mr-1"></i> Scope: Barang, Hewan, Orang Hilang</span>
            <span class="text-netral-400 cursor-help" title="AI hanya bisa mengakses data kehilangan. Pertanyaan lain akan dialihkan ke admin.">
                <i class="fa-solid fa-circle-info"></i>
            </span>
        </div>

        {{-- Messages Area (scrollable, flex-1 takes remaining space) --}}
        <div id="chatbot-messages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-netral-50 min-h-0">
            {{-- Welcome Message --}}
            <div class="flex gap-3" id="welcome-message">
                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-robot text-white text-sm"></i>
                </div>
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%]">
                    <p class="text-sm text-dark">Halo! 👋 Saya asisten virtual InfoHilang.</p>
                    <p class="text-xs text-netral-500 mt-2 leading-relaxed">
                        Saya bisa membantu mencari data <strong>barang, hewan, atau orang hilang</strong> dari database kami.
                    </p>
                    <div class="mt-3 p-2 bg-primary/5 rounded-lg border border-primary/10">
                        <p class="text-xs text-primary-dark font-medium">
                            <i class="fa-solid fa-lightbulb mr-1"></i>
                            Coba: "Cari kucing di Jakarta" atau "Total barang hilang"
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Area (fixed height, auto on content) --}}
        <div class="p-4 bg-white border-t border-netral-100 flex-shrink-0">
            {{-- Admin handover notice --}}
            <div id="admin-notice" class="hidden mb-3 p-3 bg-warning/10 border border-warning/20 rounded-xl">
                <p class="text-xs text-warning-dark font-medium flex items-start gap-2">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                    <span>Pertanyaan di luar scope data kehilangan akan dialihkan ke admin manusia.</span>
                </p>
            </div>

            <form id="chatbot-form" onsubmit="sendMessage(event)" class="flex gap-2">
                <input type="text" id="chatbot-input"
                    class="flex-1 px-4 py-2.5 bg-netral-50 border border-netral-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:bg-netral-100 disabled:cursor-not-allowed"
                    placeholder="Ketik pesan Anda..." autocomplete="off" maxlength="500">
                <button type="submit" id="send-btn"
                    class="w-10 h-10 bg-primary hover:bg-primary-dark text-white rounded-xl transition-colors flex items-center justify-center disabled:bg-netral-300 flex-shrink-0">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>

            {{-- Quick Actions --}}
            <div class="flex gap-2 mt-3 overflow-x-auto pb-1 scrollbar-hide">
                <button onclick="sendQuickMessage('Cari barang laptop')"
                    class="px-3 py-1.5 bg-netral-100 hover:bg-primary/10 hover:text-primary hover:border-primary/30 border border-transparent text-netral-600 text-xs rounded-full whitespace-nowrap transition-all flex-shrink-0">
                    📦 Cari Barang
                </button>
                <button onclick="sendQuickMessage('Ada hewan hilang di Jakarta?')"
                    class="px-3 py-1.5 bg-netral-100 hover:bg-primary/10 hover:text-primary hover:border-primary/30 border border-transparent text-netral-600 text-xs rounded-full whitespace-nowrap transition-all flex-shrink-0">
                    🐾 Hewan di Lokasi
                </button>
                <button onclick="sendQuickMessage('Total orang dicari')"
                    class="px-3 py-1.5 bg-netral-100 hover:bg-primary/10 hover:text-primary hover:border-primary/30 border border-transparent text-netral-600 text-xs rounded-full whitespace-nowrap transition-all flex-shrink-0">
                    👤 Total Orang
                </button>
                <button onclick="sendQuickMessage('Statistik')"
                    class="px-3 py-1.5 bg-netral-100 hover:bg-primary/10 hover:text-primary hover:border-primary/30 border border-transparent text-netral-600 text-xs rounded-full whitespace-nowrap transition-all flex-shrink-0">
                    📊 Statistik
                </button>
            </div>

            {{-- Footer hint --}}
            <p class="text-[10px] text-netral-400 mt-2 text-center">
                AI terbatas pada data kehilangan • 
                <a href="#" onclick="showScopeInfo(event)" class="hover:text-primary underline">Pelajari scope</a>
            </p>
        </div>
    </div>

    {{-- Scope Info Modal --}}
    <div id="scope-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl max-h-[80vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg text-dark">Scope InfoHilang AI</h3>
                <button onclick="hideScopeInfo()" class="text-netral-400 hover:text-dark">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="p-3 bg-success/10 rounded-xl border border-success/20">
                    <h4 class="font-semibold text-success-dark text-sm mb-2">
                        <i class="fa-solid fa-check-circle mr-1"></i> Bisa Ditanyakan ke AI
                    </h4>
                    <ul class="text-xs text-netral-600 space-y-1 ml-4 list-disc">
                        <li>Cari barang/hewan/orang hilang</li>
                        <li>Total/jumlah per kategori</li>
                        <li>Data per lokasi (Jakarta, Bandung, dll)</li>
                        <li>Status laporan (hilang/ditemukan)</li>
                        <li>Statistik ringkasan</li>
                    </ul>
                </div>

                <div class="p-3 bg-danger/10 rounded-xl border border-danger/20">
                    <h4 class="font-semibold text-danger text-sm mb-2">
                        <i class="fa-solid fa-times-circle mr-1"></i> Akan Dialihkan ke Admin
                    </h4>
                    <ul class="text-xs text-netral-600 space-y-1 ml-4 list-disc">
                        <li>Pertanyaan akun (login, password, daftar)</li>
                        <li>Komplain atau pengaduan</li>
                        <li>Donasi, iklan, kerjasama</li>
                        <li>Bug atau error teknis</li>
                        <li>Data pribadi orang lain</li>
                    </ul>
                </div>
            </div>

            <button onclick="hideScopeInfo()" 
                class="w-full mt-4 bg-primary text-white py-2.5 rounded-xl font-medium hover:bg-primary-dark transition-colors">
                Mengerti
            </button>
        </div>
    </div>
</div>

@push('script')
<script>
    let isChatbotOpen = false;
    let isAdminMode = false;
    let messageHistory = [];

    function toggleChatbot() {
        const window = document.getElementById('chatbot-window');
        isChatbotOpen = !isChatbotOpen;

        if (isChatbotOpen) {
            window.classList.remove('hidden');
            document.getElementById('chatbot-input').focus();
            scrollToBottom();
        } else {
            window.classList.add('hidden');
        }
    }

    function showScopeInfo(e) {
        e.preventDefault();
        document.getElementById('scope-modal').classList.remove('hidden');
    }

    function hideScopeInfo() {
        document.getElementById('scope-modal').classList.add('hidden');
    }

    // Close modal on outside click
    document.getElementById('scope-modal')?.addEventListener('click', (e) => {
        if (e.target.id === 'scope-modal') hideScopeInfo();
    });

    function scrollToBottom() {
        const container = document.getElementById('chatbot-messages');
        container.scrollTop = container.scrollHeight;
    }

    function addMessage(text, isUser = false, type = 'normal') {
        const container = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        
        if (type === 'handover') {
            div.className = 'flex gap-3 flex-shrink-0';
            div.innerHTML = `
                <div class="w-8 h-8 bg-warning rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-user-headset text-white text-sm"></i>
                </div>
                <div class="bg-warning/10 border border-warning/20 p-3 rounded-2xl rounded-tl-none max-w-[85%]">
                    <p class="text-xs font-semibold text-warning-dark mb-1">Dialihkan ke Admin</p>
                    <div class="text-sm text-dark">${text}</div>
                </div>
            `;
        } else if (type === 'system') {
            div.className = 'flex justify-center flex-shrink-0';
            div.innerHTML = `
                <span class="text-[10px] text-netral-400 bg-netral-100 px-3 py-1 rounded-full">
                    ${escapeHtml(text)}
                </span>
            `;
        } else {
            div.className = `flex gap-3 ${isUser ? 'flex-row-reverse' : ''} flex-shrink-0`;
            
            const avatar = isUser 
                ? `<div class="w-8 h-8 bg-netral-300 rounded-full flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-user text-white text-sm"></i></div>`
                : `<div class="w-8 h-8 ${isAdminMode ? 'bg-warning' : 'bg-primary'} rounded-full flex items-center justify-center flex-shrink-0"><i class="fa-solid ${isAdminMode ? 'fa-user-headset' : 'fa-robot'} text-white text-sm"></i></div>`;

            const bubble = isUser
                ? `<div class="bg-primary text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[85%]"><p class="text-sm">${escapeHtml(text)}</p></div>`
                : `<div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] border border-netral-100"><div class="text-sm text-dark leading-relaxed message-content">${formatMessage(text)}</div></div>`;

            div.innerHTML = avatar + bubble;
        }
        
        container.appendChild(div);
        scrollToBottom();
        
        messageHistory.push({ text, isUser, type, time: new Date() });
    }

    function formatMessage(text) {
        // Format **bold** 
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong class="text-primary-dark font-semibold">$1</strong>');
        
        // Format emoji dengan ukuran lebih besar
        text = text.replace(/(🔍|📦|🐾|👤|📊|✅|🆘|📍|💡|🙏|😊|👋|😔|🤲|📋|⏳|🌟|❤️|🔥|⚡|🎉|💯)/g, '<span class="text-base inline-block">$1</span>');
        
        // Format newline menjadi <br>
        text = text.replace(/\n/g, '<br>');
        
        // Format list (• atau 1. 2. 3.)
        text = text.replace(/(•|\d+\.)\s+/g, '<span class="text-primary mr-1">$1</span> ');
        
        return text;
    }

    function addTypingIndicator() {
        const container = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.id = 'typing-indicator';
        div.className = 'flex gap-3 flex-shrink-0';
        div.innerHTML = `
            <div class="w-8 h-8 ${isAdminMode ? 'bg-warning' : 'bg-primary'} rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fa-solid ${isAdminMode ? 'fa-user-headset' : 'fa-robot'} text-white text-sm"></i>
            </div>
            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm">
                <div class="flex gap-1">
                    <div class="w-2 h-2 bg-netral-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-netral-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-netral-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        `;
        container.appendChild(div);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('typing-indicator');
        if (indicator) indicator.remove();
    }

    function switchToAdminMode(data) {
        isAdminMode = true;
        
        document.getElementById('header-icon').className = 'fa-solid fa-user-headset text-lg';
        document.getElementById('header-title').textContent = 'Admin InfoHilang';
        document.getElementById('header-status').textContent = data.admin_available ? 'Online • Manusia' : 'Offline • Balas Nanti';
        document.getElementById('header-status').className = data.admin_available ? 'text-xs text-success' : 'text-xs text-warning';
        
        const scopeIndicator = document.getElementById('scope-indicator');
        scopeIndicator.className = 'bg-warning/10 px-4 py-2 text-xs text-warning-dark flex items-center justify-between flex-shrink-0';
        scopeIndicator.innerHTML = `
            <span><i class="fa-solid fa-user-headset mr-1"></i> Mode Admin • Respon Manusia</span>
            <button onclick="resetToAI()" class="text-warning-dark hover:text-warning underline text-xs">Kembali ke AI</button>
        `;
        
        document.getElementById('reset-btn').classList.remove('hidden');
        document.getElementById('chatbot-input').placeholder = 'Tunggu admin merespons...';
        document.getElementById('chatbot-input').disabled = !data.admin_available;
        document.getElementById('send-btn').disabled = !data.admin_available;
        document.getElementById('chatbot-badge').classList.remove('hidden');
    }

    function resetToAI() {
        isAdminMode = false;
        
        document.getElementById('header-icon').className = 'fa-solid fa-headset text-lg';
        document.getElementById('header-title').textContent = 'InfoHilang Assistant';
        document.getElementById('header-status').textContent = 'AI • Database Scope';
        document.getElementById('header-status').className = 'text-xs text-white/80';
        
        const scopeIndicator = document.getElementById('scope-indicator');
        scopeIndicator.className = 'bg-netral-100 px-4 py-2 text-xs text-netral-500 flex items-center justify-between flex-shrink-0';
        scopeIndicator.innerHTML = `
            <span><i class="fa-solid fa-database mr-1"></i> Scope: Barang, Hewan, Orang Hilang</span>
            <span class="text-netral-400 cursor-help" title="AI hanya bisa mengakses data kehilangan. Pertanyaan lain akan dialihkan ke admin.">
                <i class="fa-solid fa-circle-info"></i>
            </span>
        `;
        
        document.getElementById('reset-btn').classList.add('hidden');
        document.getElementById('chatbot-input').placeholder = 'Ketik pesan Anda...';
        document.getElementById('chatbot-input').disabled = false;
        document.getElementById('send-btn').disabled = false;
        document.getElementById('chatbot-badge').classList.add('hidden');
        
        addMessage('Kembali ke mode AI Assistant', false, 'system');
    }

    async function sendMessage(event) {
        event.preventDefault();
        const input = document.getElementById('chatbot-input');
        const message = input.value.trim();
        
        if (!message) return;
        
        addMessage(message, true);
        input.value = '';
        addTypingIndicator();

        try {
            const response = await fetch('{{ route('chatbot.message') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            removeTypingIndicator();

            if (!response.ok) {
                throw new Error(data.message || 'Server error');
            }

            if (data.handover) {
                switchToAdminMode(data);
                
                const handoverText = `${data.message}${data.whatsapp_link ? `\n\n<a href="${data.whatsapp_link}" target="_blank" class="inline-flex items-center gap-2 mt-3 bg-success text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-success-dark transition-colors no-underline"><i class="fa-brands fa-whatsapp text-lg"></i> Chat WhatsApp Admin</a>` : ''}`;
                
                addMessage(handoverText, false, 'handover');
            } else {
                addMessage(data.message, false, 'normal');
                
                if (data.confidence < 0.5) {
                    document.getElementById('header-status').textContent = 'AI • Low Confidence';
                    document.getElementById('header-status').className = 'text-xs text-warning';
                }
            }

        } catch (error) {
            removeTypingIndicator();
            console.error('Chatbot error:', error);
            addMessage('Maaf, terjadi kesalahan. Silakan hubungi admin via WhatsApp.', false, 'handover');
        }
    }

    function sendQuickMessage(text) {
        document.getElementById('chatbot-input').value = text;
        document.getElementById('chatbot-input').focus();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Toggle dengan tombol ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isChatbotOpen) {
            if (!document.getElementById('scope-modal').classList.contains('hidden')) {
                hideScopeInfo();
            } else {
                toggleChatbot();
            }
        }
    });

    // Auto open on first visit
    if (!localStorage.getItem('chatbot_seen')) {
        setTimeout(() => {
            toggleChatbot();
            localStorage.setItem('chatbot_seen', 'true');
        }, 2000);
    }
</script>
@endpush

@push('style')
<style>
    /* Scrollbar styling untuk messages */
    #chatbot-messages {
        scroll-behavior: smooth;
    }
    
    #chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }
    
    #chatbot-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #chatbot-messages::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
    
    #chatbot-messages::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8;
    }

    /* Hide scrollbar untuk quick actions tapi tetap bisa scroll */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Message content styling */
    .message-content strong {
        color: #2563eb;
    }
    
    .message-content br {
        display: block;
        margin-bottom: 0.25rem;
        content: "";
    }
    
    /* Modal scrollbar */
    #scope-modal > div::-webkit-scrollbar {
        width: 4px;
    }
    
    #scope-modal > div::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 10px;
    }
</style>
@endpush