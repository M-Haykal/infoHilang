<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;
use Illuminate\Http\Request;
use App\Models\LaporanDitemukan;

class DetailMissing extends Component
{
    public $data;
    public $riwayatPenemuan = [];

    public function mount($type, $slug)
    {
        // Cari data berdasarkan tipe
        $report = match (strtolower($type)) {
            'barang' => BarangHilang::where('slug', $slug)->firstOrFail(),
            'hewan' => HewanHilang::where('slug', $slug)->firstOrFail(),
            'orang' => OrangHilang::where('slug', $slug)->firstOrFail(),
            default => abort(404),
        };

        $this->riwayatPenemuan = LaporanDitemukan::with('user')
            ->where('foundable_id', $report->id)
            ->where('foundable_type', get_class($report))
            ->latest()
            ->get();
            
        $this->data = [
            'type' => ucfirst($type),
            'title' => $report->nama_barang ?? $report->nama_hewan ?? $report->nama_orang,
            'image' => is_array($report->foto) ? $report->foto : [$report->foto ?? 'default.jpg'],
            'date' => $report->tanggal_terakhir_dilihat,
            'location' => $report->lokasi_terakhir_dilihat,
            'description' => $report->deskripsi_barang ?? $report->deskripsi_hewan ?? $report->deskripsi_orang,
            'status' => $report->status,
            'raw' => $report,

            'grid_info' => match (strtolower($type)) {
                'orang' => [
                    ['label' => 'Gender', 'value' => $report->jenis_kelamin, 'icon' => 'fa-venus-mars'],
                    ['label' => 'Usia', 'value' => $report->umur ?? '–', 'icon' => 'fa-user-clock'],
                    ['label' => 'Tinggi', 'value' => $report->ciri_ciri['Tinggi Badan'] ? $report->ciri_ciri['Tinggi Badan'] : '–', 'icon' => 'fa-arrows-up-down'],
                ],
                'barang' => [
                    ['label' => 'Jenis', 'value' => $report->jenis_barang ?? '–', 'icon' => 'fa-tag'],
                    ['label' => 'Warna', 'value' => $report->warna_barang ?? '–', 'icon' => 'fa-palette'],
                    ['label' => 'Merk', 'value' => $report->merk_barang ?? '–', 'icon' => 'fa-industry'],
                ],
                'hewan' => [
                    ['label' => 'Jenis/Ras', 'value' => $report->ras ?? '–', 'icon' => 'fa-paw'],
                    ['label' => 'Warna Bulu', 'value' => $report->warna ?? '–', 'icon' => 'fa-palette'],
                    ['label' => 'Usia', 'value' => $report->umur ? $report->umur . ' th' : '–', 'icon' => 'fa-hourglass-half'],
                ],
                default => [],
            },
        ];
    }

    public function render()
    {
        return view('livewire.detail-missing')->layout('layouts.index')
            ->title('Daftar Hilang | InfoHilang');
    }
}
