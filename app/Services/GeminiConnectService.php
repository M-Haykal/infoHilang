<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiConnectService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl =
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key='
            . env('GEMINI_API_KEY');
    }

    public function generateContent($prompt)
    {
        $response = Http::post($this->apiUrl, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }

    public function compareImages($newImagePath, $existingImagePath)
    {
        $prompt = "
            Kamu adalah AI yang membandingkan dua gambar.
            Berikan hasil dalam JSON tanpa tambahan kata:
            {
                \"duplicate\": true/false,
                \"similarity\": 0-100,
                \"reason\": \"alasan singkat\"
            }
        ";

        $newImg = base64_encode(file_get_contents($newImagePath));
        $oldImg = base64_encode(file_get_contents($existingImagePath));

        $response = Http::post($this->apiUrl, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => 'image/jpeg',
                                'data' => $newImg
                            ]
                        ],
                        [
                            'inline_data' => [
                                'mime_type' => 'image/jpeg',
                                'data' => $oldImg
                            ]
                        ],
                    ]
                ]
            ]
        ]);

        return json_decode(
            $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '{}',
            true
        );
    }

    public function checkDuplicateReport($newData, $existingData)
    {
        $textPrompt = "
            Kamu adalah AI pendeteksi laporan duplikat.
            Bandingkan data baru dengan data lama.

            DATA BARU:
            " . json_encode($newData) . "

            DATA TERDAHULU:
            " . json_encode($existingData) . "

            Nilai kemiripan berdasarkan nama, ciri-ciri, umur, deskripsi,
            dan buat skor 0-100 dalam format:
            {
                \"duplicate\": true/false,
                \"similarity\": 0-100,
                \"reason\": \"alasan singkat\"
            }
        ";

        $textCheck = $this->generateContent($textPrompt);

        return json_decode($textCheck, true);
    }
}
