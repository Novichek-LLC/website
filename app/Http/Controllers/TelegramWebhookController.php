<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramBotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    public function __invoke(Request $request, TelegramBotService $telegram): JsonResponse
    {
        $secret = (string) config('services.telegram.webhook_secret');
        $header = (string) $request->header('X-Telegram-Bot-Api-Secret-Token', '');

        if ($secret !== '' && ! hash_equals($secret, $header)) {
            return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
        }
        $update = $request->all();

        Log::info('telegram.webhook.received', [
            'update_id' => $update['update_id'] ?? null,
            'keys' => array_keys($update),
        ]);

        $telegram->handleUpdate($update);

        return response()->json(['ok' => true]);
    }
}