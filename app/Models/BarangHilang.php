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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($stuff) {
            $stuff->slug = Str::random(10);
        });
    }

    public function comentars()
    {
        return $this->morphMany(Comentar::class, 'foundable')
            ->whereNull('parent_id')
            ->latest();
    }

    public function getReportNameAttribute()
    {
        return $this->nama_barang;
    }

    public function getLocationAttribute()
    {
        return $this->lokasi_terakhir_dilihat;
    }

    public function getFotoAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getReportTypeAttribute()
    {
        return 'barang';
    }
}
