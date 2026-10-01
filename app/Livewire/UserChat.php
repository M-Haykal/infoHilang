<?php

namespace App\Livewire;

use App\Events\NewCustomerChatMessage;
use App\Models\CustomerChatMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class UserChat extends Component
{
    public string $sessionId = '';
    public string $message = '';
    public array $messages = [];
    public bool $isOpen = false;
    public int $unreadCount = 0;

    /**
     * Initialize session_id for guest users.
     */
    public function mount(): void
    {
        if (auth()->check()) {
            $this->sessionId = 'user_' . auth()->id();
            $this->loadMessages();
        }

        // Dispatch init-session selalu (guest akan mendapatkan session dari localStorage)
        $this->dispatch('init-session');
    }

    /**
     * Set session dari JavaScript (dipanggil dari frontend setelah localStorage di-load).
     */
    public function setSession(string $sessionId): void
    {
        if ($this->sessionId === $sessionId) {
            // sessionId sama, skip biar tidak reload berulang
            return;
        }
        $this->sessionId = $sessionId;
        $this->loadMessages();
        // Register ulang listener Echo untuk guest channel
        $this->dispatch('register-guest-listener', sessionId: $sessionId);
    }

    /**
     * Load chat history.
     */
    public function loadMessages(): void
    {
        if (auth()->check()) {
            $this->messages = CustomerChatMessage::where('user_id', auth()->id())
                ->oldest()
                ->get()
                ->toArray();
        } elseif ($this->sessionId && !str_starts_with($this->sessionId, 'user_')) {
            $this->messages = CustomerChatMessage::whereNull('user_id')
                ->where('session_id', $this->sessionId)
                ->oldest()
                ->get()
                ->toArray();
        } else {
            $this->messages = [];
        }
    }

    /**
     * Send a message.
     */
    public function sendMessage(): void
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Generate session_id untuk guest jika belum ada
        if (!auth()->check() && (!$this->sessionId || str_starts_with($this->sessionId, 'user_'))) {
            $this->sessionId = Str::uuid()->toString();
            $this->dispatch('store-session', sessionId: $this->sessionId);
        }

        $chatMessage = CustomerChatMessage::create([
            'user_id' => auth()->id(),
            'session_id' => !auth()->check() ? $this->sessionId : null,
            'message' => $this->message,
            'sender_type' => 'user',
            'is_read' => false,
        ]);

        // Broadcast event (tanpa toOthers karena broadcast ke semua termasuk sender).
        // Dibungkus try/catch supaya pesan user tetap terkirim walau server
        // realtime (Reverb) sedang tidak berjalan / tidak bisa dihubungi.
        try {
            broadcast(new NewCustomerChatMessage($chatMessage));
        } catch (\Throwable $e) {
            Log::warning('Gagal broadcast pesan chat: ' . $e->getMessage());
        }

        // Tambahkan pesan ke array lokal tanpa reload dari DB (lebih cepat)
        $this->messages[] = [
            'id' => $chatMessage->id,
            'user_id' => $chatMessage->user_id,
            'session_id' => $chatMessage->session_id,
            'message' => $chatMessage->message,
            'sender_type' => $chatMessage->sender_type,
            'is_read' => $chatMessage->is_read,
            'created_at' => $chatMessage->created_at->toISOString(),
            'created_at_diff' => $chatMessage->created_at->diffForHumans(),
        ];

        $this->message = '';

        $this->dispatch('scroll-to-bottom');
    }

    /**
     * Toggle chat popup.
     */
    public function toggleChat(): void
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->loadMessages();
            $this->unreadCount = 0;
            $this->dispatch('scroll-to-bottom');
        }
    }

    /**
     * Listen untuk event broadcast realtime.
     * Semua komponen mendengarkan channel chat.admin (menerima semua pesan).
     * Filter dilakukan di handleIncomingMessage berdasarkan user_id/session_id.
     */
    public function getListeners(): array
    {
        return [
            // . prefix karena event menggunakan broadcastAs()
            "echo-private:chat.admin,.NewCustomerChatMessage" => 'handleIncomingMessage',
        ];
    }

    /**
     * Handle incoming message dari Echo.
     * Filter pesan yang hanya relevan untuk user/guest ini.
     */
    public function handleIncomingMessage(array $payload): void
    {
        // Cegah duplikasi
        $exists = collect($this->messages)->firstWhere('id', $payload['id']);
        if ($exists) {
            return;
        }

        // Filter: hanya tampilkan pesan yang relevan untuk user ini
        $isRelevant = false;

        if (auth()->check()) {
            // User login: cocokkan user_id
            if (isset($payload['user_id']) && (int) $payload['user_id'] === auth()->id()) {
                $isRelevant = true;
            }
        } elseif ($this->sessionId && !str_starts_with($this->sessionId, 'user_')) {
            // Guest: cocokkan session_id
            if (isset($payload['session_id']) && $payload['session_id'] === $this->sessionId) {
                $isRelevant = true;
            }
        }

        if (!$isRelevant) {
            return;
        }

        $this->messages[] = $payload;

        if (!$this->isOpen) {
            $this->unreadCount++;
        }

        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        return view('livewire.user-chat');
    }
}