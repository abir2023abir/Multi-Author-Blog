<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'min_points',
        'max_points',
        'level',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_points' => 'integer',
        'max_points' => 'integer',
        'level' => 'integer'
    ];

    /**
     * Get the users with this badge
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the user rankings for this badge
     */
    public function userRankings(): HasMany
    {
        return $this->hasMany(UserRanking::class);
    }

    /**
     * Get badge by points
     */
    public static function getBadgeByPoints(int $points): ?self
    {
        return static::where('is_active', true)
            ->where('min_points', '<=', $points)
            ->where(function ($query) use ($points) {
                $query->whereNull('max_points')
                    ->orWhere('max_points', '>=', $points);
            })
            ->orderBy('level', 'desc')
            ->first();
    }

    /**
     * Get next badge
     */
    public function getNextBadge(): ?self
    {
        return static::where('is_active', true)
            ->where('level', '>', $this->level)
            ->orderBy('level', 'asc')
            ->first();
    }

    /**
     * Get badge level name
     */
    public function getLevelNameAttribute(): string
    {
        return match($this->level) {
            1 => 'Bronze',
            2 => 'Silver', 
            3 => 'Gold',
            4 => 'Diamond',
            default => 'Unknown'
        };
    }

    /**
     * Get badge emoji
     */
    public function getEmojiAttribute(): string
    {
        return match($this->level) {
            1 => '🥉',
            2 => '🥈',
            3 => '🥇',
            4 => '💎',
            default => '🏆'
        };
    }
}