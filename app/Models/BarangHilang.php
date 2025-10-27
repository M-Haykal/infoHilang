<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BarangHilang extends Model
{
    use HasFactory;

    protected $table = 'barang_hilangs';

    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'merk_barang',
        'warna_barang',
        'deskripsi_barang',
        'lokasi_terakhir_dilihat',
        'latitude',
        'longitude',
        'tanggal_terakhir_dilihat',
        'ciri_ciri',
        'kontak',
        'foto',
        'document_pendukung',
        'status',
        'user_id',
        'slug',
    ];

    protected $casts = [
        'ciri_ciri' => 'array',
        'kontak' => 'array',
        'foto' => 'array',
        'document_pendukung' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($stuff) {
            $stuff->slug = Str::slug($stuff->nama_barang) . '-' . Str::random(5);
        });
    }
}
