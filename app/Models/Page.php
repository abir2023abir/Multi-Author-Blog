<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'is_published',
        'language',
        'location',
        'page_type',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
