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
        Schema::create('voting_session_issues', function (Blueprint $table) {
            $table->id();
            $table->mediumText('github_issue_id');
            $table->mediumText('github_issue_title')->nullable();
            $table->longText('github_issue_description')->nullable();
            $table->string('github_issue_estimate')->nullable();
			$table->foreignId('voting_session_id')->constrained('voting_sessions');
			$table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_session_issues');
    }
};
