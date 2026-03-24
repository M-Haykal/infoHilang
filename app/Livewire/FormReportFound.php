<?php

namespace App\Livewire;

use App\Events\ReportFoundCreated;
use Livewire\Component;
use Livewire\Attributes\On; // Tambahkan ini
use Livewire\WithFileUploads;
use App\Services\LaporanDitemukanService;

class FormReportFound extends Component
{
    use WithFileUploads;

    public $showReportModal = false;

    public $nama_penemu;
    public $kontak_penemu;
    public $lokasi_ditemukan;
    public $keterangan;
    public $tanggal_ditemukan;
    public $bukti_ditemukan = [];
    public $foundable_id;
    public $foundable_type;
    public $isGuest = true;
    public $laporAnonim = false;
    public $isiKontak = false;

    public function mount()
    {
        if (auth()->check()) {
            $this->nama_penemu = auth()->user()->name;
            $this->kontak_penemu = auth()->user()->phone ?? null;
        }
    }

    protected function rules()
    {
        return [
            'nama_penemu' => 'nullable|string|max:255',
            'kontak_penemu' => 'nullable|string|max:20',
            'lokasi_ditemukan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_ditemukan' => 'nullable|date',
            'bukti_ditemukan' => 'nullable|array|max:3',
            'bukti_ditemukan.*' => 'nullable|image|max:5120',
        ];
    }

    // ✅ CARA 1: Menggunakan PHP 8 Attribute (Recommended untuk LW 3.6)
    #[On('openReportModal')]
    public function openReportModal($id = null, $type = null)
    {
        $this->foundable_id = $id;
        $this->foundable_type = $type;
        $this->showReportModal = true;
    }

    // ✅ CARA 2: Jika tetap pakai $listeners, pastikan format benar
    // protected $listeners = [
    //     'openReportModal' => 'openReportModal'
    // ];

    public function create(LaporanDitemukanService $service)
    {
        $this->validate();

        $nama = $this->laporAnonim ? null : $this->nama_penemu;

        $report = $service->store([
            'nama_penemu' => $nama,
            'kontak_penemu' => $this->kontak_penemu,
            'lokasi_ditemukan' => $this->lokasi_ditemukan,
            'keterangan' => $this->keterangan,
            'tanggal_ditemukan' => $this->tanggal_ditemukan,
            'bukti_ditemukan' => $this->bukti_ditemukan,
            'foundable_id' => $this->foundable_id,
            'foundable_type' => $this->foundable_type,
            'user_id' => auth()->id()
        ]);

        broadcast(new ReportFoundCreated($report));

        $this->dispatch('reportCreated');

        $this->reset();
        $this->showReportModal = false;
    }

    public function render()
    {
        return view('livewire.form-report-found');
    }
}