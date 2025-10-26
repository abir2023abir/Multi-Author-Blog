<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'question', 
        'language', 
        'vote_permission', 
        'options', 
        'is_active', 
        'closes_at', 
        'date_added'
    ];

    protected $casts = [
        'options' => 'array', 
        'is_active' => 'boolean', 
        'closes_at' => 'datetime',
        'date_added' => 'datetime'
    ];
}
