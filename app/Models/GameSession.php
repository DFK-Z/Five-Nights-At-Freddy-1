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
        'completed_night',
        'high_score',
        'power_used',
        'is_completed',
        'stars'
    ];

    public function unlockNextNight()
    {
        if ($this->night >= 7) return;

        $nextNight = $this->night + 1;
        if ($nextNight > $this->max_night) {
            $this->max_night = $nextNight;
            $this->save();
        }
    }

    public function addStars(Int $newStars)
    {
        if ($newStars > $this->stars) {
            $this->stars = $newStars;
            $this->save();
        }
    }
}
