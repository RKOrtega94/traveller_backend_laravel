<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles')->withPivot('is_active')->wherePivot('is_active', true);
    }
}
