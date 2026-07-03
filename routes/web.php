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
Route::get('/camera/{name}', function (\Illuminate\Http\Request $request, $name) {
    // ===== ПОЛУЧАЕМ СОСТОЯНИЕ ИГРЫ ИЗ СЕССИИ =====
    $stored = Session::get('animatronics_positions', [
        'freddy' => 'stage',
        'bonnie' => 'stage',
        'chica' => 'stage',
        'foxy' => 'cove'
    ]);

    // ===== КЛИЕНТ (JS) МОЖЕТ ПРИСЛАТЬ АКТУАЛЬНЫЕ ПОЗИЦИИ ЧЕРЕЗ QUERY =====
    // Это чинит разрыв между игровым состоянием в JS и сессией на сервере:
    // раньше сюда никто ничего не писал, и позиции навсегда оставались дефолтными.
    $positions = [
        'freddy' => $request->query('freddy', $stored['freddy']),
        'bonnie' => $request->query('bonnie', $stored['bonnie']),
        'chica'  => $request->query('chica', $stored['chica']),
        'foxy'   => $request->query('foxy', $stored['foxy']),
    ];
    Session::put('animatronics_positions', $positions);

    // ===== СТАДИЯ ФОКСИ (1-4) =====
    // 1 — спит за закрытым занавесом
    // 2 — выглядывает из-за занавеса
    // 3 — готовится бежать (занавес открыт полностью)
    // 4 — бухта пуста, Фокси уже в коридоре (CAM 2A)
    $foxyStage = (int) $request->query('foxy_stage', Session::get('foxy_stage', 1));
    $foxyStage = max(1, min(4, $foxyStage));
    Session::put('foxy_stage', $foxyStage);

    // Бежит ли Фокси к офису прямо сейчас (после того как его спалили на CAM 2A)
    $foxyRunning = $request->query('foxy_running', Session::get('foxy_running', '0')) === '1';
    Session::put('foxy_running', $foxyRunning ? '1' : '0');

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
                'foxy_stage' => $foxyStage,
                'foxy_running' => $foxyRunning,
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
