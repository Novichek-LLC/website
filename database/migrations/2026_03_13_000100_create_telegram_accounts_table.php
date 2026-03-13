<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('telegram_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('telegram_user_id')->unique();
            $table->string('telegram_chat_id', 64)->nullable()->index();
            $table->string('telegram_username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamp('linked_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'telegram_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_accounts');
    }
};