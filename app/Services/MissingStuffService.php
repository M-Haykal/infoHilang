<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\BarangHilang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class MissingStuffService
{
    protected $duplicateDetection;

    public function __construct(DuplicateDetectionService $duplicateDetection)
    {
        $this->duplicateDetection = $duplicateDetection;
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // CEK DUPLIKAT DULU!
        //  $duplicateCheck = $this->duplicateDetection
        //     ->check($type, $request->all());

        // if ($duplicateCheck['isDuplicate']) {
        //     // Bisa return array atau throw exception
        //     throw ValidationException::withMessages([
        //         'duplicate' => 'Laporan barang ini terdeteksi sebagai duplikat! '
        //             . 'Kemiripan: ' . $duplicateCheck['similarity'] . '%. '
        //             . $duplicateCheck['reason']
        //     ]);
        // }

        return $this->saveData($request, new BarangHilang(), $validated);
    }

    public function update(Request $request, BarangHilang $barangHilang)
    {
        $validated = $this->validateRequest($request, $barangHilang->id);
        return $this->saveData($request, $barangHilang, $validated);
    }

    public function destroy(BarangHilang $barangHilang)
    {
        // Hapus file foto
        if ($barangHilang->foto) {
            foreach ($barangHilang->foto as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        // Hapus dokumen
        if ($barangHilang->document_pendukung) {
            foreach ($barangHilang->document_pendukung as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        return $barangHilang->delete();
    }

    /**
     * Validasi umum
     */
    private function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:50',
            'merk_barang' => 'nullable|string|max:255',
            'warna_barang' => 'nullable|string|max:50',
            'deskripsi_barang' => 'nullable|string',
            'lokasi_terakhir_dilihat' => 'required|string|max:255',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'tanggal_terakhir_dilihat' => 'nullable|date',
            'status' => 'required|in:Hilang,Ditemukan,Ditutup',
            'ciri_ciri' => 'nullable|array',
            'kontak' => 'nullable|array',
            'ciri_ciri_keys' => 'nullable|array',
            'ciri_ciri_values' => 'nullable|array',
            'kontak_keys' => 'nullable|array',
            'kontak_values' => 'nullable|array',
            'foto' => 'nullable|array|max:5',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'document_pendukung' => 'nullable|array|max:3',
            'document_pendukung.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // max 5MB
            'user_id' => 'required|exists:users,id',
        ]);
    }

    /**
     * Simpan atau update data ke database
     */
    private function saveData(Request $request, BarangHilang $barangHilang, array $validated)
    {
        // Format ciri-ciri
        $ciriCiri = [];

        if (!empty($validated['ciri_ciri'])) {
            foreach ($validated['ciri_ciri'] as $key => $value) {
                $key = trim($key);
                $value = trim($value);
                if ($key && $value) {
                    $ciriCiri[$key] = $value;
                }
            }
        }

        if (!empty($validated['ciri_ciri_keys'])) {
            foreach ($validated['ciri_ciri_keys'] as $i => $key) {
                $key = trim($key);
                $val = trim($validated['ciri_ciri_values'][$i] ?? '');
                if ($key && $val) {
                    $ciriCiri[$key] = $val;
                }
            }
        }

        // Format kontak
        $kontak = [];

        if (!empty($validated['kontak'])) {
            foreach ($validated['kontak'] as $key => $value) {
                $key = trim($key);
                $value = trim($value);
                if ($key && $value) {
                    $kontak[$key] = $value;
                }
            }
        }

        if (!empty($validated['kontak_keys'])) {
            foreach ($validated['kontak_keys'] as $i => $key) {
                $key = trim($key);
                $val = trim($validated['kontak_values'][$i] ?? '');
                if ($key && $val) {
                    $kontak[$key] = $val;
                }
            }
        }

        // === Foto ===
        $fotoPaths = $barangHilang->foto ?? [];

        if ($request->filled('deleted_foto')) {
            foreach ($request->deleted_foto as $path) {
                Storage::disk('public')->delete($path);
                $fotoPaths = array_filter($fotoPaths, fn($p) => $p !== $path);
            }
            $fotoPaths = array_values($fotoPaths);
        }

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('barang', 'public');
            }
        }

        $fotoPaths = array_slice($fotoPaths, 0, 5);

        // === Dokumen ===
        $docPaths = $barangHilang->document_pendukung ?? [];

        if ($request->filled('deleted_document')) {
            foreach ($request->deleted_document as $path) {
                Storage::disk('public')->delete($path);
                $docPaths = array_filter($docPaths, fn($p) => $p !== $path);
            }
            $docPaths = array_values($docPaths);
        }

        if ($request->hasFile('document_pendukung')) {
            foreach ($request->file('document_pendukung') as $file) {
                $docPaths[] = $file->store('document', 'public');
            }
        }

        $docPaths = array_slice($docPaths, 0, 3);

        $cleanDescription = Purifier::clean($validated['deskripsi_barang']);
        $cleanLokasi = Purifier::clean($validated['lokasi_terakhir_dilihat']);

        $barangHilang->fill([
            'nama_barang' => $validated['nama_barang'],
            'jenis_barang' => $validated['jenis_barang'],
            'merk_barang' => $validated['merk_barang'] ?? null,
            'warna_barang' => $validated['warna_barang'] ?? null,
            'deskripsi_barang' => $cleanDescription,
            'lokasi_terakhir_dilihat' => $cleanLokasi,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'tanggal_terakhir_dilihat' => $validated['tanggal_terakhir_dilihat'] ?? null,
            'status' => $validated['status'],
            'ciri_ciri' => $ciriCiri,
            'kontak' => $kontak,
            'foto' => $fotoPaths,
            'document_pendukung' => $docPaths,
            'user_id' => $validated['user_id'],
        ])->save();

        return $barangHilang;
    }

}
