<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Services\MissingPersonService;
use Barryvdh\DomPDF\Facade\Pdf;

class MissingPersonController extends Controller
{
    protected $missingPersonService;

    public function __construct(MissingPersonService $missingPersonService)
    {
        $this->missingPersonService = $missingPersonService;
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $characteristics = ['Tinggi Badan', 'Berat Badan', 'Warna Rambut', 'Warna Kulit', 'Bentuk Wajah', 'Tanda Lahir'];
        $contacts = ['Nomor Telepon', 'Nomor WhatsApp', 'Alamat Email', 'Instagram', 'Facebook', 'Twitter'];

        return view('dashboard.pages.form-person-missing', compact('userId', 'characteristics', 'contacts'));
    }

    public function printPdf(OrangHilang $orangHilang)
    {
        $kontakList = collect($orangHilang->kontak)
            ->reject(fn($v, $k) => $k === 'tes')
            ->map(fn($v, $k) => ucfirst($k) . ': ' . $v)
            ->implode(', ');
        $ciriList = collect($orangHilang->ciri_ciri)
            ->reject(fn($v, $k) => $k === 'tes')
            ->map(fn($v, $k) => ucfirst($k) . ': ' . $v)
            ->implode(', ');
        $pdf = PDF::loadView('dashboard.pdf.poster-missing-person', ['orangHilang' => $orangHilang, 'kontakList' => $kontakList, 'ciriList' => $ciriList]);
        // return $pdf->download('laporan-orang-hilang.pdf');
        return $pdf->stream();
    }

    public function show(OrangHilang $orangHilang)
    {
        $orangHilang->load([
            'comentars.user',
            'comentars.replies.user'
        ]);
        return view('dashboard.pages.detail-person-missing', compact('orangHilang'));
    }

    public function store(Request $request)
    {
        $this->missingPersonService->store($request);
        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    public function edit(OrangHilang $orangHilang)
    {
        $userId = Auth::id();
        $characteristics = ['Tinggi Badan', 'Berat Badan', 'Warna Rambut', 'Warna Kulit', 'Bentuk Wajah', 'Tanda Lahir'];
        $contacts = ['Nomor Telepon', 'Nomor WhatsApp', 'Alamat Email', 'Instagram', 'Facebook', 'Twitter'];
        // dd($orangHilang);
        return view('dashboard.pages.form-edit-person-missing', compact('orangHilang', 'userId', 'characteristics', 'contacts'));
    }

    public function update(Request $request, OrangHilang $orangHilang)
    {
        $this->missingPersonService->update($request, $orangHilang);
        // dd($request->all());
        return redirect()->back()->with('success', 'Data laporan orang hilang berhasil diperbarui!');
    }
}
