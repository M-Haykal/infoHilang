<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiConnectService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1/models/'
            . env('GEMINI_MODEL', 'gemini-1.5-flash')
            . ':generateContent?key=' . env('GEMINI_API_KEY');
    }

    public function generateContent(string $prompt): string
    {
        $response = Http::post($this->apiUrl, [
            'contents' => [
                [
                    'parts' => [['text' => $prompt]]
                ]
            ]
        ]);


        return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    public function compareImages(string $newImage, string $oldImage): array
    {
        $prompt = "
            Kamu adalah AI pembanding gambar yang SANGAT KETAT.
            Jika dua gambar adalah objek yang sama, similarity minimal 90.
            Jawab JSON saja.
        ";

        $response = Http::post($this->apiUrl, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        ['inline_data' => ['mime_type' => 'image/jpeg', 'data' => base64_encode(file_get_contents($newImage))]],
                        ['inline_data' => ['mime_type' => 'image/jpeg', 'data' => base64_encode(file_get_contents($oldImage))]],
                    ]
                ]
            ]
        ]);


        $raw = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
        $clean = trim(preg_replace('/```json|```/', '', $raw));


        return json_decode($clean, true) ?? ['duplicate' => false, 'similarity' => 0];
    }
}
