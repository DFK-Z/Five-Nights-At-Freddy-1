<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $session = GameSession::latest()->first();

        if (!$session) {
            $session = GameSession::create([
                'night' => 1,
                'max_night' => 1,
                'completed_night' => 0,
                'high_score' => 0,
                'power_used' => 0,
                'is_completed' => false
            ]);
        }

        return view('menu', compact('session'));
    }

    public function startNight(Int $night, Request $request)
{
    $session = GameSession::latest()->first();

    if ($night > $session->max_night) {
        return redirect()->route('menu')->with('error', 'Эта ночь ещё не открыта!');
    }

    $difficulty = $request->query('difficulty', $session->difficulty ?? 'normal');

    $session->update([
        'night' => $night,
        'is_completed' => false,
        'power_used' => 0,
        'difficulty' => $difficulty
    ]);

    if ($night == 7) {
        session()->forget('custom_ai_levels');
    }

    return view('game', compact('session'));
}

    public function completeNight(Request $request)
{
    $session = GameSession::latest()->first();

    if (!$session) {
        return response()->json(['error' => 'Сессия не найдена'], 404);
    }

    $night = $session->night;
    $stars = 0;

    // Определяем количество звёзд
    if ($night <= 5) {
        $stars = 1; // 1 звезда за ночи 1-5
    } elseif ($night == 6) {
        $stars = 2; // 2 звезды за ночь 6
    } elseif ($night == 7) {
        // Для 7-й ночи проверяем, был ли режим 4/20
        $customLevels = session('custom_ai_levels', []);
        $isFourTwenty = (
            ($customLevels['freddy'] ?? 0) == 20 &&
            ($customLevels['bonnie'] ?? 0) == 20 &&
            ($customLevels['chica'] ?? 0) == 20 &&
            ($customLevels['foxy'] ?? 0) == 20
        );

        $stars = $isFourTwenty ? 3 : 2; // 3 звезды за 4/20, 2 за обычную 7-ю
    }

    $session->update([
        'is_completed' => true,
        'power_used' => $request->power_used ?? 0,
        'high_score' => $request->score ?? 0,
        'stars' => $stars // Сохраняем звёзды
    ]);

    $session->unlockNextNight();

    return response()->json([
        'success' => true,
        'max_night' => $session->max_night,
        'next_night' => $session->night + 1,
        'stars' => $stars
    ]);
}

    public function resetProgress()
    {
        GameSession::truncate();

        GameSession::create([
            'night' => 1,
            'max_night' => 1,
            'completed_night' => 0,
            'high_score' => 0,
            'power_used' => 0,
            'is_completed' => false
        ]);

        return redirect()->route('menu')->with('success', 'Прогресс сброшен!');
    }
}
