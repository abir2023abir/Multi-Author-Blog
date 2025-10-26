<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Public channels - anyone can listen
Broadcast::channel('posts', function () {
    return true;
});

Broadcast::channel('notifications', function () {
    return true;
});

// Admin channels - only admins
Broadcast::channel('admin.dashboard', function ($user) {
    return $user->role === 'admin' || $user->hasRole('admin');
});

Broadcast::channel('admin.posts', function ($user) {
    return $user->role === 'admin' || $user->hasRole('admin');
});

Broadcast::channel('admin.users', function ($user) {
    return $user->role === 'admin' || $user->hasRole('admin');
});

Broadcast::channel('admin.comments', function ($user) {
    return $user->role === 'admin' || $user->hasRole('admin');
});

Broadcast::channel('admin.stats', function ($user) {
    return $user->role === 'admin' || $user->hasRole('admin');
});

// Writer channels
Broadcast::channel('writer.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId && ($user->role === 'writer' || $user->hasRole('writer'));
});

Broadcast::channel('writer.dashboard', function ($user) {
    return $user->role === 'writer' || $user->hasRole('writer');
});

Broadcast::channel('writer.posts', function ($user) {
    return $user->role === 'writer' || $user->hasRole('writer');
});

// User channels
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('user.notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Presence channels - shows who's online
Broadcast::channel('online', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'role' => $user->role ?? 'user',
    ];
});

Broadcast::channel('post.{postId}', function ($user, $postId) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});
