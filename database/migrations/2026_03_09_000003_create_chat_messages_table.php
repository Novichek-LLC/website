<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id(); $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->string('sender_type'); $table->unsignedBigInteger('sender_id')->nullable(); $table->text('message'); $table->json('attachments')->nullable(); $table->boolean('is_read')->default(false); $table->timestamps();
            $table->index(['conversation_id', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('chat_messages'); }
};
