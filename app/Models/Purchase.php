<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invite_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the invoice associated with this purchase.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Scope a query to only include pending purchases (unpaid).
     */
    public function scopePending($query)
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_PENDING);
        });
    }
    public function scopePaid($query)
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_PAID);
        });
    }
    public function scopeExpired($query)
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_EXPIRED);
        });
    }
    public function scopeCancelled($query)
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_CANCELLED);
        });
    }
}