<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute() {
        return str()->limit(strip_tags($this->content), 100);
    }

    protected static function booted() {
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title) . '-' . Str::random(5);
        });
    }
}
