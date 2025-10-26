<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = [
        'name', 
        'title', 
        'language', 
        'type', 
        'content', 
        'position', 
        'where_to_display', 
        'order', 
        'is_active', 
        'visibility', 
        'date_added'
    ];

    protected $casts = [
        'is_active' => 'boolean', 
        'visibility' => 'boolean',
        'content' => 'array',
        'date_added' => 'datetime'
    ];
}
