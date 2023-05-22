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
        Schema::create('voting_session_votes', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained('users');
			$table->foreignId('session_id')->constrained('voting_sessions');
			$table->foreignId('issue_id')->constrained('voting_session_issues');
            $table->string('estimate')->nullable();
            $table->timestamps();
			$table->unique(['user_id','session_id','issue_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
