<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'night',
        'max_night',
        'high_score',
        'power_used',
        'is_completed'
    ];

    // Метод для проверки, можно ли открыть следующую ночь
    public function canUnlockNextNight(): bool
    {
        return $this->is_completed && $this->night < 7;
    }
}
