<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiConnectService
{
    protected $apiUrl;
    protected $model;

    public function __construct()
    {
        $this->model = env('GEMINI_MODEL', 'gemini-1.5-flash-latest');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Generate content dengan Gemini
     */
    public function generateContent(string $prompt): string
    {
        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey)) {
            throw new \Exception('Gemini API key not configured');
        }

        $url = $this->apiUrl . '?key=' . $apiKey;

        Log::info('Calling Gemini API', ['url' => $this->apiUrl, 'prompt_length' => strlen($prompt)]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 800,
                        ]
                    ]);

            // Log response untuk debug
            Log::info('Gemini API response status: ' . $response->status());

            if (!$response->successful()) {
                Log::error('Gemini API error: ' . $response->body());
                throw new \Exception('Gemini API error: ' . $response->status());
            }

            $data = $response->json();

            // Extract text dari response
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (empty($text)) {
                Log::error('Empty Gemini response', $data);
                throw new \Exception('Empty response from Gemini');
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Gemini service error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Compare images (untuk fitur duplicate detection)
     */
    public function compareImages(string $newImagePath, string $oldImagePath): array
    {
        $apiKey = env('GEMINI_API_KEY');
        $url = $this->apiUrl . '?key=' . $apiKey;

        try {
            // Baca dan encode gambar
            $newImageData = base64_encode(file_get_contents($newImagePath));
            $oldImageData = base64_encode(file_get_contents($oldImagePath));

            $prompt = "Kamu adalah AI pembanding gambar. Bandingkan 2 gambar ini dan tentukan apakah mereka menunjukkan objek yang sama (duplicate) atau berbeda.
Jawab dalam format JSON: {\"duplicate\": true/false, \"similarity\": 0-100, \"reason\": \"penjelasan singkat\"}";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt],
                                    [
                                        'inline_data' => [
                                            'mime_type' => 'image/jpeg',
                                            'data' => $newImageData
                                        ]
                                    ],
                                    [
                                        'inline_data' => [
                                            'mime_type' => 'image/jpeg',
                                            'data' => $oldImageData
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]);

            if (!$response->successful()) {
                throw new \Exception('Image comparison failed: ' . $response->status());
            }

            $data = $response->json();
            $rawText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

            // Clean JSON dari markdown
            $cleanJson = preg_replace('/```json\s*|\s*```/', '', $rawText);
            $result = json_decode($cleanJson, true);

            return $result ?: ['duplicate' => false, 'similarity' => 0, 'reason' => 'parse error'];

        } catch (\Exception $e) {
            Log::error('Image comparison error: ' . $e->getMessage());
            return ['duplicate' => false, 'similarity' => 0, 'reason' => $e->getMessage()];
        }
    }
}