<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;
use App\Services\DuplicateDetectionService;

class DuplicateCheckController extends Controller
{
    protected $duplicateDetection;

    public function __construct(DuplicateDetectionService $duplicateDetection)
    {
        $this->duplicateDetection = $duplicateDetection;
    }

    public function check(Request $request, $type)
    {
        // Tentukan model & konfigurasi per tipe
        $config = [
            'orang' => [
                'model' => OrangHilang::class,
                'fields' => ['nama_orang', 'umur', 'jenis_kelamin', 'deskripsi_orang', 'ciri_ciri', 'lokasi_terakhir_dilihat'],
                'image_weight' => 0.60,
                'threshold' => 80,
                'route' => 'form-orang-hilang.detail'
            ],
            'hewan' => [
                'model' => HewanHilang::class,
                'fields' => ['nama_hewan', 'jenis_hewan', 'ras', 'warna', 'umur', 'ciri_ciri'],
                'image_weight' => 0.75,
                'threshold' => 78,
                'route' => 'form-hewan-hilang.store'
            ],
            'barang' => [
                'model' => BarangHilang::class,
                'fields' => ['nama_barang', 'jenis_barang', 'merk_barang', 'warna_barang', 'deskripsi_barang'],
                'image_weight' => 0.85,
                'threshold' => 75,
                'route' => 'form-barang-hilang.detail'
            ],
        ];

        if (!isset($config[$type])) {
            return response()->json(['error' => 'Tipe tidak valid'], 400);
        }

        $cfg = $config[$type];

        try {
            $result = $this->duplicateDetection
                ->check($type, $request->all());

            // Tambahkan URL kalau ada laporan mirip
            if ($result['existing_id']) {
                $result['existing_report'] = [
                    'url' => route($cfg['route'], $result['existing_id'])
                ];
            }

            return response()->json($result);
        } catch (\Exception $e) {
            \Log::error('Duplicate check failed: ' . $e->getMessage());
            return response()->json([
                'isDuplicate' => false,
                'similarity' => 0,
                'reason' => 'Gagal cek duplikat. Coba lagi.',
                'existing_report' => null
            ], 500);
        }
    }
}
