<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'message',
        'sender_type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk mengelompokkan percakapan berdasarkan user_id atau session_id.
     */
    public function scopeConversations($query)
    {
        return $query->selectRaw('
                CASE
                    WHEN user_id IS NOT NULL THEN CONCAT("user_", user_id)
                    ELSE CONCAT("guest_", session_id)
                END as conversation_id,
                MAX(created_at) as last_message_at
            ')
            ->groupBy('conversation_id')
            ->orderByDesc('last_message_at');
    }

    /**
     * Ambil pesan terakhir untuk sebuah percakapan.
     */
    public function scopeLastMessageForConversation($query, $conversationId)
    {
        if (str_starts_with($conversationId, 'user_')) {
            $userId = (int) str_replace('user_', '', $conversationId);
            return $query->where('user_id', $userId);
        } else {
            $sessionId = str_replace('guest_', '', $conversationId);
            return $query->whereNull('user_id')->where('session_id', $sessionId);
        }
    }

    /**
     * Tandai semua pesan user (dengan sender_type = 'user') sebagai terbaca.
     */
    public function markAsRead(): void
    {
        $this->where('sender_type', 'user')->update(['is_read' => true]);
    }

    /**
     * Mark as read untuk percakapan spesifik.
     */
    public static function markConversationAsRead($userId = null, $sessionId = null): void
    {
        $query = static::where('sender_type', 'user')->where('is_read', false);

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->whereNull('user_id')->where('session_id', $sessionId);
        }

        $query->update(['is_read' => true]);
    }

    /**
     * Hitung jumlah percakapan yang memiliki pesan belum dibaca.
     */
    public static function countUnreadConversations(): int
    {
        $unread = self::where('sender_type', 'user')
            ->where('is_read', false)
            ->selectRaw('CASE
                    WHEN user_id IS NOT NULL THEN CONCAT("user_", user_id)
                    ELSE CONCAT("guest_", session_id)
                END as conversation_id')
            ->distinct()
            ->pluck('conversation_id');

        return $unread->count();
    }

    /**
     * Dapatkan daftar percakapan dengan pesan terakhir dan jumlah unread.
     */
    public static function getConversationsList(): array
    {
        $raw = self::where('sender_type', 'user')
            ->selectRaw('
                user_id,
                session_id,
                CASE
                    WHEN user_id IS NOT NULL THEN CONCAT("user_", user_id)
                    ELSE CONCAT("guest_", session_id)
                END as conversation_id,
                MAX(created_at) as last_time
            ')
            ->groupBy('conversation_id', 'user_id', 'session_id')
            ->orderByDesc('last_time')
            ->get();

        $list = [];
        foreach ($raw as $item) {
            $lastMessage = self::where(function ($q) use ($item) {
                if ($item->user_id) {
                    $q->where('user_id', $item->user_id);
                } else {
                    $q->whereNull('user_id')->where('session_id', $item->session_id);
                }
            })->latest()->first();

            $unreadCount = self::where(function ($q) use ($item) {
                if ($item->user_id) {
                    $q->where('user_id', $item->user_id);
                } else {
                    $q->whereNull('user_id')->where('session_id', $item->session_id);
                }
            })->where('sender_type', 'user')->where('is_read', false)->count();

            $userName = 'Guest';
            $userEmail = '-';
            $userAvatar = null;
            if ($item->user_id) {
                $user = User::find($item->user_id);
                if ($user) {
                    $userName = $user->fullname ?? $user->name ?? 'User #' . $user->id;
                    $userEmail = $user->email ?? '-';
                    $userAvatar = $user->avatar ?? null;
                }
            }

            $list[] = [
                'identifier' => $item->user_id ? "user_{$item->user_id}" : "guest_{$item->session_id}",
                'user_id' => $item->user_id,
                'session_id' => $item->session_id,
                'user_name' => $userName,
                'user_email' => $userEmail,
                'user_avatar' => $userAvatar,
                'last_message' => $lastMessage ? $lastMessage->message : '',
                'last_message_at' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                'unread_count' => $unreadCount,
                'is_guest' => is_null($item->user_id),
            ];
        }

        return $list;
    }
}