<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\LaporanDitemukanService;

class FormReportFound extends Component
{
    use WithFileUploads;

    public $nama_penemu;
    public $kontak_penemu;
    public $lokasi_ditemukan;
    public $keterangan;
    public $tanggal_ditemukan;
    public $bukti_ditemukan = [];
    public $foundable_id;
    public $foundable_type;

    protected function rules()
    {
        return [
            'nama_penemu' => 'required|string|max:255',
            'kontak_penemu' => 'required|string|max:20',
            'lokasi_ditemukan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_ditemukan' => 'nullable|date',
            'bukti_ditemukan' => 'nullable|array|max:3',
            'bukti_ditemukan.*' => 'nullable|image|max:5120',
        ];
    }

    protected $listeners = ['openReportModal'];

    public function openReportModal($id, $type)
    {
        $this->foundable_id = $id;
        $this->foundable_type = $type;
        $this->showReportModal = true;
    }

    public function create(LaporanDitemukanService $service)
    {
        $validated = $this->validate();

        try {
            $service->store([
                ...$validated,
                'foundable_id' => $this->foundable_id,
                'foundable_type' => $this->foundable_type,
            ]);

            $this->reset([
                'nama_penemu',
                'kontak_penemu',
                'lokasi_ditemukan',
                'keterangan',
                'tanggal_ditemukan',
                'bukti_ditemukan'
            ]);

            session()->flash('success', 'Laporan berhasil dikirim dan menunggu validasi.');
            $this->dispatch('report-created');
        } catch (\Exception $th) {
            session()->flash('error', 'Terjadi kesalahan saat mengirim laporan.');
        }

    }

    public function render()
    {
        return view('livewire.form-report-found');
    }
}
