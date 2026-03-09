<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id(); $table->string('title'); $table->string('slug')->unique(); $table->string('service')->index(); $table->string('client_name')->nullable();
            $table->text('summary')->nullable(); $table->longText('content'); $table->json('result_metrics')->nullable(); $table->string('cover_path')->nullable();
            $table->boolean('is_published')->default(false)->index(); $table->timestamp('published_at')->nullable()->index(); $table->string('seo_title')->nullable(); $table->text('seo_description')->nullable(); $table->string('seo_keywords')->nullable(); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cases'); }
};
