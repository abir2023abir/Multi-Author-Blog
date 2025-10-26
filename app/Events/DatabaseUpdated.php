<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatabaseUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $entity;
    public $action;
    public $data;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct(string $entity, string $action, array $data, ?int $userId = null)
    {
        $this->entity = $entity; // 'post', 'comment', 'user', 'category', etc.
        $this->action = $action; // 'created', 'updated', 'deleted'
        $this->data = $data;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        $channels = [
            new Channel("database.{$this->entity}"),
            new PrivateChannel('admin.dashboard'),
        ];

        // Add user-specific channel if userId is provided
        if ($this->userId) {
            $channels[] = new PrivateChannel("user.{$this->userId}");
        }

        return $channels;
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'entity' => $this->entity,
            'action' => $this->action,
            'data' => $this->data,
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'database.updated';
    }
}
