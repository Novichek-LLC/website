<?php
use App\Http\Controllers\Admin\AdminBlogPostController;
use App\Http\Controllers\Admin\AdminCaseController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'app')->name('home');
Route::view('/{any}', 'app')->where('any', '^(?!nova|api|storage|broadcasting).*$');

Route::prefix('api')->group(function () {
    Route::get('/blog', [BlogController::class, 'index']);
    Route::get('/blog/{slug}', [BlogController::class, 'show']);
    Route::get('/cases', [CaseController::class, 'index']);
    Route::get('/cases/{slug}', [CaseController::class, 'show']);
    Route::post('/leads', [LeadController::class, 'store']);
    Route::post('/chat/conversations', [ChatController::class, 'startConversation']);
    Route::get('/chat/conversations/{conversation:uuid}/messages', [ChatController::class, 'messages']);
    Route::post('/chat/conversations/{conversation:uuid}/messages', [ChatController::class, 'sendGuestMessage']);
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn () => view('app'));
    Route::get('/api/leads', [AdminLeadController::class, 'index']);
    Route::patch('/api/leads/{lead}', [AdminLeadController::class, 'update']);
    Route::post('/api/leads/{lead}/comment', [AdminLeadController::class, 'comment']);
    Route::get('/api/chat/conversations', [AdminChatController::class, 'index']);
    Route::get('/api/chat/conversations/{conversation}/messages', [AdminChatController::class, 'messages']);
    Route::post('/api/chat/conversations/{conversation}/messages', [AdminChatController::class, 'sendAdminMessage']);
    Route::patch('/api/chat/conversations/{conversation}', [AdminChatController::class, 'update']);
    Route::apiResource('api/blog-posts', AdminBlogPostController::class);
    Route::post('api/blog-posts/{blogPost}/cover', [AdminBlogPostController::class, 'uploadCover']);
    Route::apiResource('api/cases', AdminCaseController::class);
    Route::post('api/cases/{caseItem}/cover', [AdminCaseController::class, 'uploadCover']);
});
require __DIR__.'/auth.php';
