<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegajoSection extends Model
{
    protected $fillable = [
        'number',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}