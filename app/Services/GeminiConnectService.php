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
     * Check duplicate using multi-modal Gemini (Text + Multiple Images)
     */
    public function checkDuplicate(array $newData, array $existingData, array $newImages = [], array $existingImages = []): array
    {
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            Log::error('Gemini API key missing');
            return ['isDuplicate' => false, 'similarity' => 0, 'reason' => 'API Key silakan dikonfigurasi'];
        }

        $url = $this->apiUrl . '?key=' . $apiKey;

        try {
            $parts = [];
            
            // Build the prompt
            $prompt = "Tugas: Deteksi Duplikat Laporan Kehilangan (Orang, Hewan, atau Barang).
Bandingkan 'Laporan Baru' dengan 'Laporan Lama'.

Laporan Baru:
- Nama: {$newData['name']}
- Karakteristik/Ciri-ciri: " . json_encode($newData['ciri_ciri']) . "
- Deskripsi: {$newData['description']}

Laporan Lama:
- Nama: {$existingData['name']}
- Karakteristik/Ciri-ciri: " . json_encode($existingData['ciri_ciri']) . "
- Deskripsi: {$existingData['description']}

Instruksi Analisis:
1. Bandingkan Nama: Apakah nama subjek sama atau sangat mirip (misal: singkatan atau salah ketik)?
2. Bandingkan Ciri Fisik: Perhatikan detail unik yang disebutkan di 'Karakteristik' dan 'Deskripsi'.
3. Bandingkan Foto: Analisis visual foto yang dilampirkan (jika ada). Apakah mereka menunjukkan individu, hewan, atau benda yang sama?
4. Abaikan perbedaan lokasi karena subjek hilang bisa berpindah tempat.
5. Beri skor kemiripan 0-100:
   - 0-30: Berbeda jauh.
   - 31-69: Ada beberapa kemiripan tapi tidak yakin sama.
   - 70-100: Sangat yakin ini adalah subjek yang sama (duplikat).

Output HANYA dalam format JSON:
{\"isDuplicate\": true|false, \"similarity\": score_number, \"reason\": \"Alasan singkat kenapa Anda memberi skor tersebut\"}";

            $parts[] = ['text' => $prompt];

            // Add new images (max 2 for comparison to save tokens/complexity)
            foreach (array_slice($newImages, 0, 2) as $path) {
                if (file_exists($path)) {
                    $parts[] = [
                        'inline_data' => [
                            'mime_type' => 'image/jpeg',
                            'data' => base64_encode(file_get_contents($path))
                        ]
                    ];
                }
            }

            // Add existing images (max 2)
            foreach (array_slice($existingImages, 0, 2) as $path) {
                if (file_exists($path)) {
                    $parts[] = [
                        'inline_data' => [
                            'mime_type' => 'image/jpeg',
                            'data' => base64_encode(file_get_contents($path))
                        ]
                    ];
                }
            }

            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->timeout(30)
                ->post($url, [
                    'contents' => [['parts' => $parts]],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'maxOutputTokens' => 500,
                    ]
                ]);

            if (!$response->successful()) {
                throw new \Exception('Gemini API Call failed with status: ' . $response->status());
            }

            $data = $response->json();
            $rawText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
            
            // Clean JSON formatting
            $cleanJson = preg_replace('/^```json\s*|\s*```$/m', '', trim($rawText));
            $result = json_decode($cleanJson, true);

            if (!$result) {
                Log::error('Failed to parse Gemini JSON: ' . $rawText);
                return ['isDuplicate' => false, 'similarity' => 0, 'reason' => 'Gagal memproses AI'];
            }

            return [
                'isDuplicate' => $result['isDuplicate'] ?? false,
                'similarity' => (int)($result['similarity'] ?? 0),
                'reason' => $result['reason'] ?? ''
            ];

        } catch (\Exception $e) {
            Log::error('Gemini CheckDuplicate Error: ' . $e->getMessage());
            return ['isDuplicate' => false, 'similarity' => 0, 'reason' => 'Error AI: ' . $e->getMessage()];
        }
    }
}