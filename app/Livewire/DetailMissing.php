<?php

namespace App\Livewire;

use Livewire\Component;

class DetailMissing extends Component
{
    public function render()
    {
        return view('livewire.detail-missing')->layout('layouts.index')->title('Detail Hilang | InfoHilang');
    }
}
