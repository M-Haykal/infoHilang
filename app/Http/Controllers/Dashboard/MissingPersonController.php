<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\GeminiConnectService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Services\MissingPersonService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;

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
        try {
            $this->missingPersonService->store($request);
            return redirect()->back()->with('success', 'Laporan orang hilang berhasil dikirim!');
        } catch (ValidationException $e) {
            if ($e->errors()['duplicate'] ?? false) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($e->errors());
            }
            throw $e;
        }
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

    public function destroy(OrangHilang $orangHilang)
    {
        $this->missingPersonService->destroy($orangHilang);
        return redirect()->back()->with('success', 'Laporan orang hilang berhasil dihapus!');
    }

    public function checkDuplicate(Request $request, MissingPersonService $service)
    {
        try {
            $duplicateCheck = $service->checkForDuplicates($request, $request->all());

            return response()->json([
                'isDuplicate' => $duplicateCheck['isDuplicate'],
                'similarity' => $duplicateCheck['similarity'],
                'reason' => $duplicateCheck['reason'],
                'existing_report' => $duplicateCheck['existing_id'] ? [
                    'url' => route('form-orang-hilang.detail', $duplicateCheck['existing_id'])
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'isDuplicate' => false,
                'similarity' => 0,
                'reason' => 'Gagal cek duplikat'
            ], 500);
        }
    }
}
