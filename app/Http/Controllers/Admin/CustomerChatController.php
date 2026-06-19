<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewCustomerChatMessage;
use App\Http\Controllers\Controller;
use App\Models\CustomerChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerChatController extends Controller
{
    /**
     * Tampilkan daftar semua percakapan.
     */
    public function index()
    {
        $conversations = CustomerChatMessage::getConversationsList();
        $totalUnread = CustomerChatMessage::countUnreadConversations();

        return view('dashboard.pages.admin.customer-chats', compact('conversations', 'totalUnread'));
    }

    /**
     * Tampilkan detail percakapan.
     */
    public function show($identifier)
    {
        $parts = explode('_', $identifier, 2);
        $type = $parts[0]; // 'user' or 'guest'
        $id = $parts[1] ?? '';

        $userId = null;
        $sessionId = null;

        if ($type === 'user') {
            $userId = (int) $id;
            $user = User::find($userId);
            $conversationName = $user ? ($user->fullname ?? $user->name ?? 'User #' . $user->id) : 'Unknown User';
            // Mark all as read
            CustomerChatMessage::markConversationAsRead(userId: $userId);
        } else {
            $sessionId = $id;
            $conversationName = 'Guest #' . substr($sessionId, 0, 8) . '...';
            // Mark all as read
            CustomerChatMessage::markConversationAsRead(sessionId: $sessionId);
        }

        $messages = CustomerChatMessage::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            }
            if ($sessionId) {
                $q->whereNull('user_id')->where('session_id', $sessionId);
            }
        })
        ->oldest()
        ->get();

        return view('dashboard.pages.admin.customer-chat-show', compact('messages', 'conversationName', 'identifier', 'userId', 'sessionId'));
    }

    /**
     * Kirim balasan admin.
     */
    public function reply(Request $request, $identifier)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $parts = explode('_', $identifier, 2);
        $type = $parts[0];
        $id = $parts[1] ?? '';

        $userId = null;
        $sessionId = null;

        if ($type === 'user') {
            $userId = (int) $id;
        } else {
            $sessionId = $id;
        }

        $chatMessage = CustomerChatMessage::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'message' => $validated['message'],
            'sender_type' => 'admin',
            'is_read' => true, // Admin message, auto read
        ]);

        // Broadcast event
        broadcast(new NewCustomerChatMessage($chatMessage))->toOthers();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
                'data' => $chatMessage
            ]);
        }

        return redirect()->route('admin.customer-chats.show', $identifier)
            ->with('success', 'Pesan berhasil dikirim');
    }
}