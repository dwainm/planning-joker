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
        Schema::table('voting_session_issues', function (Blueprint $table) {
            $table->string('github_url')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('creator')->default(1)->constrained('users');
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
