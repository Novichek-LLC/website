<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id(); $table->string('service')->index(); $table->string('name'); $table->string('company')->nullable();
            $table->string('email')->nullable()->index(); $table->string('phone')->nullable()->index(); $table->string('telegram')->nullable();
            $table->text('message')->nullable(); $table->string('source')->default('site'); $table->string('status')->default('new')->index();
            $table->unsignedBigInteger('budget')->nullable(); $table->string('priority')->default('medium');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); $table->text('last_comment')->nullable(); $table->json('meta')->nullable(); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('leads'); }
};
