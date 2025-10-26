<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\RssFeed;
use App\Services\AdminRealtimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $realtimeService;

    public function __construct(AdminRealtimeService $realtimeService)
    {
        $this->realtimeService = $realtimeService;
    }

    public function index()
    {
        $stats = $this->realtimeService->getDashboardStats();
        $notifications = $this->realtimeService->getRealTimeNotifications();
        $systemHealth = $this->realtimeService->getSystemHealth();

        return view('admin.dashboard', compact('stats', 'notifications', 'systemHealth'));
    }

    public function getStats()
    {
        $stats = $this->realtimeService->updateStats();
        return response()->json($stats);
    }

    public function getNotifications()
    {
        $notifications = $this->realtimeService->getRealTimeNotifications();
        return response()->json($notifications);
    }

    public function getSystemHealth()
    {
        $health = $this->realtimeService->getSystemHealth();
        return response()->json($health);
    }

    public function getActivityFeed()
    {
        $activities = \Spatie\Activitylog\Models\Activity::with('causer')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user' => $activity->causer ? [
                        'name' => $activity->causer->name,
                        'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($activity->causer->name)
                    ] : null,
                    'description' => $activity->description,
                    'properties' => $activity->properties,
                    'created_at' => $activity->created_at->diffForHumans(),
                    'timestamp' => $activity->created_at->toISOString(),
                ];
            });

        return response()->json($activities);
    }

    public function markNotificationAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|string'
        ]);

        // Mark notification as read logic
        return response()->json(['status' => 'success']);
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        
        $this->realtimeService->logActivity(
            Auth::user(), 
            'cleared_cache', 
            ['timestamp' => now()]
        );

        return response()->json(['status' => 'success', 'message' => 'Cache cleared successfully']);
    }

    public function getRecentActivity()
    {
        $activities = \Spatie\Activitylog\Models\Activity::with('causer')
            ->where('created_at', '>=', now()->subHours(24))
            ->latest()
            ->take(20)
            ->get();

        return response()->json($activities);
    }
}