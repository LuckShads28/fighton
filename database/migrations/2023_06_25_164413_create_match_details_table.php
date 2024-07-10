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
        Schema::create('match_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->references('id')->on('tournament_matches')->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->integer('kill')->default(0);
            $table->integer('death')->default(0);
            $table->integer('assist')->default(0);
            $table->integer('acs')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_details');
    }
};
