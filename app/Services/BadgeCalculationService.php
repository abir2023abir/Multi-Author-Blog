<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserRanking;
use Illuminate\Support\Facades\DB;

class BadgeCalculationService
{
    /**
     * Recalculate all user badges and rankings
     */
    public function recalculateAllBadges(): void
    {
        $users = User::with(['posts', 'comments', 'reactions'])->get();

        foreach ($users as $user) {
            $this->updateUserBadge($user);
        }

        $this->updateRankings();
    }

    /**
     * Update a specific user's badge
     */
    public function updateUserBadge(User $user): void
    {
        $points = $this->calculateUserPoints($user);
        $badge = Badge::getBadgeByPoints($points);

        if ($badge) {
            $user->update([
                'badge_id' => $badge->id,
                'total_points' => $points
            ]);

            // Update or create ranking
            UserRanking::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'badge_id' => $badge->id,
                    'total_points' => $points,
                    'post_points' => $user->posts()->count() * 10,
                    'comment_points' => $user->comments()->count() * 2,
                    'view_points' => $user->posts()->sum('view_count') / 50,
                    'reaction_points' => $user->posts()->withCount('reactions')->get()->sum('reactions_count') * 5,
                    'posts_count' => $user->posts()->count(),
                    'comments_count' => $user->comments()->count(),
                    'total_views' => $user->posts()->sum('view_count'),
                    'total_reactions' => $user->posts()->withCount('reactions')->get()->sum('reactions_count'),
                    'last_updated' => now()
                ]
            );
        }
    }

    /**
     * Calculate user points based on activities
     */
    public function calculateUserPoints(User $user): int
    {
        $postPoints = $user->posts()->count() * 10;
        $commentPoints = $user->comments()->count() * 2;
        $viewPoints = $user->posts()->sum('view_count') / 50; // 1 point per 50 views
        $reactionPoints = $user->posts()->withCount('reactions')->get()->sum('reactions_count') * 5;

        return $postPoints + $commentPoints + $viewPoints + $reactionPoints;
    }

    /**
     * Update all user rankings
     */
    public function updateRankings(): void
    {
        // Get all users ordered by total points
        $rankings = UserRanking::orderBy('total_points', 'desc')->get();

        foreach ($rankings as $index => $ranking) {
            $ranking->update(['rank_position' => $index + 1]);

            // Also update user's rank position
            $ranking->user->update(['rank_position' => $index + 1]);
        }
    }

    /**
     * Get top authors
     */
    public function getTopAuthors(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return UserRanking::with(['user:id,name,email,bio,avatar_url', 'badge:id,name,icon,level_name'])
            ->orderBy('total_points', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get badge statistics
     */
    public function getBadgeStatistics(): array
    {
        $badges = Badge::withCount('users')->get();

        return $badges->map(function ($badge) {
            return [
                'badge' => $badge,
                'users_count' => $badge->users_count,
                'percentage' => $badge->users_count > 0 ?
                    round(($badge->users_count / User::count()) * 100, 2) : 0
            ];
        })->toArray();
    }

    /**
     * Award points for specific activity
     */
    public function awardPoints(User $user, string $activity, int $points = null): void
    {
        $pointsMap = [
            'post_created' => 10,
            'comment_created' => 2,
            'post_viewed' => 1, // per 50 views
            'reaction_given' => 5,
            'post_featured' => 20,
            'post_breaking' => 15,
        ];

        $pointsToAward = $points ?? $pointsMap[$activity] ?? 0;

        if ($pointsToAward > 0) {
            $user->increment('total_points', $pointsToAward);
            $this->updateUserBadge($user);
        }
    }

    /**
     * Get user's progress to next badge
     */
    public function getUserProgress(User $user): array
    {
        $ranking = $user->ranking;

        if (!$ranking) {
            return [
                'current_points' => 0,
                'next_badge_points' => null,
                'progress_percentage' => 0,
                'points_needed' => 0,
                'current_badge' => null,
                'next_badge' => null
            ];
        }

        $progress = $ranking->getProgressToNextBadge();

        // Ensure next_badge is always set, even if null
        if (!isset($progress['next_badge'])) {
            $progress['next_badge'] = null;
        }

        return $progress;
    }
}
