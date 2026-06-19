<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'sender',
        'message',
        'metadata',
        'is_handover',
        'is_handled',
        'handled_by',
        'handled_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_handover' => 'boolean',
        'is_handled' => 'boolean',
        'handled_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}