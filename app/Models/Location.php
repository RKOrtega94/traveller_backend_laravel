<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'zip_code',
        'is_active'
    ];

    function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->with('state');
    }
}
