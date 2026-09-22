<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TikTokPostService
{
    protected string $baseUrl = 'https://open.tiktokapis.com/v2/';

    /**
     * Step 1: Query Creator Info before publishing
     * https://developers.tiktok.com/docs/en/content-posting-api-reference-query-creator-info
     */
    public function getCreatorInfo(string $accessToken): array
    {
        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . 'post/publish/creator_info/query/');

        if ($response->failed()) {
            throw new Exception('Failed to fetch TikTok creator info: ' . $response->body());
        }

        return $response->json('data');
    }

    /**
     * Direct Post Photo Slideshow (Houses)
     * https://developers.tiktok.com/docs/en/content-posting-api-reference-photo-post
     */
    public function postPhotoSlideshow(
        string $accessToken,
        array $imageUrls,
        string $title,
        string $description,
        string $privacyLevel = 'PUBLIC_TO_EVERYONE'
    ): string {
        $payload = [
            'post_mode' => 'DIRECT_POST',
            'media_type' => 'PHOTO',
            'post_info' => [
                'title' => $title,
                'description' => $description,
                'privacy_level' => $privacyLevel,
                'disable_comment' => false,
            ],
            'source_info' => [
                'source' => 'PULL_FROM_URL',
                'photo_images' => $imageUrls, // Max 35 image URLs from publicly accessible domain
                'photo_cover_index' => 0,
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . 'post/publish/content/init/', $payload);

        if ($response->failed() || $response->json('error.code') !== 'ok') {
            throw new Exception('TikTok Photo Post Failed: ' . $response->json('error.message'));
        }

        return $response->json('data.publish_id');
    }

    /**
     * Direct Post Video by Public URL
     * https://developers.tiktok.com/docs/en/content-posting-api-reference-direct-post
     */
    public function postVideoUrl(
        string $accessToken,
        string $videoUrl,
        string $title,
        string $privacyLevel = 'PUBLIC_TO_EVERYONE'
    ): string {
        $payload = [
            'post_info' => [
                'title' => $title,
                'privacy_level' => $privacyLevel,
                'disable_comment' => false,
                'disable_duet' => false,
                'disable_stitch' => false,
            ],
            'source_info' => [
                'source' => 'PULL_FROM_URL',
                'video_url' => $videoUrl,
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . 'post/publish/video/init/', $payload);

        if ($response->failed() || $response->json('error.code') !== 'ok') {
            throw new Exception('TikTok Video Post Failed: ' . $response->json('error.message'));
        }

        return $response->json('data.publish_id');
    }

    /**
     * Step 3: Fetch Status of the Post
     * https://developers.tiktok.com/docs/en/content-posting-api-reference-get-video-status
     */
    public function getPostStatus(string $accessToken, string $publishId): array
    {
        $response = Http::withToken($accessToken)
            ->post($this->baseUrl . 'post/publish/status/fetch/', [
                'publish_id' => $publishId,
            ]);

        if ($response->failed()) {
            throw new Exception('Failed to fetch publish status: ' . $response->body());
        }

        return $response->json('data');
    }

     /**
     * 1. Exchange Authorization Code for User Access Token
     */
    public function exchangeCodeForToken(string $code): array
    {
        $response = Http::asForm()->post($this->baseUrl . 'oauth/token/', [
            'client_key'    => config('services.tiktok.client_key'),
            'client_secret' => config('services.tiktok.client_secret'),
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => config('services.tiktok.redirect_uri'),
        ]);

        if ($response->failed() || !empty($response->json('error'))) {
            $error = $response->json('error_description') ?? $response->body();
            throw new Exception('Failed to exchange code: ' . $error);
        }

        return $response->json(); 
        // Returns: access_token, expires_in, refresh_token, refresh_expires_in, open_id, scope
    }

    /**
     * 2. Refresh Access Token using Refresh Token
     */
    public function refreshToken(string $refreshToken): array
    {
        $response = Http::asForm()->post($this->baseUrl . 'oauth/token/', [
            'client_key'    => config('services.tiktok.client_key'),
            'client_secret' => config('services.tiktok.client_secret'),
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        if ($response->failed() || !empty($response->json('error'))) {
            $error = $response->json('error_description') ?? $response->body();
            throw new Exception('Failed to refresh token: ' . $error);
        }

        return $response->json();
        // Returns updated: access_token, expires_in, refresh_token, refresh_expires_in
    }

    /**
     * 3. Revoke User Access Token
     */
    public function revokeToken(string $accessToken): bool
    {
        $response = Http::asForm()->post($this->baseUrl . 'oauth/revoke/', [
            'client_key'    => config('services.tiktok.client_key'),
            'client_secret' => config('services.tiktok.client_secret'),
            'token'         => $accessToken,
        ]);

        if ($response->failed() || !empty($response->json('error'))) {
            $error = $response->json('error_description') ?? $response->body();
            throw new Exception('Failed to revoke token: ' . $error);
        }

        return true;
    }

    /**
     * Auto-Get or Refresh Valid User Token
     */
    public function getValidUserToken($user): string
    {
        if (blank($user->tiktok_access_token)) {
            throw new Exception('TikTok account is not connected.');
        }

        // Check if token expires within 5 minutes
        if ($user->tiktok_token_expires_at && now()->addMinutes(5)->greaterThanOrEqualTo($user->tiktok_token_expires_at)) {
            if (blank($user->tiktok_refresh_token)) {
                throw new Exception('TikTok token expired and no refresh token available.');
            }

            // Refresh the token
            $newData = $this->refreshToken($user->tiktok_refresh_token);

            $user->update([
                'tiktok_access_token'     => $newData['access_token'],
                'tiktok_refresh_token'    => $newData['refresh_token'] ?? $user->tiktok_refresh_token,
                'tiktok_token_expires_at' => now()->addSeconds($newData['expires_in']),
            ]);

            return $newData['access_token'];
        }

        return $user->tiktok_access_token;
    }
}