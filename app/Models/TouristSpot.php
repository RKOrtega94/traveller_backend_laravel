<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TouristSpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'location_id'
    ];

    function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)->with('city');
    }

    function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    function tourist_types(): BelongsToMany
    {
        return $this->belongsToMany(TouristType::class);
    }
}
