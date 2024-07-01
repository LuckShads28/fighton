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
        Schema::create('history_tournaments_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->foreignId('tournament_id')->references('id')->on('tournaments');
            $table->foreignId('duelist')->references('id')->on('users');
            $table->foreignId('initiator')->references('id')->on('users');
            $table->foreignId('controller')->references('id')->on('users');
            $table->foreignId('name')->references('id')->on('users');
            $table->foreignId('player_5')->references('id')->on('users');
            $table->foreignId('sub_1')->references('id')->on('users');
            $table->foreignId('sub_2')->references('id')->on('users');
            $table->integer('rank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_tournaments_teams');
    }
};