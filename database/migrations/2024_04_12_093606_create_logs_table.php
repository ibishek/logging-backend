<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('log');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('written_by')->nullable()->constrained('organization_users')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->cascadeOnDelete();
            $table->boolean('is_approved')->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('organization_users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
