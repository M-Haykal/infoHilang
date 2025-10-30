<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrangHilang extends Model
{
    use HasFactory;

    protected $table = 'orang_hilangs';

    protected $fillable = [
        'nama_orang',
        'deskripsi_orang',
        'umur',
        'jenis_kelamin',
        'ciri_ciri',
        'foto',
        'kontak',
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
        'kontak' => 'array',
        'foto' => 'array',
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
        static::creating(function ($person) {
            $person->slug = Str::random(10);
        });
    }

    public function comentars()
    {
        return $this->morphMany(Comentar::class, 'foundable')
            ->whereNull('parent_id')
            ->latest();
    }
}
