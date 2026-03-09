<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ChatController;

Route::view('/', 'app');
Route::view('/{any}', 'app')->where('any', '.*');

Route::prefix('api')->group(function () {
    Route::post('/leads', [LeadController::class, 'store']);
    Route::post('/chat/start', [ChatController::class, 'start']);
    Route::get('/chat/{token}', [ChatController::class, 'show']);
    Route::post('/chat/{token}/message', [ChatController::class, 'message']);

    Route::get('/admin/chat/conversations', [ChatController::class, 'index']);
    Route::post('/admin/chat/{conversation}/reply', [ChatController::class, 'reply']);
    Route::post('/admin/chat/{conversation}/status', [ChatController::class, 'status']);
});
