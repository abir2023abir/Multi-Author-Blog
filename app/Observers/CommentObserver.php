<?php

namespace App\Observers;

use App\Events\CommentCreated;
use App\Events\DatabaseUpdated;
use App\Models\Comment;
use Carbon\Carbon;

class CommentObserver
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
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        // Broadcast specific comment event
        broadcast(new CommentCreated($comment))->toOthers();

        // Broadcast general database update
        broadcast(new DatabaseUpdated('comment', 'created', [
            'id' => $comment->id,
            'content' => substr($comment->content, 0, 100),
            'post_id' => $comment->post_id,
            'post_title' => $comment->post->title ?? 'Unknown',
            'user_id' => $comment->user_id,
            'user_name' => $comment->user->name ?? 'Guest',
            'created_at' => $this->toISOString($comment->created_at),
        ]))->toOthers();
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        broadcast(new DatabaseUpdated('comment', 'updated', [
            'id' => $comment->id,
            'content' => substr($comment->content, 0, 100),
            'post_id' => $comment->post_id,
            'status' => $comment->status ?? 'approved',
            'updated_at' => $this->toISOString($comment->updated_at),
        ]))->toOthers();
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        broadcast(new DatabaseUpdated('comment', 'deleted', [
            'id' => $comment->id,
            'post_id' => $comment->post_id,
        ]))->toOthers();
    }
}
