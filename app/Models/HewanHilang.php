<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HewanHilang extends Model
{
    use HasFactory;

    protected $table = 'hewan_hilangs';

    protected $fillable = [
        'nama_hewan',
        'jenis_hewan',
        'ras',
        'jenis_kelamin',
        'umur',
        'warna',
        'ciri_ciri',
        'deskripsi_hewan',
        'kontak',
        'foto',
        'lokasi_terakhir_dilihat',
        'latitude',
        'longitude',
        'tanggal_terakhir_dilihat',
        'status',
        'user_id',
    ];

    protected $casts = [
        'ciri_ciri' => 'array',
        'foto' => 'array',
        'kontak' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
