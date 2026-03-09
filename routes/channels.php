<?php
use Illuminate\Support\Facades\Broadcast;
Broadcast::channel('chat.{uuid}', function ($user = null, string $uuid) { return true; });
Broadcast::channel('admin.chat', function ($user) { return (bool) $user; });
