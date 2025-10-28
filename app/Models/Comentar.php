<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentar extends Model
{
    use HasFactory;

    protected $table = 'comentars';

    protected $fillable = [
        'content',
        'foundable_id',
        'foundable_type',
        'parent_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comentar::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comentar::class, 'parent_id');
    }

    public function foundable()
    {
        return $this->morphTo();
    }
}
