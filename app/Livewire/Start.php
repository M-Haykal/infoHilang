<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;

class Start extends Component
{
    public $kategori = 'Semua';

    public function setKategori($value)
    {
        $this->kategori = $value;
    }

    public function render()
    {
        $reports = collect();

        if ($this->kategori === 'Semua' || $this->kategori === 'Barang') {
            $reports = $reports->merge(BarangHilang::latest()->take(8)->get()->map(function($item) {
                $item->tipe = 'Barang';
                $item->display_name = $item->nama_barang;
                $item->display_desc = $item->deskripsi_barang;
                return $item;
            }));
        }

        if ($this->kategori === 'Semua' || $this->kategori === 'Hewan') {
            $reports = $reports->merge(HewanHilang::latest()->take(8)->get()->map(function($item) {
                $item->tipe = 'Hewan';
                $item->display_name = $item->nama_hewan;
                $item->display_desc = $item->deskripsi_hewan;
                return $item;
            }));
        }

        if ($this->kategori === 'Semua' || $this->kategori === 'Orang') {
            $reports = $reports->merge(OrangHilang::latest()->take(8)->get()->map(function($item) {
                $item->tipe = 'Orang';
                $item->display_name = $item->nama_orang;
                $item->display_desc = $item->deskripsi_orang;
                return $item;
            }));
        }

        $finalReports = $reports->sortByDesc('created_at')->take(8);

        $totalBarang = \App\Models\BarangHilang::count();
        $totalHewan = \App\Models\HewanHilang::count();
        $totalOrang = \App\Models\OrangHilang::count();

        $totalLaporan = $totalBarang + $totalHewan + $totalOrang;

        return view('livewire.start', [
            'reports' => $finalReports,
            'totalLaporan' => $totalLaporan
        ])->layout('layouts.index')->title('InfoHilang - Temukan Kembali yang Berharga');
    }
}

