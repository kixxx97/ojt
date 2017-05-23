<?php

use App\User;
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
Broadcast::channel('chat', function ($user) {
    return Auth::check();
});

Broadcast::channel('chat.{userId}', function ($user, User $userId) {
    return $userId;
});

Broadcast::channel('chatroom.{userId}', function ($user, User $userId) {
    return $userId;
});
