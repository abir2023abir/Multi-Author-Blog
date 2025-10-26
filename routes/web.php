<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostViewController;
use App\Http\Controllers\Writer\PostController as WriterPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PostApprovalController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminAllPostsController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\AuthorRankingController;
use App\Http\Controllers\Admin\AdminBadgeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [\App\Http\Controllers\PostsController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostViewController::class, 'show'])->name('posts.show');
Route::post('/posts/{post}/comments', [\App\Http\Controllers\PostController::class, 'storeComment'])->name('posts.comments.store');
Route::get('/pages/{page}', [\App\Http\Controllers\PageViewController::class, 'show'])->name('pages.show');

// Debug route to check authentication
Route::get('/debug-auth', function() {
    $user = auth()->user();
    if ($user) {
        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'roles' => $user->roles->pluck('name')->toArray()
            ]
        ]);
    }
    return response()->json(['authenticated' => false]);
});

// User Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/writer/dashboard', [\App\Http\Controllers\Writer\DashboardController::class, 'index'])->name('writer.dashboard');

    // User Post Routes
    Route::resource('user/posts', \App\Http\Controllers\User\PostController::class)->names([
        'index' => 'user.posts.index',
        'create' => 'user.posts.create',
        'store' => 'user.posts.store',
        'show' => 'user.posts.show',
        'edit' => 'user.posts.edit',
        'update' => 'user.posts.update',
        'destroy' => 'user.posts.destroy',
    ]);
});
Route::get('/admin/dashboard/stats', [\App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard.stats');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:writer')->prefix('writer')->name('writer.')->group(function () {
        Route::get('posts/create', [WriterPostController::class, 'create'])->name('posts.create');
        Route::get('posts/create-with-format', [WriterPostController::class, 'createWithFormat'])->name('posts.create-with-format');
        Route::resource('posts', WriterPostController::class)->except(['create', 'show']);
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [\App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::get('/dashboard/notifications', [\App\Http\Controllers\Admin\DashboardController::class, 'getNotifications'])->name('dashboard.notifications');
        Route::get('/dashboard/health', [\App\Http\Controllers\Admin\DashboardController::class, 'getSystemHealth'])->name('dashboard.health');
        Route::get('/dashboard/activity', [\App\Http\Controllers\Admin\DashboardController::class, 'getActivityFeed'])->name('dashboard.activity');
        Route::get('/dashboard/recent-activity', [\App\Http\Controllers\Admin\DashboardController::class, 'getRecentActivity'])->name('dashboard.recent-activity');
        Route::post('/dashboard/notifications/mark-read', [\App\Http\Controllers\Admin\DashboardController::class, 'markNotificationAsRead'])->name('dashboard.notifications.mark-read');
        Route::post('/dashboard/cache/clear', [\App\Http\Controllers\Admin\DashboardController::class, 'clearCache'])->name('dashboard.cache.clear');

        // Posts Management
        Route::get('/posts/pending', [PostApprovalController::class, 'index'])->name('posts.pending');
        Route::post('/posts/{post}/approve', [PostApprovalController::class, 'approve'])->name('posts.approve');
        Route::delete('/posts/{post}/reject', [PostApprovalController::class, 'reject'])->name('posts.reject');
        Route::get('posts', [AdminAllPostsController::class, 'index'])->name('posts.index');
        Route::get('posts/add', [AdminAllPostsController::class, 'add'])->name('posts.add');
        Route::get('posts/create', [AdminAllPostsController::class, 'create'])->name('posts.create');
        Route::post('posts', [AdminAllPostsController::class, 'store'])->name('posts.store');
        Route::get('posts/{post}/edit', [AdminAllPostsController::class, 'edit'])->name('posts.edit');
        Route::put('posts/{post}', [AdminAllPostsController::class, 'update'])->name('posts.update');
        Route::delete('posts/{post}', [AdminAllPostsController::class, 'destroy'])->name('posts.destroy');
        Route::post('posts/{post}/toggle-type', [AdminAllPostsController::class, 'toggleType'])->name('posts.toggle-type');

        // Posts Submenu Routes
        Route::get('posts/slider', [AdminAllPostsController::class, 'slider'])->name('posts.slider');
        Route::get('posts/featured', [AdminAllPostsController::class, 'featured'])->name('posts.featured');
        Route::get('posts/breaking', [AdminAllPostsController::class, 'breaking'])->name('posts.breaking');
        Route::get('posts/recommended', [AdminAllPostsController::class, 'recommended'])->name('posts.recommended');
        Route::get('posts/scheduled', [AdminAllPostsController::class, 'scheduled'])->name('posts.scheduled');
        Route::get('posts/drafts', [AdminAllPostsController::class, 'drafts'])->name('posts.drafts');
        Route::get('posts/bulk', [\App\Http\Controllers\Admin\BulkPostController::class, 'index'])->name('posts.bulk');
        Route::post('posts/bulk', [\App\Http\Controllers\Admin\BulkPostController::class, 'store'])->name('posts.bulk.store');
        Route::get('posts/bulk/template', [\App\Http\Controllers\Admin\BulkPostController::class, 'downloadTemplate'])->name('posts.bulk.template');
        Route::get('posts/bulk/example', [\App\Http\Controllers\Admin\BulkPostController::class, 'downloadExample'])->name('posts.bulk.example');
        Route::get('posts/bulk/categories', [\App\Http\Controllers\Admin\BulkPostController::class, 'categoryIds'])->name('posts.bulk.categories');

        // Categories
        Route::resource('categories', AdminCategoryController::class);
        Route::post('/categories/{category}/toggle-status', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::post('/categories/bulk-action', [\App\Http\Controllers\Admin\CategoryController::class, 'bulkAction'])->name('categories.bulk-action');

        // Users Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('/users/{user}/assign-role', [\App\Http\Controllers\Admin\UserController::class, 'assignRole'])->name('users.assign-role');
        Route::post('/users/bulk-action', [\App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulk-action');
        Route::get('/users/stats', [\App\Http\Controllers\Admin\UserController::class, 'getStats'])->name('users.stats');

        // Comments Management
        Route::resource('comments', \App\Http\Controllers\Admin\CommentController::class)->except(['create', 'store', 'edit', 'update']);
        Route::post('/comments/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
        Route::post('/comments/{comment}/reject', [\App\Http\Controllers\Admin\CommentController::class, 'reject'])->name('comments.reject');
        Route::post('/comments/{comment}/spam', [\App\Http\Controllers\Admin\CommentController::class, 'markAsSpam'])->name('comments.spam');
        Route::post('/comments/bulk-action', [\App\Http\Controllers\Admin\CommentController::class, 'bulkAction'])->name('comments.bulk-action');
        Route::get('/comments/stats', [\App\Http\Controllers\Admin\CommentController::class, 'getStats'])->name('comments.stats');
        Route::get('/comments/recent', [\App\Http\Controllers\Admin\CommentController::class, 'getRecentComments'])->name('comments.recent');

        // Media Management
        Route::resource('media', \App\Http\Controllers\Admin\MediaController::class)->except(['create', 'edit']);
        Route::post('/media/bulk-delete', [\App\Http\Controllers\Admin\MediaController::class, 'bulkDelete'])->name('media.bulk-delete');
        Route::get('/media/stats', [\App\Http\Controllers\Admin\MediaController::class, 'getStats'])->name('media.stats');
        Route::get('/media/recent', [\App\Http\Controllers\Admin\MediaController::class, 'getRecentUploads'])->name('media.recent');

        // Settings Management
        Route::resource('settings', \App\Http\Controllers\Admin\SettingsController::class)->only(['index', 'update']);
        Route::post('/settings/{category}', [\App\Http\Controllers\Admin\SettingsController::class, 'updateCategory'])->name('settings.update-category');
        Route::post('/settings/reset/{category}', [\App\Http\Controllers\Admin\SettingsController::class, 'resetToDefault'])->name('settings.reset');
        Route::get('/settings/export', [\App\Http\Controllers\Admin\SettingsController::class, 'export'])->name('settings.export');
        Route::post('/settings/import', [\App\Http\Controllers\Admin\SettingsController::class, 'import'])->name('settings.import');
        Route::get('/settings/{category}/get', [\App\Http\Controllers\Admin\SettingsController::class, 'getSettingsByCategory'])->name('settings.get-category');

        // Notifications Management
        Route::resource('notifications', \App\Http\Controllers\Admin\NotificationController::class)->except(['create', 'store', 'edit', 'update']);
        Route::post('/notifications/{notification}/mark-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::post('/notifications/bulk-action', [\App\Http\Controllers\Admin\NotificationController::class, 'bulkAction'])->name('notifications.bulk-action');
        Route::get('/notifications/stats', [\App\Http\Controllers\Admin\NotificationController::class, 'getStats'])->name('notifications.stats');
        Route::get('/notifications/recent', [\App\Http\Controllers\Admin\NotificationController::class, 'getRecentNotifications'])->name('notifications.recent');
        Route::post('/notifications/create', [\App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
        Route::post('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Users Management
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Comments Management
        Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

        // Navigation
        Route::resource('navigation', \App\Http\Controllers\Admin\NavigationController::class);
        Route::post('navigation/update-order', [\App\Http\Controllers\Admin\NavigationController::class, 'updateOrder'])->name('navigation.update-order');
        Route::post('navigation/update-limit', [\App\Http\Controllers\Admin\NavigationController::class, 'updateLimit'])->name('navigation.update-limit');

        // Themes
        Route::get('themes', [\App\Http\Controllers\Admin\ThemeController::class, 'index'])->name('themes.index');
        Route::post('themes/activate', [\App\Http\Controllers\Admin\ThemeController::class, 'activate'])->name('themes.activate');
        Route::post('themes/settings', [\App\Http\Controllers\Admin\ThemeController::class, 'updateSettings'])->name('themes.settings');
        Route::post('themes/dark-mode', [\App\Http\Controllers\Admin\ThemeController::class, 'toggleDarkMode'])->name('themes.dark-mode');

        // Pages
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

        // RSS Feeds
        Route::get('rss', [\App\Http\Controllers\Admin\RssController::class, 'index'])->name('rss.index');
        Route::post('rss', [\App\Http\Controllers\Admin\RssController::class, 'store'])->name('rss.store');
        Route::put('rss/{rssFeed}', [\App\Http\Controllers\Admin\RssController::class, 'update'])->name('rss.update');
        Route::delete('rss/{rssFeed}', [\App\Http\Controllers\Admin\RssController::class, 'destroy'])->name('rss.destroy');
        Route::post('rss/{rssFeed}/update', [\App\Http\Controllers\Admin\RssController::class, 'updateFeed'])->name('rss.update-feed');

        // Widgets
        Route::resource('widgets', \App\Http\Controllers\Admin\WidgetController::class);
        Route::post('widgets/{widget}/toggle-visibility', [\App\Http\Controllers\Admin\WidgetController::class, 'toggleVisibility'])->name('widgets.toggle-visibility');
        Route::post('widgets/{widget}/duplicate', [\App\Http\Controllers\Admin\WidgetController::class, 'duplicate'])->name('widgets.duplicate');

        // Polls
        Route::resource('polls', \App\Http\Controllers\Admin\PollController::class);
        Route::get('polls/{poll}/results', [\App\Http\Controllers\Admin\PollController::class, 'viewResults'])->name('polls.results');
        Route::post('polls/{poll}/toggle-status', [\App\Http\Controllers\Admin\PollController::class, 'toggleStatus'])->name('polls.toggle-status');
        Route::post('polls/{poll}/duplicate', [\App\Http\Controllers\Admin\PollController::class, 'duplicate'])->name('polls.duplicate');

        // Gallery
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
        Route::post('gallery/upload', [\App\Http\Controllers\Admin\GalleryController::class, 'upload'])->name('gallery.upload');

        // Contact Messages
        Route::get('contact', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact.index');
        Route::delete('contact/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contact.destroy');

        // Newsletter
        Route::resource('newsletter', \App\Http\Controllers\Admin\NewsletterController::class);
        Route::post('newsletter/send', [\App\Http\Controllers\Admin\NewsletterController::class, 'send'])->name('newsletter.send');

        // Rewards
        Route::resource('rewards', \App\Http\Controllers\Admin\RewardController::class);

        // Ad Spaces
        Route::resource('ads', \App\Http\Controllers\Admin\AdController::class);

        // Roles & Permissions
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::post('roles/{role}/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'updatePermissions'])->name('roles.permissions');

        // SEO Tools
        Route::get('seo', [\App\Http\Controllers\Admin\SeoController::class, 'index'])->name('seo.index');
        Route::post('seo', [\App\Http\Controllers\Admin\SeoController::class, 'update'])->name('seo.update');

        // Storage
        Route::get('storage', [\App\Http\Controllers\Admin\StorageController::class, 'index'])->name('storage.index');
        Route::post('storage/clean', [\App\Http\Controllers\Admin\StorageController::class, 'clean'])->name('storage.clean');

        // Cache System
        Route::get('cache', [\App\Http\Controllers\Admin\CacheController::class, 'index'])->name('cache.index');
        Route::post('cache/clear', [\App\Http\Controllers\Admin\CacheController::class, 'clear'])->name('cache.clear');

        // Google News
        Route::get('google-news', [\App\Http\Controllers\Admin\GoogleNewsController::class, 'index'])->name('google-news.index');
        Route::post('google-news/submit', [\App\Http\Controllers\Admin\GoogleNewsController::class, 'submit'])->name('google-news.submit');

        // Preferences
        Route::get('preferences', [\App\Http\Controllers\Admin\PreferenceController::class, 'index'])->name('preferences.index');
        Route::post('preferences', [\App\Http\Controllers\Admin\PreferenceController::class, 'update'])->name('preferences.update');

        // Settings (removed duplicate - using SettingsController above)

        // My Earnings
        Route::get('earnings', [\App\Http\Controllers\Admin\EarningController::class, 'index'])->name('earnings.index');

        // Plugins
        Route::get('plugins', [\App\Http\Controllers\Admin\PluginController::class, 'index'])->name('plugins.index');
        Route::post('plugins/activate', [\App\Http\Controllers\Admin\PluginController::class, 'activate'])->name('plugins.activate');
        Route::post('plugins/deactivate', [\App\Http\Controllers\Admin\PluginController::class, 'deactivate'])->name('plugins.deactivate');
    });

    // Friendly aliases per spec
    Route::get('/posts/create', [WriterPostController::class, 'create'])->middleware('role:writer')->name('posts.create');
    Route::get('/categories', [AdminCategoryController::class, 'index'])->middleware('role:admin')->name('categories.index');
});

// Gamification Routes
Route::prefix('authors')->name('authors.')->group(function () {
    Route::get('/', [AuthorRankingController::class, 'index'])->name('leaderboard');
    Route::get('/{user}', [AuthorRankingController::class, 'show'])->name('profile');
    Route::get('/api/top', [AuthorRankingController::class, 'getTopAuthors'])->name('api.top');
    Route::get('/api/search', [AuthorRankingController::class, 'search'])->name('api.search');
    Route::get('/api/badge-stats', [AuthorRankingController::class, 'getBadgeStats'])->name('api.badge-stats');
});

// Video API Routes
Route::prefix('api/videos')->group(function () {
    Route::get('/featured', [\App\Http\Controllers\Api\VideoController::class, 'getFeatured']);
    Route::get('/', [\App\Http\Controllers\Api\VideoController::class, 'index']);
    Route::get('/categories', [\App\Http\Controllers\Api\VideoController::class, 'getCategories']);
    Route::get('/{video}', [\App\Http\Controllers\Api\VideoController::class, 'show']);
});

// Article API Routes
Route::prefix('api/articles')->group(function () {
    Route::get('/latest', [\App\Http\Controllers\Api\ArticleController::class, 'getLatest']);
});

// Tag and Category API Routes
Route::prefix('api')->group(function () {
    Route::get('/tags/popular', [\App\Http\Controllers\Api\ArticleController::class, 'getPopularTags']);
    Route::get('/categories/popular', [\App\Http\Controllers\Api\ArticleController::class, 'getPopularCategories']);
});

// Admin Badge Management Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('badges', AdminBadgeController::class);
    Route::post('/badges/{badge}/toggle', [AdminBadgeController::class, 'toggle'])->name('badges.toggle');
    Route::post('/badges/assign', [AdminBadgeController::class, 'assignBadge'])->name('badges.assign');
    Route::post('/badges/recalculate', [AdminBadgeController::class, 'recalculate'])->name('badges.recalculate');
    Route::get('/badges/analytics/data', [AdminBadgeController::class, 'analytics'])->name('badges.analytics');

    // Video Management Routes
    Route::resource('videos', \App\Http\Controllers\Admin\VideoController::class);
    Route::post('/videos/{video}/toggle-status', [\App\Http\Controllers\Admin\VideoController::class, 'toggleStatus'])->name('videos.toggle-status');
    Route::post('/videos/{video}/toggle-featured', [\App\Http\Controllers\Admin\VideoController::class, 'toggleFeatured'])->name('videos.toggle-featured');
    Route::post('/videos/update-sort-order', [\App\Http\Controllers\Admin\VideoController::class, 'updateSortOrder'])->name('videos.update-sort-order');

    // Article Section Management Routes
    Route::get('/article-section', [\App\Http\Controllers\Admin\ArticleSectionController::class, 'index'])->name('article-section.index');
    Route::post('/article-section', [\App\Http\Controllers\Admin\ArticleSectionController::class, 'update'])->name('article-section.update');
    Route::post('/article-section/reset', [\App\Http\Controllers\Admin\ArticleSectionController::class, 'reset'])->name('article-section.reset');

    // Additional Admin Routes
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('ads', \App\Http\Controllers\Admin\AdController::class);
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
    Route::resource('newsletters', \App\Http\Controllers\Admin\NewsletterController::class);
    Route::resource('media', \App\Http\Controllers\Admin\MediaController::class);
    Route::resource('plugins', \App\Http\Controllers\Admin\PluginController::class);
    Route::resource('tools', \App\Http\Controllers\Admin\ToolController::class);
    Route::resource('platform-admin', \App\Http\Controllers\Admin\PlatformAdminController::class);

    // Platform Administration Routes
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
    Route::get('/cronjob', [\App\Http\Controllers\Admin\CronjobController::class, 'index'])->name('cronjob.index');
    Route::get('/security', [\App\Http\Controllers\Admin\SecurityController::class, 'index'])->name('security.index');
    Route::get('/cache', [\App\Http\Controllers\Admin\CacheController::class, 'index'])->name('cache.index');
    Route::post('/cache/clear', [\App\Http\Controllers\Admin\CacheController::class, 'clear'])->name('cache.clear');
    Route::get('/cleanup', [\App\Http\Controllers\Admin\CleanupController::class, 'index'])->name('cleanup.index');
    Route::get('/system-info', [\App\Http\Controllers\Admin\SystemInfoController::class, 'index'])->name('system-info.index');
    Route::get('/system-updater', [\App\Http\Controllers\Admin\SystemUpdaterController::class, 'index'])->name('system-updater.index');
});

require __DIR__.'/auth.php';
