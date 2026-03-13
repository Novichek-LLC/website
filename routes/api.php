<?php

use App\Http\Controllers\Api\ClientDashboardController;
use App\Http\Controllers\Api\ClientProjectController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogReactionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\TelegramWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/telegram/webhook', TelegramWebhookController::class);

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);

Route::get('/cases', [CaseController::class, 'index']);
Route::get('/cases/{slug}', [CaseController::class, 'show']);

Route::get('/blog/{slug}/comments', [BlogCommentController::class, 'index']);
Route::post('/blog/{slug}/comments', [BlogCommentController::class, 'store']);

Route::get('/blog/{slug}/reactions', [BlogReactionController::class, 'index']);
Route::post('/blog/{slug}/reactions/toggle', [BlogReactionController::class, 'toggle']);

Route::get('/knowledge', [KnowledgeController::class, 'index']);
Route::get('/knowledge/categories', [KnowledgeController::class, 'categories']);
Route::get('/knowledge/category/{slug}', [KnowledgeController::class, 'category']);
Route::get('/knowledge/{slug}', [KnowledgeController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware(['auth:sanctum', 'client'])->prefix('account')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index']);
    Route::get('/projects', [ClientProjectController::class, 'index']);
    Route::get('/projects/{project:slug}', [ClientProjectController::class, 'show']);

    Route::get('/profile', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/notifications', function () {
        return response()->json([
            'items' => [],
        ]);
    });

    Route::get('/status', function () {
        return response()->json([
            'services' => [],
            'uptime' => '99.9%',
        ]);
    });
});