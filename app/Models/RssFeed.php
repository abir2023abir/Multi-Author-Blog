<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RssFeed extends Model
{
    protected $fillable = [
        'name',
        'url',
        'language',
        'categories',
        'posts_count',
        'author',
        'auto_update',
        'download_images',
        'last_updated',
    ];

    protected $casts = [
        'categories' => 'array',
        'auto_update' => 'boolean',
        'download_images' => 'boolean',
        'last_updated' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'rss_feed_id');
    }
}
