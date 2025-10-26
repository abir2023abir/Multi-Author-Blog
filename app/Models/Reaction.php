<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'type'
    ];

    /**
     * Get the user that owns the reaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that was reacted to
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get reaction emoji
     */
    public function getEmojiAttribute(): string
    {
        return match($this->type) {
            'like' => '👍',
            'love' => '❤️',
            'laugh' => '😂',
            'wow' => '😮',
            'sad' => '😢',
            'angry' => '😠',
            default => '👍'
        };
    }

    /**
     * Get reaction color
     */
    public function getColorAttribute(): string
    {
        return match($this->type) {
            'like' => '#3b82f6',
            'love' => '#ef4444',
            'laugh' => '#f59e0b',
            'wow' => '#8b5cf6',
            'sad' => '#6b7280',
            'angry' => '#dc2626',
            default => '#6b7280'
        };
    }
}