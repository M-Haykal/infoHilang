<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiConnectService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1/models/' . env('GEMINI_MODEL', 'gemini-1.5-flash') . ':generateContent?key=' . env('GEMINI_API_KEY');
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
            Kamu adalah detektor duplikat barang hilang yang SANGAT KETAT.
            Jika dua gambar menunjukkan barang yang SAMA (bentuk, warna, detail, latar), maka WAJIB duplicate: true dan similarity minimal 90.

            Hanya jawab JSON ini:

            {
                \"duplicate\": true,
                \"similarity\": 95,
                \"reason\": \"barang identik\"
            }

            JANGAN pernah kasih alasan panjang. JANGAN tambah kata.
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
