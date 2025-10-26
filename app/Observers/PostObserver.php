<?php

namespace App\Observers;

use App\Events\DatabaseUpdated;
use App\Events\PostCreated;
use App\Events\PostDeleted;
use App\Events\PostUpdated;
use App\Models\Post;
use Carbon\Carbon;

class PostObserver
{
    /**
     * Safely convert a timestamp to ISO string format
     */
    private function toISOString($timestamp): string
    {
        if ($timestamp instanceof Carbon) {
            return $timestamp->toISOString();
        }
        
        if (is_string($timestamp)) {
            return Carbon::parse($timestamp)->toISOString();
        }
        
        return now()->toISOString();
    }
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        // Broadcast specific post event
        broadcast(new PostCreated($post))->toOthers();

        // Broadcast general database update
        broadcast(new DatabaseUpdated('post', 'created', [
            'id' => $post->id,
            'title' => $post->title,
            'status' => $post->status,
            'user_id' => $post->user_id,
            'user_name' => $post->user->name ?? 'Unknown',
            'category' => $post->category->name ?? 'Uncategorized',
            'created_at' => $this->toISOString($post->created_at),
        ], $post->user_id))->toOthers();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        // Broadcast specific post event
        broadcast(new PostUpdated($post))->toOthers();

        // Broadcast general database update
        broadcast(new DatabaseUpdated('post', 'updated', [
            'id' => $post->id,
            'title' => $post->title,
            'status' => $post->status,
            'user_id' => $post->user_id,
            'user_name' => $post->user->name ?? 'Unknown',
            'category' => $post->category->name ?? 'Uncategorized',
            'updated_at' => $this->toISOString($post->updated_at),
        ], $post->user_id))->toOthers();
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        // Broadcast specific post event
        broadcast(new PostDeleted($post->id, $post->title))->toOthers();

        // Broadcast general database update
        broadcast(new DatabaseUpdated('post', 'deleted', [
            'id' => $post->id,
            'title' => $post->title,
        ], $post->user_id))->toOthers();
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        broadcast(new DatabaseUpdated('post', 'restored', [
            'id' => $post->id,
            'title' => $post->title,
        ], $post->user_id))->toOthers();
    }
}
