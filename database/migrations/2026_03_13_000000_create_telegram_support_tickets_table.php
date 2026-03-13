<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('telegram_support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('telegram_user_id')->index();
            $table->string('telegram_chat_id', 64)->index();
            $table->string('telegram_username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('subject', 255);
            $table->text('message');
            $table->string('status', 32)->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_support_tickets');
    }
};