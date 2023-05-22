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
		Schema::table( 'voting_sessions', function (Blueprint $table) {
            $table->string('github_project_id')->nullable();
            $table->string('github_estimate_field_id')->nullable(); });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
