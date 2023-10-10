<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name',
        'code',
        'flag',
        'is_active'
    ];

    function state(): BelongsTo
    {
        return $this->belongsTo(State::class)->with('country');
    }
}
