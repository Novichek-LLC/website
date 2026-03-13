<?php

use App\Http\Controllers\TelegramAccountLinkController;
use App\Http\Controllers\TelegramAutoLoginController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'app')->name('home');

Route::middleware(['auth', 'signed'])->get(
    '/telegram/link/{telegramUserId}',
    TelegramAccountLinkController::class
)->name('telegram.link');

Route::get(
    '/telegram/login/{token}',
    TelegramAutoLoginController::class
)->name('telegram.autologin');

Route::middleware(['auth', 'verified'])->prefix('account')->group(function () {
    Route::view('/', 'app')->name('account.home');
    Route::view('/{any}', 'app')->where('any', '.*');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn () => view('app'));
});

Route::view('/{any}', 'app')
    ->where('any', '^(?!nova|api|storage|broadcasting|account|admin|telegram).*$');

require __DIR__ . '/auth.php';