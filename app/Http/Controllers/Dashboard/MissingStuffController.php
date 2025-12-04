<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MissingStuffService;
use App\Models\BarangHilang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MissingStuffController extends Controller
{
    protected $missingStuffService;

    public function __construct(MissingStuffService $missingStuffService)
    {
        $this->missingStuffService = $missingStuffService;
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $contacts = ['Nomor Telepon', 'Nomor WhatsApp', 'Alamat Email', 'Instagram', 'Facebook', 'Twitter'];

        return view('dashboard.pages.form-stuff-missing', compact('userId', 'contacts'));
    }

    public function show(BarangHilang $barangHilang)
    {
        $barangHilang->load([
            'comentars.user',
            'comentars.replies.user'
        ]);
        return view('dashboard.pages.detail-stuff-missing', compact('barangHilang'));
    }

    public function edit(BarangHilang $barangHilang)
    {
        $userId = Auth::user()->id;
        $contacts = ['Nomor Telepon', 'Nomor WhatsApp', 'Alamat Email', 'Instagram', 'Facebook', 'Twitter'];

        return view('dashboard.pages.form-edit-stuff-missing', compact('barangHilang', 'userId', 'contacts'));
    }

    public function store(Request $request)
    {
        try {
            $this->missingStuffService->store($request);
            return redirect()->back()->with('success', 'Laporan barang hilang berhasil dikirim!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        }
    }

    public function update(Request $request, BarangHilang $barangHilang)
    {
        $this->missingStuffService->update($request, $barangHilang);
        return redirect()->back()->with('success', 'Data laporan barang hilang berhasil diperbarui!');
    }

    public function destroy(BarangHilang $barangHilang)
    {
        $this->missingStuffService->destroy($barangHilang);
        return redirect()->back()->with('success', 'Laporan barang hilang berhasil dihapus!');
    }
}
