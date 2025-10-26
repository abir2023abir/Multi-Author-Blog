<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\User;
use App\Services\BadgeCalculationService;
use Illuminate\Support\Facades\DB;

class AdminBadgeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeCalculationService $badgeService)
    {
        $this->badgeService = $badgeService;
        $this->middleware('role:admin');
    }

    /**
     * Display badge management dashboard
     */
    public function index()
    {
        $badges = Badge::withCount('users')->orderBy('level')->get();
        $badgeStats = $this->badgeService->getBadgeStatistics();
        $totalUsers = User::count();
        $topAuthors = $this->badgeService->getTopAuthors(10);

        return view('admin.badges.index', compact('badges', 'badgeStats', 'totalUsers', 'topAuthors'));
    }

    /**
     * Show the form for creating a new badge
     */
    public function create()
    {
        return view('admin.badges.create');
    }

    /**
     * Store a newly created badge
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:badges',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'color' => 'required|string|max:7',
            'min_points' => 'required|integer|min:0',
            'max_points' => 'nullable|integer|gt:min_points',
            'level' => 'required|integer|min:1|max:4',
        ]);

        Badge::create($request->all());

        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge created successfully!');
    }

    /**
     * Show the form for editing a badge
     */
    public function edit(Badge $badge)
    {
        return view('admin.badges.edit', compact('badge'));
    }

    /**
     * Update the specified badge
     */
    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:badges,slug,' . $badge->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'color' => 'required|string|max:7',
            'min_points' => 'required|integer|min:0',
            'max_points' => 'nullable|integer|gt:min_points',
            'level' => 'required|integer|min:1|max:4',
        ]);

        $badge->update($request->all());

        // Recalculate all badges if point thresholds changed
        if ($request->has('min_points') || $request->has('max_points')) {
            $this->badgeService->recalculateAllBadges();
        }

        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge updated successfully!');
    }

    /**
     * Remove the specified badge
     */
    public function destroy(Badge $badge)
    {
        if ($badge->users()->count() > 0) {
            return redirect()->route('admin.badges.index')
                ->with('error', 'Cannot delete badge that is assigned to users!');
        }

        $badge->delete();

        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge deleted successfully!');
    }

    /**
     * Toggle badge active status
     */
    public function toggle(Badge $badge)
    {
        $badge->update(['is_active' => !$badge->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $badge->is_active
        ]);
    }

    /**
     * Manually assign badge to user
     */
    public function assignBadge(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'badge_id' => 'required|exists:badges,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $badge = Badge::findOrFail($request->badge_id);

        $user->update(['badge_id' => $badge->id]);
        $this->badgeService->updateUserBadge($user);

        return response()->json([
            'success' => true,
            'message' => "Badge {$badge->name} assigned to {$user->name}"
        ]);
    }

    /**
     * Recalculate all badges
     */
    public function recalculate()
    {
        $this->badgeService->recalculateAllBadges();

        return response()->json([
            'success' => true,
            'message' => 'All badges and rankings have been recalculated!'
        ]);
    }

    /**
     * Get badge analytics data
     */
    public function analytics()
    {
        $badgeDistribution = Badge::withCount('users')
            ->orderBy('level')
            ->get()
            ->map(function ($badge) {
                return [
                    'name' => $badge->name,
                    'users_count' => $badge->users_count,
                    'color' => $badge->color,
                    'icon' => $badge->icon
                ];
            });

        $pointsDistribution = User::select(
            DB::raw('CASE 
                WHEN total_points BETWEEN 0 AND 500 THEN "0-500"
                WHEN total_points BETWEEN 501 AND 1500 THEN "501-1500"
                WHEN total_points BETWEEN 1501 AND 4000 THEN "1501-4000"
                WHEN total_points > 4000 THEN "4000+"
                ELSE "Unknown"
            END as points_range'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('points_range')
        ->orderBy('points_range')
        ->get();

        return response()->json([
            'badge_distribution' => $badgeDistribution,
            'points_distribution' => $pointsDistribution
        ]);
    }
}