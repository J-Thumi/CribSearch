<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class House extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'scout_id',
        'name',
        'contact_number',
        'lat',
        'long',
        'units',
        'nearest_gate',
        'estimated_time_to_school',
        'approximate_area',
        'caretaker_name',
        'caretaker_phone',
        'status',
        'Amenities'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'units' => 'array', // This is crucial for your Repeater field!
        'lat' => 'float',
        'long' => 'float',
        'Amenities' => 'array',
    ];

    public function scout(): BelongsTo
    {
        // We specify 'scout_id' because it differs from the default 'user_id'
        return $this->belongsTo(User::class, 'scout_id');
    }

    /**
     * Get the lowest price from the units repeater.
     */
    public function getStartingPriceAttribute()
    {
        if (!$this->units || count($this->units) === 0) {
            return 0;
        }

        return collect($this->units)->min('price');
    }

    /**
     * Get the first image of the property to use as a cover.
     */
    public function getCoverImageAttribute()
    {
        if ($this->units && isset($this->units[0]['images'][0])) {
            return asset('storage/' . $this->units[0]['images'][0]);
        }

        return 'https://via.placeholder.com/600x400?text=No+Image+Available';
    }
}