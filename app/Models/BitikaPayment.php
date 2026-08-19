<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitikaPayment extends Model
{
    protected $fillable = [
        'user_id',
        'house_id',
        'house_unlock_id',
        'transaction_code',
        'idempotency_key',
        'amount_kes',
        'phone_number',
        'lightning_address',
        'status',
        'sats',
        'payment_hash',
        'mpesa_receipt',
        'decline_reason',
        'last_event',
        'last_event_id',
        'paid_at',
        'failed_at',
        'last_webhook_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'last_webhook_at' => 'datetime',
    ];

    public const STATUS_PROCESSING = 'processing';
    public const STATUS_PROCESSING_PAYMENT = 'processing_payment';
    public const STATUS_FULFILLED = 'fulfilled';
    public const STATUS_FAILED = 'failed';
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAYMENT_FAILED = 'payment_failed';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function houseUnlock(): BelongsTo
    {
        return $this->belongsTo(HouseUnlock::class);
    }

    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_FULFILLED;
    }

    public function isFailed(): bool
    {
        return in_array($this->status, [
            self::STATUS_FAILED,
            self::STATUS_PAYMENT_FAILED,
        ], true);
    }
}