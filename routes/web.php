<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

// ========== МАРШРУТЫ МЕНЮ ==========
Route::get('/', [MenuController::class, 'index'])->name('menu');
Route::get('/night/{night}', [MenuController::class, 'startNight'])->name('night.start');
Route::post('/reset', [MenuController::class, 'resetProgress'])->name('reset.progress');

// ========== МАРШРУТЫ КАМЕР ==========
Route::get('/camera/{name}', function ($name) {
    // ===== ПОЛУЧАЕМ СОСТОЯНИЕ ИГРЫ ИЗ СЕССИИ =====
    // Временно используем заглушки, пока не настроили сохранение состояния
    $positions = Session::get('animatronics_positions', [
        'freddy' => 'stage',
        'bonnie' => 'backstage',
        'chica' => 'stage',
        'foxy' => 'cove'
    ]);

    // Состояние света (получаем из сессии)
    $light_left = Session::get('light_left', false);
    $light_right = Session::get('light_right', false);

    // ===== СПИСОК ВСЕХ 11 КАМЕР =====
    $validCameras = [
        'cam_1a', 'cam_1b', 'cam_1c',
        'cam_2a', 'cam_2b', 'cam_3',
        'cam_4a', 'cam_4b', 'cam_5',
        'cam_6', 'cam_7'
    ];

    // ===== ПРОВЕРЯЕМ, СУЩЕСТВУЕТ ЛИ КАМЕРА =====
    if (in_array($name, $validCameras)) {
        $view = "cameras.{$name}";

        if (View::exists($view)) {
            return view($view, [
                'freddy_position' => $positions['freddy'],
                'bonnie_position' => $positions['bonnie'],
                'chica_position' => $positions['chica'],
                'foxy_position' => $positions['foxy'],
                'light_left' => $light_left,
                'light_right' => $light_right,
                // Добавляем дополнительную информацию для камер
                'current_night' => Session::get('current_night', 1),
                'power' => Session::get('power', 100)
            ]);
        }
    }

    // ===== ЕСЛИ КАМЕРА НЕ НАЙДЕНА — ПОКАЗЫВАЕМ ЗАГЛУШКУ =====
    return view('cameras._default', ['name' => $name]);
})->name('camera');
