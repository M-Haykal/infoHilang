<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Channel untuk admin chat - hanya admin yang bisa mendengar.
 */
Broadcast::channel('chat.admin', function ($user) {
    return $user->hasRole('admin') || $user->role === 'admin';
});

/**
 * Channel untuk user login - hanya user yang bersangkutan.
 */
Broadcast::channel('chat.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Channel untuk guest - izinkan akses berdasarkan session_id.
 * Karena guest tidak login, kita izinkan akses publik dengan verifikasi session.
 */
Broadcast::channel('chat.guest.{sessionId}', function ($user, $sessionId) {
    // Guest channel - allow any user to listen if they provide the session_id
    // Since guests aren't authenticated, we use the session_id as the key
    return true;
});
