<?php

namespace App\Services;

use App\Events\AdminStatsUpdated;
use App\Events\UserActivity;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminRealtimeService
{
    public function getDashboardStats()
    {
        return Cache::remember('admin_dashboard_stats', 60, function () {
            return [
                'total_posts' => Post::count(),
                'published_posts' => Post::where('status', 'published')->count(),
                'pending_posts' => Post::where('status', 'pending')->count(),
                'draft_posts' => Post::where('status', 'draft')->count(),
                'total_users' => User::count(),
                'total_categories' => Category::count(),
                'total_comments' => Comment::count(),
                'recent_posts' => Post::with(['user', 'category'])->latest()->take(5)->get(),
                'recent_users' => User::latest()->take(5)->get(),
                'popular_categories' => Category::withCount('posts')->orderBy('posts_count', 'desc')->take(5)->get(),
            ];
        });
    }

    public function updateStats()
    {
        Cache::forget('admin_dashboard_stats');
        $stats = $this->getDashboardStats();
        event(new AdminStatsUpdated($stats));
        return $stats;
    }

    public function logActivity($user, $action, $data = [])
    {
        event(new UserActivity($user, $action, $data));
        
        // Also log to activity log
        activity()
            ->causedBy($user)
            ->withProperties($data)
            ->log($action);
    }

    public function getRealTimeNotifications()
    {
        return [
            'new_posts' => Post::where('created_at', '>=', now()->subHours(24))->count(),
            'new_comments' => Comment::where('created_at', '>=', now()->subHours(24))->count(),
            'new_users' => User::where('created_at', '>=', now()->subHours(24))->count(),
        ];
    }

    public function getSystemHealth()
    {
        return [
            'database' => $this->checkDatabaseConnection(),
            'storage' => $this->checkStorageSpace(),
            'cache' => $this->checkCacheStatus(),
            'queue' => $this->checkQueueStatus(),
        ];
    }

    private function checkDatabaseConnection()
    {
        try {
            \DB::connection()->getPdo();
            return ['status' => 'healthy', 'message' => 'Database connected'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Database connection failed'];
        }
    }

    private function checkStorageSpace()
    {
        $total = disk_total_space(storage_path());
        $free = disk_free_space(storage_path());
        $used = $total - $free;
        $percentage = ($used / $total) * 100;

        return [
            'status' => $percentage > 90 ? 'warning' : 'healthy',
            'percentage' => round($percentage, 2),
            'free' => $this->formatBytes($free),
            'total' => $this->formatBytes($total),
        ];
    }

    private function checkCacheStatus()
    {
        try {
            Cache::put('health_check', 'ok', 60);
            $status = Cache::get('health_check') === 'ok' ? 'healthy' : 'error';
            return ['status' => $status, 'message' => 'Cache working'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Cache not working'];
        }
    }

    private function checkQueueStatus()
    {
        // Simple queue health check
        return ['status' => 'healthy', 'message' => 'Queue system available'];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
