<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('blog_posts', 'badge_label')) {
                $table->string('badge_label')->nullable()->after('excerpt');
            }

            if (! Schema::hasColumn('blog_posts', 'visual_theme')) {
                $table->string('visual_theme')->nullable()->after('badge_label');
            }
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'badge_label')) {
                $table->dropColumn('badge_label');
            }

            if (Schema::hasColumn('blog_posts', 'visual_theme')) {
                $table->dropColumn('visual_theme');
            }
        });
    }
};