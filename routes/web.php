<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

// ========== МАРШРУТЫ МЕНЮ ==========
Route::get('/', [MenuController::class, 'index'])->name('menu');
Route::get('/night/{night}', [MenuController::class, 'startNight'])->name('night.start');
Route::post('/night/complete', [MenuController::class, 'completeNight'])->name('night.complete');
Route::post('/reset', [MenuController::class, 'resetProgress'])->name('reset.progress');

// ========== МАРШРУТЫ КАМЕР ==========
Route::get('/camera/{name}', function (\Illuminate\Http\Request $request, $name) {
    // ===== ПОЛУЧАЕМ ПОЗИЦИИ ИЗ QUERY (ОТ JS) =====
    $freddy_pos = $request->query('freddy_pos', 'stage');
    $bonnie_pos = $request->query('bonnie_pos', 'backstage');
    $chica_pos = $request->query('chica_pos', 'stage');
    $foxy_pos = $request->query('foxy_pos', 'cove');

    // ===== СТАДИЯ ФОКСИ =====
    $foxy_stage = (int) $request->query('foxy_stage', 1);
    $foxy_running = $request->query('foxy_running', '0') === '1';

    // ===== СОСТОЯНИЕ СВЕТА =====
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
                'freddy_position' => $freddy_pos,
                'bonnie_position' => $bonnie_pos,
                'chica_position' => $chica_pos,
                'foxy_position' => $foxy_pos,
                'foxy_stage' => $foxy_stage,
                'foxy_running' => $foxy_running,
                'light_left' => $light_left,
                'light_right' => $light_right,
                'current_night' => Session::get('current_night', 1),
                'power' => Session::get('power', 100)
            ]);
        }
    }

    // ===== ЕСЛИ КАМЕРА НЕ НАЙДЕНА — ПОКАЗЫВАЕМ ЗАГЛУШКУ =====
    return view('cameras._default', ['name' => $name]);
})->name('camera');
