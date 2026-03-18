<?php

namespace App\Services;

use App\Models\HewanHilang;
use App\Models\BarangHilang;
use App\Models\OrangHilang;
use App\Services\GeminiConnectService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DuplicateDetectionService
{
    protected $gemini;
    protected array $modelMap = [
        'hewan' => HewanHilang::class,
        'barang' => BarangHilang::class,
        'orang' => OrangHilang::class,
    ];

    public function __construct(GeminiConnectService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function check(string $type, array $data): array
    {
        if (!isset($this->modelMap[$type])) {
            return $this->fail('Tipe laporan tidak dikenali');
        }

        $modelClass = $this->modelMap[$type];

        // Prepare NEW report data
        $newData = [
            'name' => $this->extractName($type, $data),
            'description' => $this->extractDescription($type, $data),
            'ciri_ciri' => $data['ciri_ciri'] ?? [],
        ];

        if (empty($newData['name'])) {
            return $this->fail('Nama belum diisi');
        }

        // Prepare NEW images paths
        $newImagePaths = [];
        if (isset($data['foto']) && is_array($data['foto'])) {
            foreach ($data['foto'] as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $newImagePaths[] = $file->getRealPath();
                }
            }
        }

        // Get existing reports to compare
        // To optimize, we could filter by some basic criteria like category or region, 
        // but for now we'll check recent reports with status 'Hilang'
        $existingReports = $modelClass::where('status', 'Hilang')
            ->latest()
            ->limit(10) // Limit comparison to most recent to save resources
            ->get();

        $highest = 0;
        $best = null;
        $bestReason = '';

        foreach ($existingReports as $old) {
            $oldData = [
                'name' => $old->report_name,
                'description' => $old->deskripsi_hewan ?? $old->deskripsi_orang ?? $old->deskripsi_barang ?? '',
                'ciri_ciri' => $old->ciri_ciri ?? [],
            ];

            $oldImagePaths = [];
            if ($old->foto && is_array($old->foto)) {
                foreach (array_slice($old->foto, 0, 2) as $path) {
                    $fullPath = storage_path('app/public/' . $path);
                    if (file_exists($fullPath)) {
                        $oldImagePaths[] = $fullPath;
                    }
                }
            }

            $aiResult = $this->gemini->checkDuplicate($newData, $oldData, $newImagePaths, $oldImagePaths);
            
            $score = (int)($aiResult['similarity'] ?? 0);

            if ($score > $highest) {
                $highest = $score;
                $best = $old;
                $bestReason = $aiResult['reason'] ?? 'Data mirip dengan laporan sebelumnya';
            }

            // Early exit if high similarity found
            if ($highest >= 70) {
                break;
            }
        }

        $threshold = 70;

        return [
            'isDuplicate' => $highest >= $threshold,
            'similarity' => $highest,
            'reason' => $highest >= $threshold ? $bestReason : 'Tidak ada kemiripan signifikan',
            'details' => $best ? [
                'id' => $best->id,
                'name' => $best->report_name,
                'score' => $highest,
                'reason' => $bestReason
            ] : null
        ];
    }

    protected function calculateSimilarity(
        string $namaNew,
        string $descNew,
        string $lokasiNew,
        string $namaOld,
        string $descOld,
        string $lokasiOld
    ): float {
        similar_text($namaNew, $namaOld, $s1);
        similar_text($descNew, $descOld, $s2);
        similar_text($lokasiNew, $lokasiOld, $s3);

        return ($s1 * 0.4) + ($s2 * 0.3) + ($s3 * 0.3);
    }

    protected function extractName(string $type, array $data): string
    {
        return match ($type) {
            'hewan' => $data['nama_hewan'] ?? '',
            'barang' => $data['nama_barang'] ?? '',
            'orang' => $data['nama_orang'] ?? '',
            default => '',
        };
    }

    protected function extractDescription(string $type, array $data): string
    {
        return match ($type) {
            'hewan' => $data['deskripsi_hewan'] ?? '',
            'barang' => $data['deskripsi_barang'] ?? '',
            'orang' => $data['deskripsi_orang'] ?? '',
            default => '',
        };
    }

    protected function fail(string $reason): array
    {
        return [
            'isDuplicate' => false,
            'similarity' => 0,
            'reason' => $reason,
            'existing_id' => null,
            'existing_report' => null
        ];
    }
}
