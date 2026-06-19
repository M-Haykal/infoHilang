<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatBotService;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\ChatbotSafetyFilter;

class ChatBotController extends Controller
{
    protected $chatbotService;
    protected $safetyFilter;

    public function __construct(ChatbotService $chatbotService, ChatbotSafetyFilter $safetyFilter)
    {
        $this->chatbotService = $chatbotService;
        $this->safetyFilter = $safetyFilter;
    }

    public function chat(Request $request)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:500'
            ]);

            // Step 1: Pre-filter (security)
            // $filterResult = $this->safetyFilter->preFilter($validated['message']);

            // if (!$filterResult['allowed']) {
            //     Log::warning('Chatbot pre-filter blocked', ['reason' => $filterResult['reason']]);
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Pesan tidak dapat diproses. Hubungi admin untuk bantuan.',
            //         'handover' => true,
            //         'whatsapp_link' => $this->getAdminWhatsAppLink($validated['message'])
            //     ], 400);
            // }

            // Step 2: Process dengan scope terbatas
            // Generate atau ambil session id untuk guest user
            $sessionId = $request->cookie('chat_session_id') ?? \Illuminate\Support\Str::uuid();
            
            $result = $this->chatbotService->processMessage(
                $validated['message'],
                auth()->id(),
                $sessionId
            );

            // Set cookie session untuk guest 7 hari
            if (!auth()->check()) {
                cookie()->queue('chat_session_id', $sessionId, 60 * 24 * 7);
            }

            // Step 3: Jika AI response, post-filter
            // if (!($result['handover'] ?? false) && isset($result['message'])) {
            //     $postFilter = $this->safetyFilter->postFilter(
            //         $result['message'],
            //         $result['data_summary'] ?? []
            //     );

            //     if (!$postFilter['valid']) {
            //         Log::warning('Chatbot post-filter triggered', ['reason' => $postFilter['reason']]);
            //         $result['message'] = $postFilter['fallback'];
            //         $result['filtered'] = true;
            //     }
            // }

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Chatbot fatal error', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Sistem sedang maintenance. Hubungi admin via WhatsApp.',
                'handover' => true,
                'whatsapp_link' => $this->getAdminWhatsAppLink($request->message ?? 'Error')
            ], 500);
        }
    }

    protected function getAdminWhatsAppLink(string $message): string
    {
        $adminNumber = env('ADMIN_WHATSAPP', '6281234567890');
        return 'https://wa.me/' . $adminNumber . '?text=' . urlencode('Halo admin, saya butuh bantuan: ' . $message);
    }
}
