<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\FormReportFound;

class FormReportFoundTest extends TestCase
{
    /** @test */
    public function open_report_modal_sets_properties_and_resets()
    {
        Livewire::test(FormReportFound::class)
            ->set('nama_penemu', 'dummy')
            ->set('kontak_penemu', '1234')
            ->call('openReportModal', 123, \App\Models\BarangHilang::class, 'Foo Item')
            ->assertSet('showReportModal', true)
            ->assertSet('contextTitle', 'Foo Item')
            ->assertSet('foundable_id', 123)
            ->assertSet('foundable_type', \App\Models\BarangHilang::class)
            ->assertSet('nama_penemu', '')
            ->assertSet('kontak_penemu', '');
    }

    /** @test */
    public function create_requires_required_fields()
    {
        Livewire::test(FormReportFound::class)
            ->call('create')
            ->assertHasErrors([
                'nama_penemu' => 'required',
                'kontak_penemu' => 'required',
                'lokasi_ditemukan' => 'required',
                'foundable_id' => 'required',
                'foundable_type' => 'required',
            ]);
    }
}
