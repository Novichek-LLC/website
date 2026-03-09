<?php

use App\Models\ChatConversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{conversationUuid}', function ($user, string $conversationUuid) {
    return $user && ChatConversation::where('uuid', $conversationUuid)->exists();
});

Broadcast::channel('admin.dashboard', function ($user) {
    return $user !== null;
});
