<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

use App\Models\OrangHilang;

class MissingPersonController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $characteristics = ['Tinggi Badan', 'Berat Badan', 'Warna Rambut', 'Warna Kulit', 'Bentuk Wajah', 'Tanda Lahir'];
        $contacts = ['Nomor Telepon', 'Nomor WhatsApp', 'Alamat Email', 'Instagram', 'Facebook', 'Twitter'];

        return view('dashboard.pages.form-person-missing', compact('userId', 'characteristics', 'contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_orang' => 'required|string|max:255',
            'deskripsi_orang' => 'nullable|string',
            'umur' => 'nullable|integer|min:0|max:150',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'ciri_ciri_keys' => 'nullable|array',
            'ciri_ciri_values' => 'nullable|array',
            'kontak_keys' => 'nullable|array',
            'kontak_values' => 'nullable|array',
            'lokasi_terakhir_dilihat' => 'required|string|max:255',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'tanggal_terakhir_dilihat' => 'nullable|date',
            'status' => 'required|in:Hilang,Ditemukan,Ditutup',
            'foto' => 'nullable|array|max:5',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048', // max 2MB per foto
            'user_id' => 'required|exists:users,id',
        ]);

        $ciriCiri = [];
        if ($request->filled('ciri_ciri_keys')) {
            foreach ($request->ciri_ciri_keys as $index => $key) {
                $key = trim($key);
                $value = trim($request->ciri_ciri_values[$index] ?? '');
                if (!empty($key) && !empty($value)) {
                    $ciriCiri[$key] = $value;
                }
            }
        }

        $kontak = [];
        if ($request->filled('kontak_keys')) {
            foreach ($request->kontak_keys as $index => $key) {
                $key = trim($key);
                $value = trim($request->kontak_values[$index] ?? '');
                if (!empty($key) && !empty($value)) {
                    $kontak[$key] = $value;
                }
            }
        }
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('orang', 'public');
                $fotoPaths[] = $path;
            }
        }

        // dd($request->all());

        $laporan = OrangHilang::create([
            'nama_orang' => $request->nama_orang,
            'deskripsi_orang' => $request->deskripsi_orang,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ciri_ciri' => $ciriCiri,
            'kontak' => $kontak,
            'lokasi_terakhir_dilihat' => $request->lokasi_terakhir_dilihat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tanggal_terakhir_dilihat' => $request->tanggal_terakhir_dilihat,
            'status' => $request->status,
            'foto' => $fotoPaths,
            'user_id' => $request->user_id,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');

    }
}
