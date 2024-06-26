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
        Schema::create('history_tournaments_users', function (Blueprint $table) {
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_tournament')->references('id')->on('tournaments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_tournaments_users');
    }
};
