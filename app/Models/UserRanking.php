<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRanking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'badge_id',
        'total_points',
        'post_points',
        'comment_points',
        'view_points',
        'reaction_points',
        'rank_position',
        'posts_count',
        'comments_count',
        'total_views',
        'total_reactions',
        'average_rating',
        'achievements',
        'last_updated'
    ];

    protected $casts = [
        'achievements' => 'array',
        'average_rating' => 'decimal:2',
        'last_updated' => 'datetime'
    ];

    /**
     * Get the user that owns the ranking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the badge for this ranking
     */
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Calculate total points
     */
    public function calculateTotalPoints(): int
    {
        return $this->post_points +
               $this->comment_points +
               $this->view_points +
               $this->reaction_points;
    }

    /**
     * Update ranking data
     */
    public function updateRanking(): void
    {
        $this->total_points = $this->calculateTotalPoints();
        $this->last_updated = now();
        $this->save();
    }

    /**
     * Get progress to next badge
     */
    public function getProgressToNextBadge(): array
    {
        $currentBadge = $this->badge;
        $nextBadge = $currentBadge?->getNextBadge();

        if (!$nextBadge) {
            return [
                'current_points' => $this->total_points,
                'next_badge_points' => null,
                'progress_percentage' => 100,
                'points_needed' => 0,
                'next_badge' => null
            ];
        }

        $pointsNeeded = $nextBadge->min_points - $this->total_points;
        $progressRange = $nextBadge->min_points - $currentBadge->min_points;
        $progressPoints = $this->total_points - $currentBadge->min_points;

        return [
            'current_points' => $this->total_points,
            'next_badge_points' => $nextBadge->min_points,
            'progress_percentage' => min(100, max(0, ($progressPoints / $progressRange) * 100)),
            'points_needed' => max(0, $pointsNeeded),
            'next_badge' => $nextBadge
        ];
    }

    /**
     * Get ranking statistics
     */
    public function getStats(): array
    {
        return [
            'total_posts' => $this->posts_count,
            'total_views' => $this->total_views,
            'total_comments' => $this->comments_count,
            'total_reactions' => $this->total_reactions,
            'average_rating' => $this->average_rating,
            'rank_position' => $this->rank_position,
            'badge_level' => $this->badge?->level_name,
            'badge_emoji' => $this->badge?->emoji
        ];
    }
}
