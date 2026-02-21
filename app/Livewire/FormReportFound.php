<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LaporanDitemukan;
use Illuminate\Support\Facades\Auth;

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
            'kontak_penemu' => 'required|string|max:255',
            'lokasi_ditemukan' => 'required|string|max:500',
            'keterangan' => 'nullable|string',
            'tanggal_ditemukan' => 'required|date',
            'bukti_ditemukan.*' => 'nullable|array|max:3',
        ];
    }

    public function create()
    {
        $this->validate();

        $uploadedImages = [];

        if ($this->bukti_ditemukan) {
            foreach ($this->bukti_ditemukan as $image) {
                $uploadedImages[] = $image->store('laporan_ditemukan', 'public');
            }
        }

        LaporanDitemukan::create([
            'nama_penemu' => $this->nama_penemu,
            'kontak_penemu' => $this->kontak_penemu,
            'lokasi_ditemukan' => $this->lokasi_ditemukan,
            'keterangan' => $this->keterangan,
            'tanggal_ditemukan' => $this->tanggal_ditemukan ?? now(),
            'bukti_ditemukan' => $uploadedImages,
            'user_id' => auth()->check() ? Auth::id() : null,
            'foundable_id' => $this->foundable_id,
            'foundable_type' => $this->foundable_type,
            'is_confirmed' => false,
        ]);

        $this->reset([
            'nama_penemu',
            'kontak_penemu',
            'lokasi_ditemukan',
            'keterangan',
            'tanggal_ditemukan',
            'bukti_ditemukan'
        ]);

        $this->dispatch('report-created');

        session()->flash('success', 'Laporan berhasil dikirim dan menunggu validasi.');
    }

    public function render()
    {
        return view('livewire.form-report-found');
    }
}
