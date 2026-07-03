<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Главное меню
    public function index()
    {
        // Получаем последнюю сессию (или создаём новую)
        $session = GameSession::latest()->first();

        if (!$session) {
            $session = GameSession::create([
                'night' => 1,
                'max_night' => 1,
                'high_score' => 0,
                'power_used' => 0,
                'is_completed' => false
            ]);
        }

        return view('menu', compact('session'));
    }

    // Запуск конкретной ночи
    public function startNight($night)
    {
        $session = GameSession::latest()->first();

        // Проверяем, открыта ли эта ночь
        if ($night > $session->max_night) {
            return redirect()->route('menu')->with('error', 'Эта ночь ещё не открыта!');
        }

        // Обновляем текущую ночь
        $session->update([
            'night' => $night,
            'is_completed' => false,
            'power_used' => 0
        ]);

        return view('game', compact('session'));
    }

    // Сброс прогресса
    public function resetProgress()
    {
        GameSession::truncate(); // Удаляем все сессии

        // Создаём новую с нуля
        GameSession::create([
            'night' => 1,
            'max_night' => 1,
            'high_score' => 0,
            'power_used' => 0,
            'is_completed' => false
        ]);

        return redirect()->route('menu')->with('success', 'Прогресс сброшен!');
    }
}
