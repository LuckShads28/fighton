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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_organizer')->references('id')->on('organizers');
            $table->string('name', 100);
            $table->string('slug')->unique();
            $table->text('about');
            $table->text('rules');
            $table->integer('prizepool');
            $table->string('team_category', 3);
            $table->integer('team_slot');
            $table->string('status', 13);
            $table->date('start_date');
            $table->time('start_time');
            $table->string('tournament_type', 45);
            $table->string('banner_pic', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
