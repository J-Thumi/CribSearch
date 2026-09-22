<?php
namespace App\Http\Controllers;

use App\Services\TikTokPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class TikTokAuthController extends Controller
{
    /**
     * Redirect the user to TikTok's OAuth Login Page.
     */
    public function redirect()
    {
        $csrfState = Str::random(40);
        session(['tiktok_oauth_state' => $csrfState]);

        $query = http_build_query([
            'client_key'    => config('services.tiktok.client_key'),
            'scope'         => 'user.info.basic,video.list,video.publish,video.upload',
            'response_type' => 'code',
            'redirect_uri'  => config('services.tiktok.redirect_uri'),
            'state'         => $csrfState,
        ]);

        return redirect('https://www.tiktok.com/v2/auth/authorize/?' . $query);
    }

    /**
     * Handle the OAuth callback from TikTok.
     * THIS IS WHERE exchangeCodeForToken IS USED.
     */
    public function callback(Request $request, TikTokPostService $tikTokService)
    {
        // 1. Verify CSRF State
        $savedState = session()->pull('tiktok_oauth_state');
        if (empty($savedState) || $savedState !== $request->query('state')) {
            return redirect()->route('dashboard')->with('error', 'Invalid OAuth state token.');
        }

        // 2. Check for Authorization Code
        $code = $request->query('code');
        if (blank($code)) {
            $error = $request->query('error_description', 'Authorization failed or was denied.');
            return redirect()->route('dashboard')->with('error', $error);
        }

        try {
            // 3. CALL exchangeCodeForToken HERE
            $tokenData = $tikTokService->exchangeCodeForToken($code);

            // 4. Save credentials to the logged-in user record
            $user = auth()->user();
            $user->update([
                'tiktok_open_id'          => $tokenData['open_id'],
                'tiktok_access_token'     => $tokenData['access_token'],
                'tiktok_refresh_token'    => $tokenData['refresh_token'],
                'tiktok_token_expires_at' => now()->addSeconds($tokenData['expires_in']),
            ]);

            return redirect()->route('dashboard')->with('success', 'TikTok account connected successfully!');

        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}