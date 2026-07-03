<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [MenuController::class, 'index'])->name('menu');
Route::get('/night/{night}', [MenuController::class, 'startNight'])->name('night.start');
Route::post('/reset', [MenuController::class, 'resetProgress'])->name('reset.progress');
