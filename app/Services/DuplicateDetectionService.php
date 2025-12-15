<?php

namespace App\Services;

use App\Models\HewanHilang;
use App\Models\BarangHilang;
use App\Models\OrangHilang;

class DuplicateDetectionService
{
    protected array $modelMap = [
        'hewan' => HewanHilang::class,
        'barang' => BarangHilang::class,
        'orang' => OrangHilang::class,
    ];

    public function check(string $type, array $data): array
    {
        if (!isset($this->modelMap[$type])) {
            return $this->fail('Tipe laporan tidak dikenali');
        }

        $modelClass = $this->modelMap[$type];

        $nama = strtolower(trim($this->extractName($type, $data)));
        $lokasi = strtolower(trim($data['lokasi_terakhir_dilihat'] ?? ''));
        $deskripsi = strtolower(trim($this->extractDescription($type, $data)));

        if ($nama === '') {
            return $this->fail('Nama belum diisi');
        }

        $existingReports = $modelClass::where('status', 'Hilang')->get();

        $highest = 0;
        $best = null;

        foreach ($existingReports as $old) {
            $score = $this->calculateSimilarity(
                $nama,
                $deskripsi,
                $lokasi,
                strtolower($old->report_name ?? ''),
                strtolower($old->deskripsi ?? ''),
                strtolower($old->location ?? '')
            );

            if ($score > $highest) {
                $highest = $score;
                $best = $old;
            }
        }

        return [
            'isDuplicate' => $highest >= 65,
            'similarity' => round($highest),
            'reason' => $highest >= 65
                ? 'Data mirip dengan laporan sebelumnya'
                : 'Tidak ada kemiripan signifikan',
            'existing_id' => $best?->id,
            'existing_report' => $best ? [
                'type' => $best->report_type,
                'name' => $best->report_name,
                'url' => url("/user/form-{$best->report_type}-hilang?{$best->id}")
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
