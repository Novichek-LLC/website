<?php

use App\Http\Controllers\Admin\AdminAssetController;
use App\Http\Controllers\Admin\AdminBlogPostController;
use App\Http\Controllers\Admin\AdminCaseStudyController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'app');
Route::view('/{any}', 'app')->where('any', '^(?!api|admin|login|register|forgot-password|reset-password).*$');

Route::prefix('api')->group(function () {
    Route::get('/blog', [BlogController::class, 'index']);
    Route::get('/blog/{slug}', [BlogController::class, 'show']);
    Route::get('/cases', [CaseStudyController::class, 'index']);
    Route::get('/cases/{slug}', [CaseStudyController::class, 'show']);
    Route::post('/leads', [LeadController::class, 'store']);
    Route::post('/chat/start', [ChatController::class, 'start']);
    Route::get('/chat/{conversation:uuid}', [ChatController::class, 'show']);
    Route::post('/chat/{conversation:uuid}/message', [ChatController::class, 'sendMessage']);
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
    Route::patch('/leads/{lead}', [AdminLeadController::class, 'update'])->name('leads.update');
    Route::get('/chat', [AdminChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [AdminChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/message', [AdminChatController::class, 'storeMessage'])->name('chat.message');
    Route::resource('/cases', AdminCaseStudyController::class)->except(['create', 'edit']);
    Route::resource('/blog', AdminBlogPostController::class)->except(['create', 'edit']);
    Route::post('/assets', [AdminAssetController::class, 'store'])->name('assets.store');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
