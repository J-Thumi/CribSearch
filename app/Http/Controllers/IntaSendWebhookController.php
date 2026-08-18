<?php

namespace App\Http\Controllers;

use App\Models\HouseUnlock;
use App\Models\IntaSendInvoice;
use App\Models\Purchase;
use App\Services\UjumbeSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IntaSendWebhookController extends Controller
{
    /**
     * Handle incoming webhook from IntaSend when payment state changes.
     * Route: POST /api/intasend/webhook
     */
    public function handle(Request $request)
    {
        Log::info('IntaSend webhook received', $request->all());

        $clientIp = $request->ip();
        Log::info('Client IP address', ['ip' => $clientIp]);

        $payload = $request->all();

        // IntaSend provides tracking_id / invoice_id / challenge parameters
        $trackingId = $payload['invoice_id'] ?? $payload['tracking_id'] ?? null;
        $state      = strtoupper($payload['state'] ?? $payload['status'] ?? '');
        $mpesaRef   = $payload['mpesa_reference'] ?? $payload['provider_ref'] ?? null;
        $value      = $payload['value'] ?? $payload['amount'] ?? 0;

        if (!$trackingId) {
            Log::error('IntaSend Webhook missing tracking ID', ['payload' => $payload]);
            return response()->json(['error' => 'Missing tracking_id / invoice_id'], 400);
        }

        // Find invoice by tracking_id
        $invoice = IntaSendInvoice::where('tracking_id', $trackingId)->first();

        if (!$invoice) {
            Log::warning('IntaSend Invoice not found for webhook', [
                'tracking_id' => $trackingId,
                'searching_in' => 'intasend_invoices table'
            ]);
            return response()->json(['status' => 'invoice_not_found', 'tracking_id' => $trackingId]);
        }

        Log::info('Found IntaSend invoice', [
            'invoice_id'     => $invoice->id,
            'current_status' => $invoice->status,
            'expected_amt'   => $invoice->amount,
            'received_amt'   => $value,
            'incoming_state' => $state
        ]);

        // Check if already processed
        if ($invoice->isPaid()) {
            Log::info('IntaSend Invoice already marked as paid', ['invoice_id' => $invoice->id]);
            return response()->json(['status' => 'already_processed', 'invoice_id' => $invoice->id]);
        }

        // Check if payment was successful
        if ($state !== 'COMPLETE' && $state !== 'SUCCESS') {
            Log::info('IntaSend payment status non-successful', ['state' => $state, 'invoice_id' => $invoice->id]);
            $invoice->update(['status' => $state]);
            return response()->json(['status' => 'state_updated', 'state' => $state]);
        }

        // Validate paid amount against stored invoice amount
        if (abs((float)$invoice->amount - (float)$value) > 1.0) {
            Log::warning('IntaSend payment amount mismatch', [
                'expected'   => $invoice->amount,
                'received'   => $value,
                'invoice_id' => $invoice->id
            ]);
        }

        // Mark invoice as COMPLETE
        $invoice->update([
            'status'          => 'COMPLETE',
            'mpesa_reference' => $mpesaRef,
            'paid_at'         => now(),
            'client_ip'       => $clientIp,
        ]);

        Log::info('IntaSend Invoice marked as paid', ['invoice_id' => $invoice->id]);

        

       $house = $invoice->houseUnlock?->house;
        if (!$house) {
            Log::error('House details not found for the associated HouseUnlock', [
                'house_unlock_id' => $invoice->house_unlock_id,
                'invoice_id'      => $invoice->id
            ]); 

            return response()->json([
                'status'        => 'error',
                'message'       => 'House details not found',
                'invoice_id'    => $invoice->id
            ]);
        }

        $this->sendHouseInfo($invoice->houseUnlock);

        return response()->json([
            'status'        => 'success',
            'invoice_id'    => $invoice->id,
            'user_notified' => true
        ]);
    }

    public function sendHouseInfo(HouseUnlock $houseUnlock)
    {
        $ujumbe = new UjumbeSMS();

        $house = $houseUnlock->house;

        if (!$house) {
            Log::error('Associated house details missing for unlock record', [
                'house_unlock_id' => $houseUnlock->id,
                'house_id'        => $houseUnlock->house_id
            ]);
            return;
        }

        $caretakerPhone = $house?->caretaker_phone;
        $lat            = $house?->lat;
        $long           = $house?->long;
        $location       = "https://www.google.com/maps?q={$lat},{$long}";
        $scoutPhone     = $house?->contact_number;

        if (!$caretakerPhone || !$lat || !$long) {
            Log::error('Caretaker phone or location missing for house', [
                'house_id'        => $houseUnlock->house_id,
                'caretaker_phone' => $caretakerPhone,
                'location'        => $location
            ]);

            $ujumbe->send($houseUnlock->text_phone_number, "Your house is now unlocked. However, caretaker phone number or location is missing. Please contact support for assistance. Scout Phone: $scoutPhone");
            return;
        }

        $phoneVal = is_array($caretakerPhone) ? ($caretakerPhone[0]['phone'] ?? '') : $caretakerPhone;
        $message  = "Caretaker: {$phoneVal}, Location: {$location}. If you want to be taken to the house, call scout at {$scoutPhone}.";

        $ujumbe->send($houseUnlock->text_phone_number, $message);

            Log::info('House unlock information sent to user via SMS', [
                'user_id'         => $houseUnlock->user_id,
            'house_id'        => $houseUnlock->house_id,
            'phone_number'    => $houseUnlock->text_phone_number,
            'caretaker_phone' => $caretakerPhone,
            'location'        => $location
        ]);
    }
}