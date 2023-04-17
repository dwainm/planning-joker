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
        Schema::create('voting_session_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->foreignId('user_id')->constrained('users');
			$table->foreignId('voting_session_id')->constrained('voting_sessions');
			$table->boolean('is_active');
			$table->boolean('is_owner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_session_users');
    }
};
