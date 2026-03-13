<?php

namespace App\Http\Controllers;

use App\Models\TelegramAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TelegramAccountLinkController extends Controller
{
    public function __invoke(Request $request, string $telegramUserId): RedirectResponse
    {
        $user = $request->user();

        $existingByTelegram = TelegramAccount::query()
            ->where('telegram_user_id', $telegramUserId)
            ->first();

        if ($existingByTelegram && $existingByTelegram->user_id && $existingByTelegram->user_id !== $user->id) {
            return redirect('/')
                ->with('error', 'Этот Telegram-аккаунт уже привязан к другому пользователю.');
        }

        $existingByUser = TelegramAccount::query()
            ->where('user_id', $user->id)
            ->first();

        if ($existingByUser && (string) $existingByUser->telegram_user_id !== (string) $telegramUserId) {
            return redirect('/')
                ->with('error', 'К вашему аккаунту уже привязан другой Telegram.');
        }

        $account = $existingByTelegram ?: new TelegramAccount();
        $account->user_id = $user->id;
        $account->telegram_user_id = (int) $telegramUserId;
        $account->telegram_chat_id = (string) $request->query('chat');
        $account->telegram_username = $request->query('username');
        $account->first_name = $request->query('first_name');
        $account->last_name = $request->query('last_name');
        $account->linked_at = now();
        $account->save();

        return redirect('/')
            ->with('status', 'Telegram-аккаунт успешно привязан.');
    }
}