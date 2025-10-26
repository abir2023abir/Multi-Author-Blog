<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRanking;
use App\Models\User;
use App\Services\BadgeCalculationService;

class AuthorRankingController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeCalculationService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Display the top authors leaderboard
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search');
        $badgeFilter = $request->get('badge');

        $query = UserRanking::with(['user', 'badge'])
            ->orderBy('total_points', 'desc');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($badgeFilter) {
            $query->where('badge_id', $badgeFilter);
        }

        $rankings = $query->paginate($perPage);
        $badges = \App\Models\Badge::where('is_active', true)->get();

        return view('authors.leaderboard', compact('rankings', 'badges'));
    }

    /**
     * Display a specific author's profile
     */
    public function show(User $user)
    {
        $ranking = $user->ranking;
        $recentPosts = $user->posts()
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        $stats = $ranking ? $ranking->getStats() : [
            'total_posts' => 0,
            'total_views' => 0,
            'total_comments' => 0,
            'total_reactions' => 0,
            'average_rating' => 0,
            'rank_position' => null,
            'badge_level' => 'No Badge',
            'badge_emoji' => '🏆'
        ];

        $progress = $this->badgeService->getUserProgress($user);

        return view('authors.profile', compact('user', 'ranking', 'recentPosts', 'stats', 'progress'));
    }

    /**
     * Get top authors for homepage widget
     */
    public function getTopAuthors(Request $request)
    {
        $limit = $request->get('limit', 10);
        $authors = $this->badgeService->getTopAuthors($limit);

        return response()->json($authors);
    }

    /**
     * Get badge statistics for admin dashboard
     */
    public function getBadgeStats()
    {
        $stats = $this->badgeService->getBadgeStatistics();
        
        return response()->json($stats);
    }

    /**
     * Search authors
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $authors = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->with(['badge', 'ranking'])
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'badge_emoji' => $user->badge_emoji,
                    'badge_level' => $user->badge_level,
                    'total_points' => $user->total_points,
                    'rank_position' => $user->rank_position,
                    'avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name)
                ];
            });

        return response()->json($authors);
    }
}