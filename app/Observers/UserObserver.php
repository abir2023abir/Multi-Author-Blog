<?php

namespace App\Observers;

use App\Events\DatabaseUpdated;
use App\Models\User;
use Carbon\Carbon;

class UserObserver
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
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        broadcast(new DatabaseUpdated('user', 'created', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'user',
            'created_at' => $this->toISOString($user->created_at),
        ]))->toOthers();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        broadcast(new DatabaseUpdated('user', 'updated', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'user',
            'updated_at' => $this->toISOString($user->updated_at),
        ]))->toOthers();
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        broadcast(new DatabaseUpdated('user', 'deleted', [
            'id' => $user->id,
            'name' => $user->name,
        ]))->toOthers();
    }
}
