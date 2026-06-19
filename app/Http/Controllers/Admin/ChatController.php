<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ChatBotService;
use Carbon\Carbon;

class ChatController extends Controller
{
    protected $chatBotService;

    public function __construct(ChatBotService $chatBotService)
    {
        $this->chatBotService = $chatBotService;
    }

    public function index()
    {
        return view('dashboard.pages.admin.chat');
    }

    public function list()
    {
        $sessions = $this->chatBotService->getActiveSessions();
        
        return response()->json([
            'success' => true,
            'users' => $sessions
        ]);
    }

    public function getSession($userId)
    {
        $user = User::findOrFail($userId);
        $messages = $this->chatBotService->getUserMessages($userId);

        return response()->json([
            'success' => true,
            'user' => $user,
            'messages' => $messages
        ]);
    }

    public function sendReply(Request $request, $userId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $result = $this->chatBotService->sendAdminReply(
            $userId,
            $validated['message'],
            auth()->id()
        );

        return response()->json($result);
    }

    public function markHandled($userId)
    {
        $this->chatBotService->markSessionHandled($userId);
        
        return response()->json([
            'success' => true,
            'message' => 'Chat telah ditandai selesai'
        ]);
    }
}