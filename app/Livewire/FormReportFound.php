<?php

namespace App\Livewire;

use Livewire\Component;

class FormReportFound extends Component
{
    public function render()
    {
        return view('livewire.form-report-found')->layout('layouts.index')->title('Form Laporan Ditemukan | InfoHilang');
    }
}
