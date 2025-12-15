<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MissingAnimalService;
use Illuminate\Validation\ValidationException;

class MissingAnimalController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $jenisPath = public_path('json/animals.json');
        $rasPath = public_path('json/race_animal.json');

        if (!file_exists($jenisPath) || !file_exists($rasPath)) {
            return view('dashboard.pages.form-animal-missing', [
                'jenisHewan' => [],
                'rasHewan' => [],
                'userId' => $userId,
                'error' => 'File JSON tidak ditemukan.'
            ]);
        }

        $jenisHewan = json_decode(file_get_contents($jenisPath), true);
        $rasHewan = json_decode(file_get_contents($rasPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return view('dashboard.pages.form-animal-missing', [
                'jenisHewan' => [],
                'rasHewan' => [],
                'userId' => $userId,
                'error' => 'Format JSON rusak.'
            ]);
        }

        sort($jenisHewan);

        return view('dashboard.pages.form-animal-missing', compact('userId', 'jenisHewan', 'rasHewan'));
    }

    // Di controller
    public function tambahJenis(Request $request)
    {
        $request->validate(['jenis' => 'required|string|min:2|max:50']);

        $jenisBaru = ucwords(strtolower(trim($request->jenis)));

        $file = public_path('json/animals.json');

        if (!file_exists($file)) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan']);
        }

        $daftar = json_decode(file_get_contents($file), true);

        if (in_array($jenisBaru, $daftar)) {
            return response()->json(['success' => false, 'message' => 'Sudah ada']);
        }

        $daftar[] = $jenisBaru;
        sort($daftar);

        file_put_contents($file, json_encode($daftar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }

    // Di controller
    public function tambahRas(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|min:2|max:100',
            'ras' => 'required|string|min:2|max:100'
        ]);

        $jenis = ucwords(trim($request->jenis));
        $ras = ucwords(trim($request->ras));

        $file = public_path('json/race_animal.json');

        if (!file_exists($file)) {
            return response()->json(['success' => false, 'message' => 'File tidak ditemukan']);
        }

        $daftar = json_decode(file_get_contents($file), true) ?? [];

        // Buat array untuk jenis ini jika belum ada
        if (!isset($daftar[$jenis])) {
            $daftar[$jenis] = [];
        }

        // Cek apakah ras sudah ada
        if (in_array($ras, $daftar[$jenis], true)) {
            return response()->json(['success' => false, 'message' => 'Ras sudah ada']);
        }

        // Tambahkan ras baru
        $daftar[$jenis][] = $ras;
        sort($daftar[$jenis]);

        // Simpan ke file
        file_put_contents($file, json_encode($daftar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }

    public function store(Request $request, MissingAnimalService $service)
    {

        dd($request->all());
        try {
            $this->missingAnimalService = $service->store($request);
            return redirect()->back()
                ->with('success', 'Laporan hewan hilang berhasil dibuat!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
