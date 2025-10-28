<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'slug',
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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($animal) {
            $animal->slug = Str::slug($animal->nama_hewan) . '-' . Str::random(5);
        });
    }

    public function comentars()
    {
        return $this->morphMany(Comentar::class, 'foundable')
            ->whereNull('parent_id')
            ->latest();
    }
}
