<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseUnlock extends Model
{
    protected $table = 'house_unlock';

    protected $fillable = [
        'phone_number',
        'text_phone_number',
        'house_id',
        'user_id',
        'navigation_url',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
