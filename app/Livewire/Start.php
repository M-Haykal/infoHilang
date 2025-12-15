<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;

class Start extends Component
{
    public function render()
    {
        $barangHilang = BarangHilang::latest()->take(3)->get();
        $hewanHilang = HewanHilang::latest()->take(3)->get();
        $orangHilang = OrangHilang::latest()->take(3)->get();

        return view('livewire.start', [
            'barangHilang' => $barangHilang,
            'hewanHilang' => $hewanHilang,
            'orangHilang' => $orangHilang,
        ])->layout('layouts.index')->title('InfoHilang - Platform Lapor & Temukan Orang, Hewan, Barang Hilang');
    }
}

