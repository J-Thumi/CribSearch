<?php

namespace App\Http\Controllers;

use App\Models\NavigationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NavigationController extends Controller
{
    public function show(Request $request, string $token)
    {
        $tokenHash = hash('sha256', $token);

        

        $navigationToken = NavigationToken::with('house')
            ->where('token_hash', $tokenHash)
            ->first();

        if (!$navigationToken) {
            abort(404);
        }

        if (
            $navigationToken->expires_at &&
            $navigationToken->expires_at->isPast()
        ) {
            abort(403, 'This navigation link has expired.');
        }
        
        $navigationToken->update([
            'last_used_at' => now(),
        ]);

        $house = $navigationToken->house;

        return view('navigation.show', [
            'house' => $house,
        ]);
    }


    public function route(Request $request)
    {
        $validated = $request->validate([
            'start_lat' => ['required', 'numeric', 'between:-90,90'],
            'start_lng' => ['required', 'numeric', 'between:-180,180'],
            'end_lat'   => ['required', 'numeric', 'between:-90,90'],
            'end_lng'   => ['required', 'numeric', 'between:-180,180'],
        ]);

        $apiKey = config('services.graphhopper.key');

        if (empty($apiKey)) {
            Log::error('GraphHopper API key is missing.');

            return response()->json([
                'message' => 'Navigation service is not configured.',
            ], 500);
        }

        $startPoint = "{$validated['start_lat']},{$validated['start_lng']}";
        $endPoint   = "{$validated['end_lat']},{$validated['end_lng']}";

        Log::info('Calculating GraphHopper walking route', [
            'start' => $startPoint,
            'end'   => $endPoint,
        ]);

        try {
            $queryParams = http_build_query([
                'profile'        => 'foot',
                'locale'         => 'en',
                'calc_points'    => 'true',
                'points_encoded' => 'false',
                'instructions'   => 'true',
                'key'            => $apiKey,
            ]);

            $url = "https://graphhopper.com/api/1/route?point={$startPoint}&point={$endPoint}&{$queryParams}";

            $response = Http::timeout(15)->get($url);

            if ($response->failed()) {
                Log::error('GraphHopper route request failed', [
                    'status'   => $response->status(),
                    'response' => $response->json(),
                ]);

                return response()->json([
                    'message' => 'Unable to calculate walking route.',
                    'error'   => $response->json(),
                ], $response->status());
            }

            return response()->json($response->json());

        } catch (\Throwable $e) {
            Log::error('GraphHopper exception', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Navigation service is temporarily unavailable.',
            ], 500);
        }
    }
}