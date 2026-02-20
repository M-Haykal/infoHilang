<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;

class DetailMissing extends Component
{
    public $report;

    public function mount($type, $slug)
    {
        $type = strtolower($type);

        $this->report = match ($type) {
            'barang' => BarangHilang::where('slug', $slug)->firstOrFail(),
            'hewan' => HewanHilang::where('slug', $slug)->firstOrFail(),
            'orang' => OrangHilang::where('slug', $slug)->firstOrFail(),
            default => abort(404),
        };
    }

    public function render()
    {
        return view('livewire.detail-missing')->layout('layouts.index')->title('Detail Hilang | InfoHilang');
    }
}
