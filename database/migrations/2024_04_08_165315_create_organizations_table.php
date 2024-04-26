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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->unsignedInteger('logo')->nullable();
            $table->unsignedInteger('background_image')->nullable();
            $table->json('weekend')->nullable();
            $table->string('work_time')->comment('Including breaks.');
            $table->string('break_time')->comment('Total break time.');
            $table->unsignedInteger('default_department_id')->nullable();
            $table->unsignedInteger('default_project_id')->nullable();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
