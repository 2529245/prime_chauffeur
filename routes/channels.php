<?php

use Illuminate\Support\Facades\Broadcast;

// Register broadcast channels

// Check user channel access
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
