<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Purchase;
use App\Services\TelegramService;
use App\Services\UjumbeSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlinkWebhookController extends Controller
{
    /**
     * Handle incoming webhook from Blink when invoice is paid
     * Callback URL: https://your-domain.com/api/blink/webhook
     */
    public function handle(Request $request)
    {

        return;
        
        // Log the raw request for debugging
        Log::info('Blink webhook received', $request->all());

        $clientIp = $request->ip();
        Log::info('Client IP address', ['ip' => $clientIp]);

        $payload = $request->all();

        // Check for receive.lightning event (payment received)
        $eventType = $payload['eventType'] ?? null;
        
        if ($eventType !== 'receive.lightning') {
            Log::info('Ignoring non-payment event', ['eventType' => $eventType]);
            return response()->json(['status' => 'ignored', 'eventType' => $eventType]);
        }

        // Extract transaction data
        $transaction = $payload['transaction'] ?? [];
        
        if (empty($transaction)) {
            Log::error('Webhook missing transaction data', ['payload' => $payload]);
            return response()->json(['error' => 'Missing transaction data'], 400);
        }

        // Get payment hash from initiationVia
        $paymentHash = $transaction['initiationVia']['paymentHash'] ?? null;
        
        if (!$paymentHash) {
            Log::error('Webhook missing payment hash', ['transaction' => $transaction]);
            return response()->json(['error' => 'Missing payment hash'], 400);
        }

        // Get settlement amount in satoshis
        $settlementAmount = $transaction['settlementAmount'] ?? 0;
        
        Log::info('Processing Lightning payment', [
            'payment_hash' => $paymentHash,
            'amount_sats' => $settlementAmount,
            'status' => $transaction['status'],
            'wallet_id' => $payload['walletId']
        ]);

        // Find the invoice by payment_hash
        $invoice = Invoice::where('payment_hash', $paymentHash)->first();

        if (!$invoice) {
            Log::warning('Invoice not found for webhook', [
                'payment_hash' => $paymentHash,
                'searching_in' => 'invoices table'
            ]);
            return response()->json(['status' => 'invoice_not_found', 'payment_hash' => $paymentHash]);
        }

        Log::info('Found invoice', [
            'invoice_id' => $invoice->id,
            'current_status' => $invoice->status,
            'amount_sats' => $invoice->amount_msat / 1000,
            'expected_amount' => $invoice->amount_msat / 1000,
            'received_amount' => $settlementAmount
        ]);

        // Check if already processed
        if ($invoice->isPaid()) {
            Log::info('Invoice already marked as paid', ['invoice_id' => $invoice->id]);

            return response()->json(['status' => 'already_processed', 'invoice_id' => $invoice->id]);
        }

        // Verify amount matches (optional, with tolerance)
        $expectedSats = $invoice->amount_msat / 1000;

        if (abs($expectedSats - $settlementAmount) > 1) { // 1 sat tolerance
            Log::warning('Payment amount mismatch', [
                'expected' => $expectedSats,
                'received' => $settlementAmount,
                'invoice_id' => $invoice->id
            ]);
            // Still process but log warning
        }

        // Mark invoice as paid
        $invoice->markAsPaid();

        $invoice->update([
            'paid_at' => now(),
            'satoshis_paid' => $settlementAmount * 1000, // Update with actual received amount
            'blink_client_ip' => $clientIp,
        ]);
        Log::info('Invoice marked as paid', ['invoice_id' => $invoice->id]);

        // Find the associated purchase and eager-load houseUnlock + house
        $purchase = Purchase::with(['houseUnlock.house'])
            ->where('invoice_id', $invoice->id)
            ->first();
        
        if (!$purchase) {
            Log::error('No purchase record found for paid invoice', [
                'invoice_id' => $invoice->id,
                'invoice' => $invoice->toArray()
            ]);
            return response()->json(['error' => 'Purchase not found'], 500);
        }

        $this->sendHouseInfo($purchase);

        return response()->json([
            'status' => 'success',
            'invoice_id' => $invoice->id,
            'user_notified' => true
        ]);
    }

    public function sendHouseInfo(Purchase $purchase){

        $ujumbe= new UjumbeSMS();
        // This function sends the house unlock information to the user via Ujumbe SMS after a successful payment. It gets the house unlock record associated with the purchase and sends the caretaker's phone number and location to the user's phone number.

        $houseUnlock = $purchase->houseUnlock;

        if (!$houseUnlock) {
            Log::error('No house unlock record found for purchase', [
                'purchase_id' => $purchase->id,
                'user_id' => $purchase->user_id,
                'house_id' => $purchase->house_id ?? null,
            ]);
            return;
        }

        $house = $houseUnlock->house;

        if (!$house) {
            Log::error('Associated house details missing for unlock record', [
                'house_unlock_id' => $houseUnlock->id,
                'house_id' => $houseUnlock->house_id
            ]);
            return;
        }

        $caretakerPhone = $house?->caretaker_phone;
        $lat = $house?->lat;
        $long = $house?->long;
        $location = "https://www.google.com/maps?q={$lat},{$long}";
        $scoutPhone = $house?->contact_number;

        if (!$caretakerPhone || !$lat || !$long) {
            Log::error('Caretaker phone or location missing for house', [
                'house_id' => $houseUnlock->house_id,
                'caretaker_phone' => $caretakerPhone,
                'location' => $location
            ]);

            $ujumbe->send($houseUnlock->text_phone_number, "Your house is now unlocked. However, caretaker phone number or location is missing. Please contact support for assistance. Scout Phone: $scoutPhone");
            return;
        }
        $message = "Caretaker: {$caretakerPhone[0]['phone']}, Location: {$location}. If you want to be taken to the house, call scout at {$scoutPhone}.";

        $ujumbe->send($houseUnlock->text_phone_number, $message);

        Log::info('House unlock information sent to user', [
            'user_id' => $purchase->user_id,
            'house_id' => $houseUnlock->house_id,
            'phone_number' => $houseUnlock->text_phone_number,
            'caretaker_phone' => $caretakerPhone,
            'location' => $location
        ]);
        return;

    }
}