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

    public function startNight(Int $night)
    {
        $session = GameSession::latest()->first();

        if ($night > $session->max_night) {
            return redirect()->route('menu')->with('error', 'Эта ночь ещё не открыта!');
        }

        $session->update([
            'night' => $night,
            'is_completed' => false,
            'power_used' => 0
        ]);

        return view('game', compact('session'));
    }

    public function completeNight(Request $request)
    {
        $session = GameSession::latest()->first();

        if (!$session) {
            return response()->json(['error' => 'Сессия не найдена'], 404);
        }

        // Отмечаем ночь как пройденную
        $session->update([
            'is_completed' => true,
            'power_used' => $request->power_used ?? 0,
            'high_score' => $request->score ?? 0
        ]);

        // Разблокируем следующую ночь
        $session->unlockNextNight();

        return response()->json([
            'success' => true,
            'max_night' => $session->max_night,
            'next_night' => $session->night + 1
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
