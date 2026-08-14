<?php

if (! function_exists('isHouseDetailsUnlocked')) {
    /**
     * Determine if house details are unlocked for the current session or user.
     */
    function isHouseDetailsUnlocked(): bool
    {
        // 1. Check if user is logged in and has an active paid status/purchase
        if (auth()->check()) {
            if (auth()->user()->hasUnlockedAllHouses()) {
                return true;
            }
        }

        // 2. Check session status for non-logged-in (guest) users
        if (session()->has('houses_unlocked') && session()->get('houses_unlocked') === true) {
            return true;
        }

        // 3. Optional: Check for an unlock cookie (useful if sessions expire quickly)
        if (request()->hasCookie('houses_unlocked_token')) {
            // Verify token if using encrypted unlock tokens for guests
            return true;
        }

        return false;
    }
}