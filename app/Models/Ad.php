<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'code',
        'position',
        'width',
        'height',
        'description',
        'is_active',
        'is_responsive'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_responsive' => 'boolean',
        'width' => 'integer',
        'height' => 'integer'
    ];
}
