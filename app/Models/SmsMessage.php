<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsMessage extends Model
{
    protected $fillable = [
        'user_id',
        'house_id',
        'purchase_id',
        'phone_number',
        'message',
        'status',
        'attempts',
        'sent_at',
        'next_attempt_at',
        'error_message',
        'type',
        'provider_response',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'next_attempt_at' => 'datetime',
        'provider_response' => 'array',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(
            BitikaPurchase::class,
            'purchase_id'
        );
    }
}