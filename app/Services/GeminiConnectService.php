<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiConnectService
{
    public function generateContent($prompt) {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        return $response->json()['candidates'][0]['content']['parts'][0]['text'];
    }
}
