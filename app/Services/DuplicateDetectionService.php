<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\GeminiConnectService;
use Illuminate\Support\Str;

class DuplicateDetectionService
{
    protected $gemini;

    public function __construct(GeminiConnectService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Cek duplikat untuk model apa saja
     * 
     * @param Request $request
     * @param array $validated
     * @param string $modelClass   contoh: OrangHilang::class
     * @param array $textFields    field teks yang dibandingkan
     * @param float $imageWeight   bobot gambar (0.6 untuk orang, 0.8 untuk barang/hewan)
     * @param int $threshold       default 80
     * 
     * @return array
     */
    public function check(Request $request, array $validated, string $modelClass, array $textFields = [], float $imageWeight = 0.6, int $threshold = 80): array
    {
        $existingReports = $modelClass::whereIn('status', ['Hilang', 'Ditemukan'])->get();

        $highestSimilarity = 0;
        $isDuplicate = false;
        $reason = 'Tidak ada kemiripan';
        $existingId = null;

        foreach ($existingReports as $report) {
            $imageSim = $this->compareImages($request, $report);
            $textSim = $this->compareText($validated, $report, $textFields);

            $totalScore = ($imageSim['similarity'] * $imageWeight) + ($textSim['similarity'] * (1 - $imageWeight));

            if ($totalScore > $highestSimilarity) {
                $highestSimilarity = $totalScore;
                $isDuplicate = $imageSim['duplicate'] || $textSim['duplicate'];
                $reason = $imageSim['reason'] ?? $textSim['reason'] ?? 'Kemiripan tinggi';
                $existingId = $report->id;
            }
        }

        $finalDuplicate = $isDuplicate && $highestSimilarity >= $threshold;

        return [
            'isDuplicate' => $finalDuplicate,
            'similarity' => round($highestSimilarity),
            'reason' => $reason,
            'existing_id' => $finalDuplicate ? $existingId : null,
        ];
    }

    // === IMAGE COMPARISON (Universal) ===
    private function compareImages(Request $request, $existingModel): array
    {
        if (!$request->hasFile('foto') || empty($existingModel->foto)) {
            return ['duplicate' => false, 'similarity' => 0, 'reason' => 'Tidak ada foto'];
        }

        $highest = 0;
        $reason = '';

        foreach ($request->file('foto') as $newFile) {
            $tempPath = $newFile->getPathname();

            foreach ($existingModel->foto as $oldPath) {
                $oldFullPath = storage_path('app/public/' . $oldPath);
                if (!file_exists($oldFullPath))
                    continue;

                try {
                    $result = $this->gemini->compareImages($tempPath, $oldFullPath);
                    $sim = $result['similarity'] ?? 0;

                    if ($sim > $highest) {
                        $highest = $sim;
                        $reason = $result['reason'] ?? 'Gambar sangat mirip';
                    }
                    if ($result['duplicate'] ?? false) {
                        return $result;
                    }
                } catch (\Exception $e) {
                    \Log::warning('Gemini image compare failed: ' . $e->getMessage());
                }
            }
        }

        return [
            'duplicate' => $highest >= 90,
            'similarity' => $highest,
            'reason' => $reason ?: 'Gambar tidak mirip'
        ];
    }

    // === TEXT COMPARISON (Universal) ===
    private function compareText(array $newData, $existingModel, array $fields): array
    {
        $existingData = $existingModel->only($fields);

        $prompt = "
            Kamu adalah AI pendeteksi duplikat laporan hilang.
            Bandingkan data baru dengan data lama.

            DATA BARU: " . json_encode($newData, JSON_UNESCAPED_UNICODE) . "
            DATA LAMA: " . json_encode($existingData, JSON_UNESCAPED_UNICODE) . "

            Jawab hanya JSON:
            {
                \"duplicate\": true/false,
                \"similarity\": 0-100,
                \"reason\": \"alasan singkat max 10 kata\"
            }
        ";

        try {
            $response = $this->gemini->generateContent($prompt);
            $result = json_decode($response, true);

            return $result ?: ['duplicate' => false, 'similarity' => 0, 'reason' => 'Gagal parse AI'];
        } catch (\Exception $e) {
            \Log::error('Gemini text compare failed: ' . $e->getMessage());
            return ['duplicate' => false, 'similarity' => 0, 'reason' => 'Error AI'];
        }
    }
}
