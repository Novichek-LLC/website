<?php
namespace App\Channels;
use Illuminate\Notifications\Notification; use Illuminate\Support\Facades\Http;
class TelegramChannel { public function send(object $notifiable, Notification $notification): void { if (! method_exists($notification, 'toTelegram')) { return; } $payload = $notification->toTelegram($notifiable); $token = config('services.telegram.bot_token'); $chatId = config('services.telegram.chat_id'); if (! $token || ! $chatId) { return; } Http::post("https://api.telegram.org/bot{$token}/sendMessage", ['chat_id' => $chatId,'text' => $payload['text'],]); } }
