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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('slug')->unique();
            $table->string('description', 50);
            $table->string('logo_img')->default('team-default-pic.jpg');
            $table->string('banner_img')->default('team-default-bg.jpg');
            $table->foreignId('duelist')->nullable()->references('id')->on('users');
            $table->foreignId('initiator')->nullable()->references('id')->on('users');
            $table->foreignId('controller')->nullable()->references('id')->on('users');
            $table->foreignId('sentinel')->nullable()->references('id')->on('users');
            $table->foreignId('player_5')->nullable()->references('id')->on('users');
            $table->foreignId('sub_1')->nullable()->references('id')->on('users');
            $table->foreignId('sub_2')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
