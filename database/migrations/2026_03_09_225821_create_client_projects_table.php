<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_projects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_company_id')
                ->constrained('client_companies')
                ->cascadeOnDelete();

            $table->foreignId('manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('service_type')->nullable();
            $table->string('status')->default('new');
            $table->string('priority')->default('medium');

            $table->text('description')->nullable();

            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();

            $table->decimal('budget', 12, 2)->nullable();
            $table->string('currency', 10)->default('RUB');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_projects');
    }
};