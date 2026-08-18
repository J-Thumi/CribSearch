<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IntaSendInvoice extends Model
{
    protected $table = 'intasend_invoices';
    protected $fillable = [
        'user_id',
        'house_unlock_id',
        'tracking_id',
        'api_ref',
        'phone_number',
        'amount',
        'status',
        'mpesa_reference',
        'client_ip',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount'  => 'decimal:2',
    ];

    public function isPaid(): bool
    {
        return strtoupper($this->status) === 'COMPLETE' || strtoupper($this->status) === 'SUCCESS';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function houseUnlock(): BelongsTo
    {
        return $this->belongsTo(HouseUnlock::class);
    }

    public function purchase(): HasOne
    {
        return $this->hasOne(Purchase::class, 'intasend_invoice_id');
    }
}