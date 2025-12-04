<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BarangHilang;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use Illuminate\Pagination\LengthAwarePaginator;

class ListMissing extends Component
{
    public function render()
    {
        $barangHilang = BarangHilang::all();
        $orangHilang = OrangHilang::all();
        $hewanHilang = HewanHilang::all();

        // Gabungkan semua data
        $allReports = $barangHilang->concat($orangHilang)->concat($hewanHilang);

        // Acak urutan data gabungan
        $shuffledReports = $allReports->shuffle();

        $page = request()->get('page', 1);
        $perPage = 9;
        $paginator = new LengthAwarePaginator(
            $shuffledReports->forPage($page, $perPage),
            $shuffledReports->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.list-missing', [
            'reports' => $paginator,
        ])->layout('layouts.index')->title('Daftar Hilang | InfoHilang');
    }
}
