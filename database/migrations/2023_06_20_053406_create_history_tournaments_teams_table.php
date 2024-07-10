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
            $table->foreignId('duelist')->nullable()->references('id')->on('users');
            $table->foreignId('initiator')->nullable()->references('id')->on('users');
            $table->foreignId('controller')->nullable()->references('id')->on('users');
            $table->foreignId('sentinel')->nullable()->references('id')->on('users');
            $table->foreignId('player_5')->nullable()->references('id')->on('users');
            $table->foreignId('sub_1')->nullable()->references('id')->on('users');
            $table->foreignId('sub_2')->nullable()->references('id')->on('users');
            $table->integer('rank')->default(0);
            $table->timestamps();
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
