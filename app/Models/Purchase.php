<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'invoice_id',
        'house_id',
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
     * Get the user associated with this purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include pending purchases (unpaid).
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_PENDING);
        });
    }

    /**
     * Scope a query to only include paid purchases.
     */
    public function scopePaid(Builder $query): Builder
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_PAID);
        });
    }

    /**
     * Scope a query to only include expired purchases.
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_EXPIRED);
        });
    }

    /**
     * Scope a query to only include cancelled purchases.
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->whereHas('invoice', function ($q) {
            $q->where('status', Invoice::STATUS_CANCELLED);
        });
    }

    /**
     * Get the latest house unlock associated with this purchase.
     */

public function houseUnlock(): HasOne
{
    return $this->hasOne(HouseUnlock::class, 'house_id', 'house_id')
        ->latestOfMany();
}
}