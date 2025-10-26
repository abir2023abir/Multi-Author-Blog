<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use App\Observers\PostObserver;
use App\Observers\CommentObserver;
use App\Observers\UserObserver;
use App\Observers\CategoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers for real-time database updates
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);
        User::observe(UserObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
