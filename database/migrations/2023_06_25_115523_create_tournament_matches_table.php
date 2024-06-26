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
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->references('id')->on('tournaments')->cascadeOnDelete();
            $table->string('round');
            $table->foreignId('team1_id')->nullable()->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('team2_id')->nullable()->references('id')->on('teams')->cascadeOnDelete();
            $table->integer('team1_score')->default(0);
            $table->integer('team2_score')->default(0);
            $table->datetime('match_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
    }
};
