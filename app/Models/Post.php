<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
        'category_id',
        'post_format',
        'meta_description',
        'featured_image',
        'gallery_images',
        'is_slider',
        'is_featured',
        'is_breaking',
        'is_recommended',
        'published_at',
        'view_count',
        'views',
        'tags',
        'slug',
        'excerpt',
        'reading_time',
        'layout',
        'allow_comments',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
        'gallery_images' => 'array',
        'allow_comments' => 'boolean',
        'is_featured' => 'boolean',
        'is_slider' => 'boolean',
        'is_breaking' => 'boolean',
        'is_recommended' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        // Clear cache when post is created, updated, or deleted
        static::created(function () {
            self::clearCache();
        });

        static::updated(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }

    public static function clearCache()
    {
        Cache::forget('home_featured_posts');
        Cache::forget('dashboard_stats');
        Cache::forget('popular_categories');
        Cache::forget('all_categories');
        Cache::forget('popular_posts');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the post's reactions
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope for pending posts
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Increment view count
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
