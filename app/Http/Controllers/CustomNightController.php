<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use Illuminate\Http\Request;

class CustomNightController extends Controller
{
    public function index()
    {
        $session = GameSession::latest()->first();

        // Проверяем, открыта ли 7-я ночь
        if (!$session || $session->max_night < 7) {
            return redirect()->route('menu')->with('error', 'Ночь 7 ещё не открыта!');
        }

        return view('custom-night.index', compact('session'));
    }

    public function start(Request $request)
    {
        // Получаем настройки ИИ из формы
        $aiLevels = [
            'freddy' => (int) $request->freddy,
            'bonnie' => (int) $request->bonnie,
            'chica' => (int) $request->chica,
            'foxy' => (int) $request->foxy
        ];

        // Сохраняем настройки в сессию
        session(['custom_ai_levels' => $aiLevels]);

        // Создаём или обновляем сессию для 7-й ночи
        $session = GameSession::latest()->first();
        if (!$session) {
            $session = GameSession::create([
                'night' => 7,
                'max_night' => 7,
                'completed_night' => 0,
                'high_score' => 0,
                'power_used' => 0,
                'is_completed' => false
            ]);
        } else {
            $session->update([
                'night' => 7,
                'is_completed' => false,
                'power_used' => 0
            ]);
        }

        return view('game', compact('session'));
    }
}
