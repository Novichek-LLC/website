<?php

namespace App\Http\Controllers;

use App\Models\TelegramLoginToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TelegramAutoLoginController extends Controller
{
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $hash = hash('sha256', $token);

        $record = TelegramLoginToken::query()
            ->where('token_hash', $hash)
            ->first();

        if (! $record || ! $record->isUsable()) {
            return redirect('/login')->with('error', 'Ссылка недействительна или устарела.');
        }

        DB::transaction(function () use ($record, $request) {
            $record->forceFill([
                'used_at' => now(),
            ])->save();

            Auth::loginUsingId($record->user_id, remember: true);

            $request->session()->regenerate();
        });

        return redirect('/account');
    }
}