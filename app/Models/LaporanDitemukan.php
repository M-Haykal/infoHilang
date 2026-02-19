<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDitemukan extends Model
{
    use HasFactory;

    protected $table = 'laporan_ditemukans';

    protected $fillable = [
        'nama_penemu',
        'kontak_penemu',
        'keterangan',
        'lokasi_ditemukan',
        'latitude',
        'longitude',
        'tanggal_ditemukan',
        'bukti_ditemukan',
        'user_id',
        'foundable_id',
        'foundable_type',
        'is_confirmed'
    ];

    protected $casts = [
        'bukti_ditemukan' => 'array'
    ]

    public function foundable()
    {
        return $this->morphTo();
    }
}
