<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id(); $table->string('title'); $table->string('slug')->unique(); $table->text('excerpt')->nullable(); $table->longText('content');
            $table->string('cover_path')->nullable(); $table->boolean('is_published')->default(false)->index(); $table->timestamp('published_at')->nullable()->index();
            $table->string('seo_title')->nullable(); $table->text('seo_description')->nullable(); $table->string('seo_keywords')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete(); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('blog_posts'); }
};
