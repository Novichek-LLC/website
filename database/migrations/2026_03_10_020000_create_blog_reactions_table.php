<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->string('reaction_key', 30);
            $table->string('visitor_token', 100);
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->unique(['blog_post_id', 'reaction_key', 'visitor_token'], 'blog_reactions_unique');
            $table->index(['blog_post_id', 'reaction_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_reactions');
    }
};