<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Purchase;
use App\Services\BitikaService;
use App\Services\BlinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StkPushController extends Controller
{
    protected BlinkService $blink;
    protected BitikaService $bitika;

    public function __construct(BlinkService $blink, BitikaService $bitika)
    {
        $this->blink = $blink;
        $this->bitika = $bitika;
    }

    public function initiateStkPush(Request $request)
    {
        // 1. Validate the incoming request (Bitika minimum amount is KES 10)
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^(254|\+254|0)?(7|1)\d{8}$/'],
            'amount'       => 'required|numeric|min:10|max:10000',
        ]);


        // 3. Initiate M-Pesa STK Push via Bitika Service
        $bitikaRes = $this->bitika->collect(
            $request->phone_number,
            $request->amount,
            "qwertyuiopasdfghjklzxcvbnm@blink.sv"
        );

        Log::info('Bitika Response: ', ['response' => $bitikaRes]);

        // 4. Return failed response if Bitika request failed
        if (!$bitikaRes['success']) {
            return response()->json([
                'success' => false,
                'message' => $bitikaRes['error'] ?? 'Bitika STK push request failed.',
                'details' => $bitikaRes['details'] ?? null,
            ], $bitikaRes['status'] ?? 500);
        }

        // 5. Success response
        return response()->json([
            'success'        => true,
            'message'        => 'STK Push initiated successfully.',
            'phone_number'   => $request->phone_number,
            'amount'         => $request->amount,
            'bitika_response' => $bitikaRes['data'] ?? $bitikaRes,
        ]);
    }

}