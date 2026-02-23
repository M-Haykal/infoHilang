<?php

namespace App\Services;

use App\Models\LaporanDitemukan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanDitemukanService
{
    public function index($foundableId, $foundableType)
    {
        return LaporanDitemukan::where('foundable_id', $foundableId)
            ->where('foundable_type', $foundableType)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function store(array $data)
    {
        $uploadedImages = [];

        // Handle Upload Jika Ada
        if (!empty($data['bukti_ditemukan'])) {
            foreach ($data['bukti_ditemukan'] as $image) {
                $uploadedImages[] = $image->store('laporan_ditemukan', 'public');
            }
        }

        dd($data, $uploadedImages);

        return LaporanDitemukan::create([
            'nama_penemu' => $data['nama_penemu'],
            'kontak_penemu' => $data['kontak_penemu'],
            'lokasi_ditemukan' => $data['lokasi_ditemukan'],
            'keterangan' => $data['keterangan'] ?? null,
            'tanggal_ditemukan' => $data['tanggal_ditemukan'] ?? now(),
            'bukti_ditemukan' => $uploadedImages,
            'user_id' => Auth::check() ? Auth::id() : null,
            'foundable_id' => $data['foundable_id'],
            'foundable_type' => $data['foundable_type'],
            'is_confirmed' => false,
        ]);
    }
}
