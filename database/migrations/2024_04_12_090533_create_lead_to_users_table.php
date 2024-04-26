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
        Schema::create('lead_to_users', function (Blueprint $table) {
            $table->foreignId('supervisor_id')->constrained('organization_users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('organization_users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_to_users');
    }
};
