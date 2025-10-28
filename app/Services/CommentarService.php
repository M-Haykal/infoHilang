<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Comentar;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CommentarService
{
    /**
     * Simpan Komentar Baru
     */

    public function store(Request $request)
    {
        // Daftar model yang diizinkan + mapping ke tabel
        $allowedTypes = [
            'App\Models\BarangHilang' => 'barang_hilangs',
            'App\Models\OrangHilang' => 'orang_hilangs',
            'App\Models\HewanHilang' => 'hewan_hilangs',
        ];

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'foundable_type' => ['required', 'string', Rule::in(array_keys($allowedTypes))],
            'foundable_id' => 'required|integer',
            'parent_id' => 'nullable|exists:comentars,id',
        ]);

        $foundableType = $validated['foundable_type'];
        $foundableId = $validated['foundable_id'];

        // Validasi foundable_id terhadap tabel yang benar
        if (!isset($allowedTypes[$foundableType])) {
            throw new \InvalidArgumentException('Invalid foundable type');
        }

        $tableName = $allowedTypes[$foundableType];
        if (!DB::table($tableName)->where('id', $foundableId)->exists()) {
            throw ValidationException::withMessages([
                'foundable_id' => "Data tidak ditemukan di {$tableName}."
            ]);
        }

        return Comentar::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'foundable_type' => $foundableType,
            'foundable_id' => $foundableId,
        ]);
    }

    public function update(Request $request, Comentar $comentar)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comentar->update([
            'content' => $validated['content'],
        ]);

        return $comentar;
    }

    public function delete(Comentar $comentar)
    {
        $comentar->delete();
        return true;
    }
}
