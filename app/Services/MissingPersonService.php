<?php

namespace App\Services;

use App\Models\OrangHilang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\GeminiConnectService;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class MissingPersonService
{
    protected $gemini;

    public function __construct(GeminiConnectService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // Cek duplikat dulu
        $duplicateCheck = $this->checkForDuplicates($request, $validated);

        if ($duplicateCheck['isDuplicate']) {
            throw ValidationException::withMessages([
                'duplicate' => 'Laporan ini terdeteksi sebagai duplikat! '
                    . 'Kemiripan: ' . $duplicateCheck['similarity'] . '% → '
                    . $duplicateCheck['reason']
            ]);
        }

        return $this->saveData($request, new OrangHilang(), $validated);
    }

    public function update(Request $request, OrangHilang $orangHilang)
    {
        $validated = $this->validateRequest($request, $orangHilang->id);
        return $this->saveData($request, $orangHilang, $validated);
    }

    public function destroy(OrangHilang $orangHilang)
    {
        return $orangHilang->delete();
    }

    // ================== DUPLIKAT DETECTION ==================
    private function checkForDuplicates(Request $request, array $validated)
    {
        $existingReports = OrangHilang::whereIn('status', ['Hilang', 'Ditemukan'])->get();

        $highestSimilarity = 0;
        $isDuplicate = false;
        $reason = '';
        $existingId = null;

        foreach ($existingReports as $report) {
            $imageResult = $this->compareImagesWithExisting($request, $report);
            $textResult = $this->compareTextWithExisting($validated, $report);

            // Bobot: 60% gambar (wajah penting), 40% teks
            $totalScore = ($imageResult['similarity'] * 0.60) + ($textResult['similarity'] * 0.40);

            if ($totalScore > $highestSimilarity) {
                $highestSimilarity = $totalScore;
                $isDuplicate = $imageResult['duplicate'] || $textResult['duplicate'];
                $reason = $imageResult['reason'] ?? $textResult['reason'] ?? 'Kemiripan tinggi';
                $existingId = $report->id;
            }
        }

        return [
            'isDuplicate' => $isDuplicate && $highestSimilarity >= 80,
            'similarity' => round($highestSimilarity),
            'reason' => $reason,
            'existing_id' => $existingId
        ];
    }

    private function compareImagesWithExisting(Request $request, OrangHilang $existing)
    {
        if (!$request->hasFile('foto') || empty($existing->foto)) {
            return ['duplicate' => false, 'similarity' => 0, 'reason' => 'Tidak ada foto'];
        }

        $highest = 0;
        $reason = '';

        foreach ($request->file('foto') as $newFile) {
            $tempPath = $newFile->getPathname();

            foreach ($existing->foto as $oldPath) {
                $oldFullPath = storage_path('app/public/' . $oldPath);
                if (!file_exists($oldFullPath))
                    continue;

                try {
                    $result = $this->gemini->compareImages($tempPath, $oldFullPath);

                    if ($result && ($result['similarity'] ?? 0) > $highest) {
                        $highest = $result['similarity'];
                        $reason = $result['reason'] ?? 'Wajah sangat mirip';
                    }

                    if ($result['duplicate'] ?? false) {
                        return $result;
                    }
                } catch (\Exception $e) {
                    \Log::warning('Gemini image compare failed: ' . $e->getMessage());
                }
            }
        }

        return [
            'duplicate' => $highest >= 90,
            'similarity' => $highest,
            'reason' => $reason ?: 'Wajah tidak terlalu mirip'
        ];
    }

    private function compareTextWithExisting(array $newData, OrangHilang $existing)
    {
        $existingData = $existing->only([
            'nama_orang',
            'umur',
            'jenis_kelamin',
            'ciri_ciri',
            'deskripsi_orang',
            'lokasi_terakhir_dilihat'
        ]);

        $prompt = "
            Kamu adalah AI pendeteksi laporan orang hilang duplikat.
            Bandingkan data baru dengan data lama.

            DATA BARU:
            " . json_encode($newData, JSON_UNESCAPED_UNICODE) . "

            DATA LAMA:
            " . json_encode($existingData, JSON_UNESCAPED_UNICODE) . "

            Berikan hasil dalam JSON tanpa penjelasan tambahan:
            {
                \"duplicate\": true/false,
                \"similarity\": 0-100,
                \"reason\": \"alasan singkat dalam 10 kata\"
            }
        ";

        try {
            $response = $this->gemini->generateContent($prompt);
            $result = json_decode($response, true);

            return $result ?: ['duplicate' => false, 'similarity' => 0, 'reason' => 'Gagal parse AI'];
        } catch (\Exception $e) {
            \Log::error('Gemini text check failed: ' . $e->getMessage());
            return ['duplicate' => false, 'similarity' => 0, 'reason' => 'Error AI'];
        }
    }

    /**
     * Validasi umum
     */
    private function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'nama_orang' => 'required|string|max:255',
            'deskripsi_orang' => 'nullable|string',
            'umur' => 'nullable|integer|min:0|max:150',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'ciri_ciri' => 'nullable|array',
            'kontak' => 'nullable|array',
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
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);
    }

    /**
     * Simpan atau update data ke database
     */
    private function saveData(Request $request, OrangHilang $orangHilang, array $validated)
    {
        // Format ciri-ciri
        $ciriCiri = [];

        // Ciri-ciri dari input utama
        if (!empty($validated['ciri_ciri'])) {
            foreach ($validated['ciri_ciri'] as $key => $value) {
                $key = trim($key);
                $value = trim($value);
                if ($key && $value) {
                    $ciriCiri[$key] = $value;
                }
            }
        }

        // Ciri-ciri dari input dinamis
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

        // Kontak dari input utama
        if (!empty($validated['kontak'])) {
            foreach ($validated['kontak'] as $key => $value) {
                $key = trim($key);
                $value = trim($value);
                if ($key && $value) {
                    $kontak[$key] = $value;
                }
            }
        }

        // Kontak dari input dinamis
        if (!empty($validated['kontak_keys'])) {
            foreach ($validated['kontak_keys'] as $i => $key) {
                $key = trim($key);
                $val = trim($validated['kontak_values'][$i] ?? '');
                if ($key && $val) {
                    $kontak[$key] = $val;
                }
            }
        }

        // Ambil foto lama
        $fotoPaths = $orangHilang->foto ?? [];

        // Hapus yang di-delete
        if ($request->filled('deleted_foto')) {
            foreach ($request->deleted_foto as $path) {
                Storage::disk('public')->delete($path);
                $fotoPaths = array_filter($fotoPaths, fn($p) => $p !== $path);
            }
            $fotoPaths = array_values($fotoPaths);
        }

        // Tambah foto baru
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('orang', 'public');
            }
        }

        // Batasi 5
        $fotoPaths = array_slice($fotoPaths, 0, 5);

        $cleanDescription = Purifier::clean($validated['deskripsi_orang'] ?? '');
        $cleanLocation = Purifier::clean($validated['lokasi_terakhir_dilihat'] ?? '');

        $orangHilang->foto = $fotoPaths;

        $orangHilang->fill([
            'nama_orang' => $validated['nama_orang'],
            'deskripsi_orang' => $cleanDescription,
            'umur' => $validated['umur'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'ciri_ciri' => $ciriCiri,
            'kontak' => $kontak,
            'lokasi_terakhir_dilihat' => $cleanLocation,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'tanggal_terakhir_dilihat' => $validated['tanggal_terakhir_dilihat'] ?? null,
            'status' => $validated['status'],
            'foto' => $fotoPaths,
            'user_id' => $validated['user_id'],
        ])->save();

        return $orangHilang;
    }
}
