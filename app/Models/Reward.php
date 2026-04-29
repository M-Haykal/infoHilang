<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reward extends Model
{
    protected $fillable = [
        'rewardable_id',
        'rewardable_type',
        'user_id',
        'receiver_id',
        'amount',
        'status',
        'midtrans_order_id',
        'payment_status',
        'admin_note',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Polymorphic relation ke semua entitas yang bisa punya reward
     */
    public function rewardable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User yang membuat laporan dan memberikan reward
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * User yang berhasil menemukan dan menerima reward
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}