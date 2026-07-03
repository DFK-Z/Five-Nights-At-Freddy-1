<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('night')->default(1); // Ночь 1-7
            $table->integer('max_night')->default(1); // Максимальная открытая ночь
            $table->integer('high_score')->default(0); // Очки (например, время выживания)
            $table->integer('power_used')->default(0); // Потрачено энергии
            $table->boolean('is_completed')->default(false); // Пройдена ли ночь
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_sessions');
    }
};
