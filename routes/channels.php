<?php

Broadcast::channel('npp-user.{username}', function ($user, $username) {
    return $user->username === $username;
});

Broadcast::channel('npp-dream.{slug}', function ($user, $slug) {
    return $user;
});


// Broadcast::channel('npp-dream.{id}', function ($user, $dream_id) {
//     return $user;
// });
