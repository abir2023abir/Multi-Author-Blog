<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Publish scheduled posts whose publish time has arrived';

    public function handle()
    {
        $scheduledPosts = Post::where('status', 'scheduled')
            ->where('published_at', '<=', now())
            ->get();

        if ($scheduledPosts->isEmpty()) {
            $this->info('No posts to publish at this time.');
            return Command::SUCCESS;
        }

        foreach ($scheduledPosts as $post) {
            $post->update(['status' => 'published']);
            $this->info("Published: {$post->title}");
        }

        $this->info("\n✅ {$scheduledPosts->count()} post(s) published successfully!");
        return Command::SUCCESS;
    }
}
