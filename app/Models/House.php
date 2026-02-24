<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'units' => 'array', // This is crucial for your Repeater field!
        'lat' => 'float',
        'long' => 'float',
    ];
}