<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('posts'),
            new PrivateChannel('admin.posts'),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'post' => [
                'id' => $this->post->id,
                'title' => $this->post->title,
                'content' => $this->post->content,
                'status' => $this->post->status,
                'featured_image' => $this->post->featured_image,
                'view_count' => $this->post->view_count ?? 0,
                'reading_time' => $this->post->reading_time ?? 5,
                'created_at' => $this->post->created_at->toISOString(),
                'user' => [
                    'id' => $this->post->user->id,
                    'name' => $this->post->user->name,
                ],
                'category' => $this->post->category ? [
                    'id' => $this->post->category->id,
                    'name' => $this->post->category->name,
                ] : null,
            ],
            'message' => 'New post published: ' . $this->post->title,
            'type' => 'post_created',
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new-post';
    }
}
