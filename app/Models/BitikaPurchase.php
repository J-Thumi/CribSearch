<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitikaPurchase extends Model
{
    use HasFactory;

    protected $table = 'bitika_purchases';

    protected $fillable = [
        'user_id',
        'house_id',
        'house_unlock_id',
        'bitika_payment_id',
        'house_info_email_sent_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * User who made the purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * House that was purchased/unlocked.
     */
    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    /**
     * House unlock information associated with this purchase.
     */
    public function houseUnlock(): BelongsTo
    {
        return $this->belongsTo(
            HouseUnlock::class,
            'house_unlock_id'
        );
    }

    /**
     * Bitika payment associated with this purchase.
     */
    public function bitikaPayment(): BelongsTo
    {
        return $this->belongsTo(
            BitikaPayment::class,
            'bitika_payment_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the purchase has been successfully paid.
     */
    public function isPaid(): bool
    {
        return $this->bitikaPayment?->status === BitikaPayment::STATUS_FULFILLED;
    }

    /**
     * Determine whether the payment is still processing.
     */
    public function isProcessing(): bool
    {
        return in_array(
            $this->bitikaPayment?->status,
            [
                BitikaPayment::STATUS_PROCESSING,
                BitikaPayment::STATUS_PROCESSING_PAYMENT,
            ],
            true
        );
    }

    /**
     * Determine whether the payment failed.
     */
    public function isFailed(): bool
    {
        return in_array(
            $this->bitikaPayment?->status,
            [
                BitikaPayment::STATUS_FAILED,
                BitikaPayment::STATUS_PAYMENT_FAILED,
            ],
            true
        );
    }

    /**
     * Get the Bitika transaction code.
     */
    public function getTransactionCode(): ?string
    {
        return $this->bitikaPayment?->transaction_code;
    }

    /**
     * Get the payment amount in KES.
     */
    public function getAmount(): ?int
    {
        return $this->bitikaPayment?->amount_kes;
    }

    /*
    |--------------------------------------------------------------------------
    | Convenience Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the customer's phone number used for the payment.
     */
    public function getPaymentPhone(): ?string
    {
        return $this->bitikaPayment?->phone_number;
    }

    /**
     * Get the M-Pesa receipt.
     */
    public function getMpesaReceipt(): ?string
    {
        return $this->bitikaPayment?->mpesa_receipt;
    }

    /**
     * Get the payment status.
     */
    public function getPaymentStatus(): ?string
    {
        return $this->bitikaPayment?->status;
    }
}