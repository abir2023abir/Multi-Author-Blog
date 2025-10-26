<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'badge_id',
        'total_points',
        'rank_position',
        'achievements',
        'last_activity',
        'is_verified',
        'bio',
        'website',
        'social_links',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'achievements' => 'array',
            'social_links' => 'array',
            'last_activity' => 'datetime',
            'is_verified' => 'boolean',
            'total_points' => 'integer',
            'rank_position' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's badge
     */
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Get the user's ranking
     */
    public function ranking()
    {
        return $this->hasOne(UserRanking::class);
    }

    /**
     * Get the user's reactions
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    /**
     * Get the user's comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Calculate user's total points
     */
    public function calculateTotalPoints(): int
    {
        $postPoints = $this->posts()->count() * 10;
        $commentPoints = $this->comments()->count() * 2;
        $viewPoints = $this->posts()->sum('view_count') / 50; // 1 point per 50 views
        $reactionPoints = $this->posts()->withCount('reactions')->get()->sum('reactions_count') * 5;

        return $postPoints + $commentPoints + $viewPoints + $reactionPoints;
    }

    /**
     * Update user's badge based on points
     */
    public function updateBadge(): void
    {
        $points = $this->calculateTotalPoints();
        $badge = Badge::getBadgeByPoints($points);

        if ($badge && $this->badge_id !== $badge->id) {
            $this->update([
                'badge_id' => $badge->id,
                'total_points' => $points
            ]);

            // Update or create ranking
            $this->ranking()->updateOrCreate(
                ['user_id' => $this->id],
                [
                    'badge_id' => $badge->id,
                    'total_points' => $points,
                    'post_points' => $this->posts()->count() * 10,
                    'comment_points' => $this->comments()->count() * 2,
                    'view_points' => $this->posts()->sum('view_count') / 50,
                    'reaction_points' => $this->posts()->withCount('reactions')->get()->sum('reactions_count') * 5,
                    'posts_count' => $this->posts()->count(),
                    'comments_count' => $this->comments()->count(),
                    'total_views' => $this->posts()->sum('view_count'),
                    'total_reactions' => $this->posts()->withCount('reactions')->get()->sum('reactions_count'),
                    'last_updated' => now()
                ]
            );
        }
    }

    /**
     * Get user's current badge level
     */
    public function getBadgeLevelAttribute(): string
    {
        return $this->badge?->level_name ?? 'No Badge';
    }

    /**
     * Get user's badge emoji
     */
    public function getBadgeEmojiAttribute(): string
    {
        return $this->badge?->emoji ?? '🏆';
    }
}
