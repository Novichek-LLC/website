<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class TelegramNotifier
{
    public function send(string $message): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');
        if (!$token || !$chatId) return;
        Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", ['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'HTML'])->throw();
    }
}
