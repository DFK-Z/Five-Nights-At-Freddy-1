<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ночь {{ $session->night }} - Five Nights At Freddy's</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
    <style>
        /* ===== СТИЛИ ДЛЯ СКРИМЕРА ===== */
        .screamer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99999;
            display: none;
            justify-content: center;
            align-items: center;
            cursor: none;
            animation: none;
            overflow: hidden;
        }

        .screamer-overlay.active {
            display: flex;
            animation: screamerFlash 0.08s ease 4;
        }

        .screamer-overlay .screamer-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            z-index: 0;
        }

        .screamer-overlay .screamer-face {
            position: relative;
            z-index: 2;
            font-size: 350px;
            text-align: center;
            user-select: none;
            animation: screamerPulse 0.12s ease 4;
            filter: brightness(0) saturate(100%) invert(1);
            text-shadow: none;
        }

        .screamer-overlay .screamer-face.bonnie {
            filter: none;
            color: #cc44ff;
            text-shadow: 0 0 50px #cc44ff, 0 0 100px #cc44ff, 0 0 200px #cc44ff, 0 0 400px #8800cc;
            animation: screamerPulse 0.12s ease 4, bonnieGlow 0.3s ease 3;
        }
        .screamer-overlay.bonnie-style .screamer-bg {
            background: radial-gradient(ellipse at center, #440066 0%, #000000 70%);
        }
        .screamer-overlay.bonnie-style {
            background: rgba(68, 0, 102, 0.3);
        }

        .screamer-overlay .screamer-face.chica {
            filter: none;
            color: #ffaa00;
            text-shadow: 0 0 50px #ffaa00, 0 0 100px #ffaa00, 0 0 200px #ffaa00, 0 0 400px #cc8800;
            animation: screamerPulse 0.12s ease 4, chicaGlow 0.3s ease 3;
        }
        .screamer-overlay.chica-style .screamer-bg {
            background: radial-gradient(ellipse at center, #664400 0%, #000000 70%);
        }
        .screamer-overlay.chica-style {
            background: rgba(102, 68, 0, 0.3);
        }

        .screamer-overlay .screamer-face.freddy {
            filter: none;
            color: #ff2222;
            text-shadow: 0 0 50px #ff2222, 0 0 100px #ff2222, 0 0 200px #ff2222, 0 0 400px #cc0000;
            animation: screamerPulse 0.12s ease 4, freddyGlow 0.3s ease 3;
        }
        .screamer-overlay.freddy-style .screamer-bg {
            background: radial-gradient(ellipse at center, #660000 0%, #000000 70%);
        }
        .screamer-overlay.freddy-style {
            background: rgba(102, 0, 0, 0.3);
        }

        .screamer-overlay .screamer-face.foxy {
            filter: none;
            color: #ff4400;
            text-shadow: 0 0 50px #ff4400, 0 0 100px #ff4400, 0 0 200px #ff4400, 0 0 400px #cc3300;
            animation: screamerPulse 0.12s ease 4, foxyGlow 0.2s ease 5;
        }
        .screamer-overlay.foxy-style .screamer-bg {
            background: radial-gradient(ellipse at center, #662200 0%, #000000 70%);
        }
        .screamer-overlay.foxy-style {
            background: rgba(102, 34, 0, 0.3);
        }

        @keyframes bonnieGlow {
            0%, 100% { text-shadow: 0 0 50px #cc44ff, 0 0 100px #cc44ff, 0 0 200px #cc44ff; }
            50% { text-shadow: 0 0 80px #ff66ff, 0 0 150px #ff66ff, 0 0 300px #cc44ff, 0 0 500px #8800cc; }
        }
        @keyframes chicaGlow {
            0%, 100% { text-shadow: 0 0 50px #ffaa00, 0 0 100px #ffaa00, 0 0 200px #ffaa00; }
            50% { text-shadow: 0 0 80px #ffcc44, 0 0 150px #ffcc44, 0 0 300px #ffaa00, 0 0 500px #cc8800; }
        }
        @keyframes freddyGlow {
            0%, 100% { text-shadow: 0 0 50px #ff2222, 0 0 100px #ff2222, 0 0 200px #ff2222; }
            50% { text-shadow: 0 0 80px #ff4444, 0 0 150px #ff4444, 0 0 300px #ff2222, 0 0 500px #cc0000; }
        }
        @keyframes foxyGlow {
            0%, 100% { text-shadow: 0 0 50px #ff4400, 0 0 100px #ff4400, 0 0 200px #ff4400; }
            25% { text-shadow: 0 0 80px #ff6600, 0 0 150px #ff6600, 0 0 300px #ff4400, 0 0 500px #cc3300; }
            50% { text-shadow: 0 0 100px #ff8800, 0 0 200px #ff8800, 0 0 400px #ff4400, 0 0 600px #cc3300; }
            75% { text-shadow: 0 0 80px #ff6600, 0 0 150px #ff6600, 0 0 300px #ff4400, 0 0 500px #cc3300; }
        }

        @keyframes screamerFlash {
            0%, 100% { background: rgba(0,0,0,0.95); }
            50% { background: rgba(255,255,255,0.15); }
        }

        @keyframes screamerPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25% { transform: scale(1.08) rotate(-2deg); }
            75% { transform: scale(0.95) rotate(2deg); }
        }

        .screamer-overlay .screamer-static {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.05) 2px, rgba(255,255,255,0.05) 4px);
            pointer-events: none;
            z-index: 1;
            opacity: 0;
            animation: staticNoise 0.03s infinite;
        }

        .screamer-overlay.active .screamer-static {
            opacity: 0.4;
        }

        .screamer-overlay .screamer-scanlines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0,0,0,0.6) 3px, rgba(0,0,0,0.6) 4px);
            pointer-events: none;
            z-index: 1;
            opacity: 0;
        }

        .screamer-overlay.active .screamer-scanlines {
            opacity: 0.5;
            animation: scanlines 0.08s infinite;
        }

        .screamer-overlay .screamer-vignette {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center, transparent 40%, rgba(0,0,0,0.7) 100%);
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }

        @keyframes staticNoise {
            0% { opacity: 0.3; transform: translate(0, 0); }
            25% { opacity: 0.5; transform: translate(-2px, 1px); }
            50% { opacity: 0.4; transform: translate(2px, -1px); }
            75% { opacity: 0.6; transform: translate(-1px, 2px); }
            100% { opacity: 0.3; transform: translate(1px, -2px); }
        }

        @keyframes scanlines {
            0% { transform: translateY(0); }
            100% { transform: translateY(4px); }
        }

        .screamer-overlay .screamer-extra {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.3;
            animation: extraFlicker 0.1s infinite;
        }

        @keyframes extraFlicker {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.5; }
        }

        .screamer-overlay.bonnie-style .screamer-extra {
            background: radial-gradient(ellipse at 30% 40%, rgba(200, 0, 255, 0.1), transparent 60%);
        }
        .screamer-overlay.chica-style .screamer-extra {
            background: radial-gradient(ellipse at 70% 30%, rgba(255, 200, 0, 0.1), transparent 60%);
        }
        .screamer-overlay.freddy-style .screamer-extra {
            background: radial-gradient(ellipse at 50% 50%, rgba(255, 0, 0, 0.15), transparent 60%);
        }
        .screamer-overlay.foxy-style .screamer-extra {
            background: radial-gradient(ellipse at 20% 60%, rgba(255, 100, 0, 0.15), transparent 60%);
        }

        /* ===== GAME OVER ===== */
        .gameover-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.95);
            z-index: 100000;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #ff0000;
            font-family: 'Courier New', monospace;
            text-align: center;
            cursor: default;
        }

        .gameover-overlay.active {
            display: flex;
            animation: gameoverFade 0.5s ease;
        }

        .gameover-overlay .gameover-title {
            font-size: 72px;
            color: #ff0000;
            text-shadow: 0 0 30px #ff0000, 0 0 60px #ff0000, 0 0 120px #ff0000;
            letter-spacing: 10px;
            margin-bottom: 20px;
            animation: gameoverPulse 1.5s ease infinite;
        }

        .gameover-overlay .gameover-subtitle {
            font-size: 28px;
            color: #cc4444;
            margin-bottom: 10px;
        }

        .gameover-overlay .gameover-time {
            font-size: 18px;
            color: #888;
            margin-bottom: 30px;
        }

        .gameover-overlay .gameover-btn {
            padding: 12px 40px;
            font-size: 18px;
            background: transparent;
            color: #ff4444;
            border: 2px solid #ff4444;
            cursor: pointer;
            font-family: 'Courier New', monospace;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .gameover-overlay .gameover-btn:hover {
            background: #ff4444;
            color: #000;
            box-shadow: 0 0 30px rgba(255,68,68,0.3);
        }

        @keyframes gameoverFade {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes gameoverPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ===== ПРЕДУПРЕЖДЕНИЕ ОБ ОПАСНОСТИ ===== */
        .danger-warning {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ff0000;
            font-size: 48px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            text-shadow: 0 0 30px #ff0000, 0 0 60px #ff0000;
            z-index: 99998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            background: rgba(0,0,0,0.8);
            padding: 30px 50px;
            border: 3px solid #ff0000;
            border-radius: 10px;
            text-align: center;
            animation: warningPulse 0.5s ease 3;
        }

        .danger-warning.active {
            opacity: 1;
        }

        @keyframes warningPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.05); }
        }

        /* ===== СЦЕНА ОТКЛЮЧЕНИЯ ЭЛЕКТРИЧЕСТВА ===== */
        .power-outage-scene {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 99998;
            display: none;
            justify-content: center;
            align-items: center;
            background: #0a0a1a;
            overflow: hidden;
        }

        .power-outage-scene.active {
            display: flex;
        }

        .power-outage-scene .po-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            transition: all 1s ease;
        }

        .power-outage-scene .po-bg.waiting {
            background: radial-gradient(ellipse at center, #1a1a2a 0%, #0a0a1a 60%, #000000 100%);
        }

        .power-outage-scene .po-bg.music {
            background: radial-gradient(ellipse at 20% 70%, #1a2a4a 0%, #0a1a2a 60%, #000a1a 100%);
            animation: poBgPulse 2s ease-in-out infinite;
        }

        .power-outage-scene .po-bg.dark {
            background: #000000;
        }

        @keyframes poBgPulse {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
        }

        .power-outage-scene .po-freddy {
            position: absolute;
            bottom: 15%;
            left: 10%;
            font-size: 200px;
            z-index: 2;
            opacity: 0;
            transform: scale(0.5) translateX(-100px);
            transition: all 1s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 0 30px rgba(255,0,0,0.2));
        }

        .power-outage-scene .po-freddy.visible {
            opacity: 1;
            transform: scale(1) translateX(0);
        }

        .power-outage-scene .po-freddy .freddy-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 350px;
            height: 350px;
            background: radial-gradient(ellipse at center, rgba(200,0,0,0.2), transparent 70%);
            border-radius: 50%;
            z-index: -1;
            animation: freddyPulse 2s ease-in-out infinite;
        }

        .power-outage-scene .po-freddy .music-notes {
            position: absolute;
            font-size: 35px;
            color: rgba(255,200,200,0.6);
            animation: musicFloat 3s ease-in-out infinite;
            text-shadow: 0 0 20px rgba(255,200,200,0.3);
        }

        .power-outage-scene .po-freddy .music-notes:nth-child(1) {
            top: -70px;
            left: -30px;
            animation-delay: 0s;
        }
        .power-outage-scene .po-freddy .music-notes:nth-child(2) {
            top: -100px;
            right: -20px;
            animation-delay: 0.8s;
            font-size: 25px;
        }
        .power-outage-scene .po-freddy .music-notes:nth-child(3) {
            top: -50px;
            left: 50px;
            animation-delay: 1.6s;
            font-size: 28px;
        }
        .power-outage-scene .po-freddy .music-notes:nth-child(4) {
            top: -120px;
            left: 10px;
            animation-delay: 2.2s;
            font-size: 20px;
        }

        @keyframes freddyPulse {
            0%, 100% { opacity: 0.4; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.3); }
        }

        @keyframes musicFloat {
            0%, 100% { transform: translateY(0) scale(1) rotate(0deg); opacity: 0.5; }
            50% { transform: translateY(-40px) scale(1.3) rotate(10deg); opacity: 1; }
        }

        .power-outage-scene .po-freddy .freddy-text {
            position: absolute;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(200,100,100,0.4);
            font-family: 'Courier New', monospace;
            font-size: 18px;
            letter-spacing: 6px;
            text-transform: uppercase;
            white-space: nowrap;
            animation: freddyTextPulse 2s ease-in-out infinite;
        }

        @keyframes freddyTextPulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }

        .power-outage-scene .po-timer {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255,255,255,0.15);
            font-family: 'Courier New', monospace;
            font-size: 16px;
            letter-spacing: 3px;
            z-index: 3;
            background: rgba(0,0,0,0.3);
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.5s;
        }

        .power-outage-scene .po-timer.warning {
            color: rgba(255,50,50,0.4);
            border-color: rgba(255,0,0,0.1);
            animation: timerPulse 0.5s ease-in-out infinite;
        }

        @keyframes timerPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }

        .power-outage-scene .po-vignette {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center, transparent 30%, rgba(0,0,10,0.8) 100%);
            pointer-events: none;
            z-index: 1;
        }

        .power-outage-scene .po-scanlines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,255,0.02) 2px, rgba(0,0,255,0.02) 4px);
            pointer-events: none;
            z-index: 1;
            animation: poScanlines 0.1s infinite;
        }

        @keyframes poScanlines {
            0% { transform: translateY(0); }
            100% { transform: translateY(2px); }
        }

        .power-outage-scene .po-static {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(255,255,255,0.015) 3px, rgba(255,255,255,0.015) 4px);
            pointer-events: none;
            z-index: 1;
            opacity: 0;
            animation: poStatic 0.05s infinite;
        }

        .power-outage-scene .po-static.active {
            opacity: 0.4;
        }

        @keyframes poStatic {
            0% { transform: translate(0, 0); }
            25% { transform: translate(-1px, 1px); }
            50% { transform: translate(1px, -1px); }
            75% { transform: translate(-1px, -1px); }
            100% { transform: translate(1px, 1px); }
        }

        .power-outage-scene .po-flash {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            z-index: 2;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.05s;
        }

        .power-outage-scene .po-flash.active {
            opacity: 1;
            animation: flashFade 0.3s ease forwards;
        }

        @keyframes flashFade {
            0% { opacity: 0.3; }
            100% { opacity: 0; }
        }

        /* ===== СКРЫТИЕ ИНТЕРФЕЙСА ===== */
        .hide-ui .top-panel,
        .hide-ui .left-panel,
        .hide-ui .right-panel,
        .hide-ui .bottom-panel,
        .hide-ui .back-btn,
        .hide-ui .tablet-toggle-btn,
        .hide-ui .office-hint,
        .hide-ui .note-btn {
            display: none !important;
        }

        .hide-ui .office-view {
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* ===== ПРАВИЛЬНОЕ РАСПОЛОЖЕНИЕ ПАНЕЛЕЙ УПРАВЛЕНИЯ ===== */
        /* Левая панель управления - слева от левой двери */
        .left-door-panel {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Правая панель управления - справа от правой двери */
        .right-door-panel {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Скрытие панелей в режиме планшета */
        .tablet-mode .left-door-panel,
        .tablet-mode .right-door-panel {
            display: none !important;
        }

        .door-control {
            background: rgba(0,0,0,0.8);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 8px 12px;
            min-width: 100px;
            text-align: center;
        }

        .door-control .label {
            color: #888;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .door-control .door-btn,
        .door-control .light-btn {
            display: inline-block;
            padding: 4px 10px;
            margin: 2px;
            font-size: 11px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 4px;
            color: #ccc;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
        }

        .door-control .door-btn:hover,
        .door-control .light-btn:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.4);
        }

        .door-control .door-btn.closed {
            border-color: #ff4444;
            color: #ff4444;
            background: rgba(255,68,68,0.15);
        }

        .door-control .light-btn.active {
            border-color: #ffaa44;
            color: #ffaa44;
            background: rgba(255,170,68,0.15);
        }

        .door-control .door-btn.disabled,
        .door-control .light-btn.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        .door-control .status {
            font-size: 9px;
            margin-left: 3px;
        }

        /* Убираем подсказку */
        .office-hint {
            display: none !important;
        }

        /* Контейнер для позиционирования панелей */
        .game-container {
            position: relative;
        }

        /* Стили для правой панели (бывшая) - больше не нужна */
        .right-panel {
            display: none !important;
        }
    </style>
</head>
<body>
    <!-- ===== СКРИМЕР ===== -->
    <div class="screamer-overlay" id="screamerOverlay">
        <div class="screamer-bg"></div>
        <div class="screamer-static"></div>
        <div class="screamer-scanlines"></div>
        <div class="screamer-vignette"></div>
        <div class="screamer-extra"></div>
        <div class="screamer-face" id="screamerFace">🐻</div>
    </div>

    <!-- ===== GAME OVER ===== -->
    <div class="gameover-overlay" id="gameoverOverlay">
        <div class="gameover-title">💀 GAME OVER</div>
        <div class="gameover-subtitle" id="gameoverReason">Вы умерли</div>
        <div class="gameover-time" id="gameoverTime">12:00 AM</div>
        <button class="gameover-btn" id="gameoverBtn">↻ В МЕНЮ</button>
    </div>

    <!-- ===== ПРЕДУПРЕЖДЕНИЕ ===== -->
    <div class="danger-warning" id="dangerWarning">⚠️ ОПАСНОСТЬ!</div>

    <!-- ===== СЦЕНА ОТКЛЮЧЕНИЯ ===== -->
    <div class="power-outage-scene" id="powerOutageScene">
        <div class="po-bg waiting" id="poBg"></div>
        <div class="po-vignette"></div>
        <div class="po-scanlines"></div>
        <div class="po-static" id="poStatic"></div>
        <div class="po-flash" id="poFlash"></div>
        <div class="po-freddy" id="poFreddy">
            <div class="freddy-glow"></div>
            <span class="music-notes">♪</span>
            <span class="music-notes">♫</span>
            <span class="music-notes">♪</span>
            <span class="music-notes">♫</span>
            🐻
            <div class="freddy-text">...Фредди играет...</div>
        </div>
        <div class="po-timer" id="poTimer">⚡ 30</div>
    </div>

    <!-- ===== ИГРОВОЙ КОНТЕЙНЕР ===== -->
    <div class="game-container office-mode" id="gameContainer">
        <!-- Верхняя панель -->
        <div class="top-panel">
            <div class="time" id="gameTime">12:00 AM</div>
            <div class="night">НОЧЬ {{ $session->night }}</div>
            <div class="mode-indicator" id="modeIndicator">
                {{ session('game_mode', 'easy') === 'hard' ? '🔴' : '🟢' }}
            </div>
        </div>

        <!-- Левая панель -->
        <div class="left-panel">
            <div class="camera-map">
                <div class="static-overlay"></div>
                <svg class="map-lines" viewBox="0 0 401 330" preserveAspectRatio="none">
                    <line x1="153" y1="36" x2="153" y2="63" />
                    <line x1="95" y1="87" x2="70" y2="87" />
                    <line x1="207" y1="87" x2="337" y2="100" />
                    <line x1="150" y1="111" x2="150" y2="133" />
                    <line x1="120" y1="181" x2="120" y2="205" />
                    <line x1="185" y1="181" x2="185" y2="205" />
                    <line x1="45" y1="205" x2="360" y2="205" />
                    <line x1="45" y1="205" x2="45" y2="222" />
                    <line x1="154" y1="205" x2="154" y2="217" />
                    <line x1="284" y1="205" x2="284" y2="217" />
                    <line x1="360" y1="205" x2="360" y2="217" />
                    <line x1="154" y1="259" x2="154" y2="258" />
                    <line x1="284" y1="259" x2="284" y2="258" />
                    <line x1="190" y1="270" x2="218" y2="270" />
                    <line x1="218" y1="262" x2="218" y2="290" />
                </svg>
                <button class="camera-btn map-btn disabled" data-camera="cam_1a" style="left:26.9%; top:0.9%; width:22.4%; height:10%; opacity:0.3; cursor:not-allowed;">1A</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_5" style="left:0.5%; top:21.8%; width:17%; height:10.6%; opacity:0.3; cursor:not-allowed;">5</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_1b" style="left:23.7%; top:19.1%; width:27.9%; height:14.5%; opacity:0.3; cursor:not-allowed;">1B</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_7" style="left:84%; top:20.6%; width:15.5%; height:22.7%; opacity:0.3; cursor:not-allowed;">7</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_1c" style="left:19.5%; top:40.3%; width:27%; height:14.5%; opacity:0.3; cursor:not-allowed;">1C</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_3" style="left:3.7%; top:67.3%; width:15.5%; height:14.5%; opacity:0.3; cursor:not-allowed;">3</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_2a" style="left:29.4%; top:65.8%; width:18%; height:12.7%; opacity:0.3; cursor:not-allowed;">2A</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_2b" style="left:29.4%; top:78.2%; width:18%; height:14.5%; opacity:0.3; cursor:not-allowed;">2B</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_4a" style="left:61.8%; top:65.8%; width:18%; height:12.7%; opacity:0.3; cursor:not-allowed;">4A</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_4b" style="left:61.8%; top:78.2%; width:18%; height:14.5%; opacity:0.3; cursor:not-allowed;">4B</button>
                <button class="camera-btn map-btn disabled" data-camera="cam_6" style="left:83%; top:65.8%; width:15.5%; height:14.5%; opacity:0.3; cursor:not-allowed;">6</button>
                <div class="you-marker" style="left:49.4%; top:79.4%; width:10%; height:11.5%;">
                    <span>YOU</span>
                    <div class="you-dot"></div>
                </div>
            </div>
        </div>

        <!-- Центр -->
        <div class="camera-view" id="cameraView">
            <div id="cameraImage"></div>
            <div class="static-overlay"></div>
            <div class="camera-label" id="cameraLabel">CAM 1A — СЦЕНА</div>
        </div>

        <!-- Офис -->
        <div class="office-view" id="officeView">
            <div class="office-lamp">
                <div class="office-lamp-face"></div>
            </div>
            <div class="cobweb tl"></div>
            <div class="cobweb tr"></div>
            <div class="office-wall">
                <div class="office-poster small-left">
                    <span class="drawing d1"></span>
                    <span class="drawing d2"></span>
                    <span class="drawing d3"></span>
                </div>
                <div class="office-poster main">
                    ПРАЗДНИК!
                    <div class="office-shelf-figures">
                        <div class="shelf-figure freddy"></div>
                        <div class="shelf-figure bonnie"></div>
                    </div>
                </div>
                <div class="office-poster small-right">
                    <span class="drawing d1"></span>
                    <span class="drawing d2"></span>
                    <span class="drawing d3"></span>
                    <span class="drawing d4"></span>
                </div>
            </div>
            <div class="office-red-stripe"></div>
            <div class="office-doorframe left" id="officeDoorLeft">
                <div class="door-hallway">
                    <div class="hallway-floor"></div>
                    <div class="hallway-visitor" id="leftHallwayVisitor"></div>
                </div>
                <div class="office-door-panel"></div>
            </div>
            <div class="office-doorframe right" id="officeDoorRight">
                <div class="door-hallway">
                    <div class="hallway-floor"></div>
                    <div class="hallway-visitor" id="rightHallwayVisitor"></div>
                </div>
                <div class="office-door-panel"></div>
            </div>
            <div class="office-floor"></div>
            <div class="office-spiral s1"></div>
            <div class="office-spiral s2"></div>
            <div class="desk-drawers">
                <div class="drawer"></div>
                <div class="drawer"></div>
            </div>
            <div class="office-desk">
                <div class="desk-plushie left">🧸</div>
                <div class="desk-monitor">MON</div>
                <div class="desk-fan"></div>
                <div class="desk-party-blower">🎉</div>
                <div class="desk-tally">
                    <div>НОЧЬ {{ $session->night }}</div>
                    <div>
                        @for ($i = 1; $i <= 3; $i++)
                            @if ($i <= ($session->stars ?? 0))
                                <span style="color: #ffd700;">★</span>
                            @else
                                <span style="color: #444;">☆</span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            <button class="note-btn" id="noteBtn">📋 ЗАПИСКА</button>

            <div class="note-overlay hidden" id="noteOverlay">
                <div class="note-container" id="noteContainer">
                    <div class="note-header">
                        <span class="note-title">📋 ЗАПИСКА ОТ ФОН ГАЯ</span>
                        <button class="note-close-btn" id="noteCloseBtn">✕</button>
                    </div>
                    <div class="note-body" id="noteBody">
                        @if($session->night <= 4)
                            @include("calls.night{$session->night}")
                        @elseif($session->night == 5)
                            <div class="call-content">
                                <div class="call-title" style="color: #555; letter-spacing: 6px;">📡 ...</div>
                                <div class="call-text" style="text-align: center; color: #444;">
                                    <p style="font-size: 32px; color: #222;">❚❚❚❚❚❚❚❚❚❚</p>
                                    <p style="color: #555; font-size: 14px; margin-top: 10px;">В эфире тишина.</p>
                                    <p style="color: #444; font-size: 13px;">Вы ждёте звонка, но никто не звонит.</p>
                                    <p style="color: #333; font-size: 12px; margin-top: 15px; font-style: italic;">— Вчера он обещал поговорить завтра. —</p>
                                    <p style="color: #2a2a2a; font-size: 11px; margin-top: 5px;">[статический шум...]</p>
                                </div>
                                <div class="call-footer" style="color: #2a2a2a;">🕒 Ночь 5 — 12:00 AM</div>
                            </div>
                        @elseif($session->night == 6)
                            <div class="call-content">
                                <div class="call-title" style="color: #663333; letter-spacing: 4px;">📻 СТАТИКА</div>
                                <div class="call-text" style="text-align: center; color: #444;">
                                    <p style="font-size: 28px; color: #333;">❚❚❚❚❚❚❚❚❚❚</p>
                                    <p style="color: #555; font-size: 13px;">Белый шум. Только белый шум.</p>
                                    <p style="color: #444; font-size: 12px;">Иногда сквозь помехи слышно что-то...</p>
                                    <p style="color: #883333; font-size: 13px; margin-top: 15px; font-style: italic;">"...он идёт..."</p>
                                    <p style="color: #333; font-size: 11px;">...но это просто ветер.</p>
                                    <p style="color: #2a2a2a; font-size: 10px;">[звук шагов за стеной]</p>
                                </div>
                                <div class="call-footer" style="color: #2a2a2a;">🕒 Ночь 6 — 12:00 AM</div>
                            </div>
                        @elseif($session->night == 7)
                            <div class="call-content">
                                <div class="call-title" style="color: #cc2222; letter-spacing: 6px;">🔴 ТЫ СПИШЬ?</div>
                                <div class="call-text" style="text-align: center; color: #884444;">
                                    <p style="font-size: 48px; color: #cc4444;">🎵</p>
                                    <p style="color: #883333; font-size: 15px; letter-spacing: 2px;">Ты слышишь эту мелодию?</p>
                                    <p style="color: #663333; font-size: 13px;">Она звучит всё ближе.</p>
                                    <p style="color: #552222; font-size: 13px; margin-top: 15px; font-style: italic;">— Он никогда не уходит. —</p>
                                    <p style="color: #442222; font-size: 11px;">Он просто ждёт.</p>
                                    <p style="color: #333; font-size: 10px; margin-top: 10px;">[скрип половиц за дверью]</p>
                                    <p style="color: #222; font-size: 9px;">...и ты знаешь это.</p>
                                </div>
                                <div class="call-footer" style="color: #442222;">🕒 Ночь 7 — ПОСЛЕДНЯЯ</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ===== ЭКРАН ПОБЕДЫ ===== -->
            <div class="victory-screen" id="victoryScreen">
                <div class="victory-overlay"></div>
                <div class="victory-content">
                    <div class="victory-time" id="victoryTime">6:00 AM</div>
                    <div class="victory-subtitle">НОЧЬ {{ $session->night }} ПРОЙДЕНА</div>
                    <button class="victory-btn" id="victoryBtn">▶ ПРОДОЛЖИТЬ</button>
                </div>
            </div>
        </div>

        <!-- ===== ПАНЕЛИ УПРАВЛЕНИЯ (правильное расположение) ===== -->

        <!-- Левая панель управления - слева от левой двери -->
        <div class="left-door-panel" id="leftDoorPanel">
            <div class="door-control">
                <div class="label">🚪 ЛЕВАЯ</div>
                <button class="door-btn" id="leftDoor">
                    <span class="status">ОТКР.</span>
                </button>
                <button class="light-btn" id="leftLight">💡</button>
            </div>
        </div>

        <!-- Правая панель управления - справа от правой двери -->
        <div class="right-door-panel" id="rightDoorPanel">
            <div class="door-control">
                <div class="label">🚪 ПРАВАЯ</div>
                <button class="door-btn" id="rightDoor">
                    <span class="status">ОТКР.</span>
                </button>
                <button class="light-btn" id="rightLight">💡</button>
            </div>
        </div>

        <!-- ===== НИЖНЯЯ ПАНЕЛЬ ===== -->
        <div class="bottom-panel">
            <div class="left-group">
                <div class="power-block">
                    <div class="power-label">⚡ ЭНЕРГИЯ</div>
                    <div class="power-value" id="powerDisplay">100%</div>
                    <div class="power-bar">
                        <div class="fill" id="powerBar" style="width: 100%"></div>
                    </div>
                </div>
                <div class="usage-block">
                    <div class="usage-label">⚡ USAGE</div>
                    <div class="usage-bars" id="usageBars">
                        <div class="usage-bar green active"></div>
                        <div class="usage-bar green"></div>
                        <div class="usage-bar yellow"></div>
                        <div class="usage-bar red"></div>
                    </div>
                </div>
            </div>

            <div class="indicators-block">
                <div class="indicator">
                    <div class="led" id="freddyLed"></div>
                    <div class="name">ФРЕДДИ</div>
                </div>
                <div class="indicator">
                    <div class="led" id="bonnieLed"></div>
                    <div class="name">БОННИ</div>
                </div>
                <div class="indicator">
                    <div class="led" id="chicaLed"></div>
                    <div class="name">ЧИКА</div>
                </div>
                <div class="indicator">
                    <div class="led" id="foxyLed"></div>
                    <div class="name">ФОКСИ</div>
                </div>
            </div>

            <div class="door-status-block">
                <div class="door-status-item">
                    <div class="led green" id="leftDoorLed"></div>
                    <span>ЛЕВ. ДВ.</span>
                </div>
                <div class="door-status-item">
                    <div class="led green" id="rightDoorLed"></div>
                    <span>ПРАВ. ДВ.</span>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('menu') }}" class="back-btn">✕ В МЕНЮ</a>
    <button class="tablet-toggle-btn office-mode-btn" id="tabletToggle" style="border-color:#44ff44;color:#44ff44;">📱 ПОДНЯТЬ ПЛАНШЕТ</button>

    <script>
        // ============================================================
        //  ВСЯ ИГРОВАЯ ЛОГИКА (полная, как в предыдущей версии)
        // ============================================================

        const gameMode = '{{ session('game_mode', 'easy') }}';

        const CONFIG = {
            HOUR_DURATION: 90000,
            POWER_DRAIN_PER_HOUR: 8,
            POWER_DRAIN_CAMERA: 0.5,
            POWER_DRAIN_DOOR: 2,
            POWER_DRAIN_LIGHT: 1,
            OFFICE_ENTRY_DELAY: 5,
            POWER_OUTAGE_WAIT: 30,
            POWER_OUTAGE_MUSIC: 15,
            POWER_OUTAGE_DARK: 5
        };

        const AI_LEVELS = {
            1: { freddy: 0, bonnie: 3, chica: 3, foxy: 0 },
            2: { freddy: 0, bonnie: 5, chica: 5, foxy: 0 },
            3: { freddy: 1, bonnie: 6, chica: 6, foxy: 1 },
            4: { freddy: 2, bonnie: 8, chica: 8, foxy: 2 },
            5: { freddy: 3, bonnie: 9, chica: 9, foxy: 3 },
            6: { freddy: 6, bonnie: 15, chica: 15, foxy: 6 },
            7: { freddy: 20, bonnie: 20, chica: 20, foxy: 20 }
        };

        const AI_BOOSTS = {
            2: { bonnie: 1 },
            3: { bonnie: 1, chica: 1, foxy: 1 },
            4: { bonnie: 1, chica: 1, foxy: 1 }
        };

        const aiState = {
            levels: { freddy: 0, bonnie: 0, chica: 0, foxy: 0 },
            positions: {
                freddy: 'cam_1a',
                bonnie: 'cam_1a',
                chica: 'cam_1a',
                foxy: 'cam_1c'
            },
            inOffice: { bonnie: false, chica: false },
            atDoor: { bonnie: false, chica: false },
            atDoorTimers: { bonnie: null, chica: null },
            foxyStage: 1,
            isFoxyRunning: false,
            cooldown: { freddy: 0, bonnie: 0, chica: 0, foxy: 0 }
        };

        const PATHS = {
            freddy: ['cam_1a', 'cam_1b', 'cam_7', 'cam_6', 'cam_4a', 'cam_4b', 'office_right'],
            bonnie: ['cam_1a', 'cam_1b', 'cam_2a', 'cam_2b', 'cam_3', 'cam_5', 'office_left'],
            chica: ['cam_1a', 'cam_1b', 'cam_4a', 'cam_4b', 'cam_6', 'cam_7', 'office_right']
        };

        const gameState = {
            night: {{ $session->night }},
            time: 0,
            minute: 0,
            hourStartTimestamp: Date.now(),
            power: 100,
            isGameOver: false,
            currentCamera: 'cam_1a',
            leftDoorClosed: false,
            rightDoorClosed: false,
            isTabletMode: false,
            isLightOn: false,
            leftLightOn: false,
            rightLightOn: false,
            isBlackout: false,
            powerOutage: {
                active: false,
                timer: 0,
                phase: 'waiting',
                sceneActive: false
            }
        };

        const el = {
            container: document.getElementById('gameContainer'),
            time: document.getElementById('gameTime'),
            powerDisplay: document.getElementById('powerDisplay'),
            powerBar: document.getElementById('powerBar'),
            cameraLabel: document.getElementById('cameraLabel'),
            cameraImage: document.getElementById('cameraImage'),
            leftDoor: document.getElementById('leftDoor'),
            rightDoor: document.getElementById('rightDoor'),
            leftLight: document.getElementById('leftLight'),
            rightLight: document.getElementById('rightLight'),
            leftDoorLed: document.getElementById('leftDoorLed'),
            rightDoorLed: document.getElementById('rightDoorLed'),
            officeDoorLeft: document.getElementById('officeDoorLeft'),
            officeDoorRight: document.getElementById('officeDoorRight'),
            officeView: document.getElementById('officeView'),
            cameraBtns: document.querySelectorAll('.camera-btn'),
            tabletToggle: document.getElementById('tabletToggle'),
            usageBars: document.querySelectorAll('.usage-bar'),
            noteBtn: document.getElementById('noteBtn'),
            noteOverlay: document.getElementById('noteOverlay'),
            noteCloseBtn: document.getElementById('noteCloseBtn'),
            victoryScreen: document.getElementById('victoryScreen'),
            victoryBtn: document.getElementById('victoryBtn'),
            leds: {
                freddy: document.getElementById('freddyLed'),
                bonnie: document.getElementById('bonnieLed'),
                chica: document.getElementById('chicaLed'),
                foxy: document.getElementById('foxyLed')
            },
            screamerOverlay: document.getElementById('screamerOverlay'),
            screamerFace: document.getElementById('screamerFace'),
            gameoverOverlay: document.getElementById('gameoverOverlay'),
            gameoverReason: document.getElementById('gameoverReason'),
            gameoverTime: document.getElementById('gameoverTime'),
            gameoverBtn: document.getElementById('gameoverBtn'),
            dangerWarning: document.getElementById('dangerWarning'),
            powerOutageScene: document.getElementById('powerOutageScene'),
            poBg: document.getElementById('poBg'),
            poFreddy: document.getElementById('poFreddy'),
            poTimer: document.getElementById('poTimer'),
            poStatic: document.getElementById('poStatic'),
            poFlash: document.getElementById('poFlash')
        };

        let gameLoopInterval = null;
        let aiStepInterval = null;
        let aiBoostInterval = null;
        let aiFoxyInterval = null;
        let minuteLoopInterval = null;
        let foxyRunTimeout = null;
        let powerDrainInterval = null;
        let powerOutageInterval = null;
        const inOfficeLeaveTimers = { bonnie: null, chica: null };
        let screamerTimeout = null;
        let dangerTimeout = null;
        let victoryActive = false;

        // ============================================================
        //  СКРИМЕР И GAME OVER
        // ============================================================

        function showScreamer(faceEmoji, reason) {
            if (gameState.isGameOver) return;
            gameState.isGameOver = true;

            clearInterval(gameLoopInterval);
            clearInterval(aiStepInterval);
            clearInterval(aiBoostInterval);
            clearInterval(aiFoxyInterval);
            clearInterval(minuteLoopInterval);
            clearInterval(powerDrainInterval);
            if (powerOutageInterval) clearInterval(powerOutageInterval);
            clearTimeout(foxyRunTimeout);
            Object.keys(inOfficeLeaveTimers).forEach(name => {
                if (inOfficeLeaveTimers[name]) {
                    clearTimeout(inOfficeLeaveTimers[name]);
                    inOfficeLeaveTimers[name] = null;
                }
            });
            Object.keys(aiState.atDoorTimers).forEach(name => {
                if (aiState.atDoorTimers[name]) {
                    clearTimeout(aiState.atDoorTimers[name]);
                    aiState.atDoorTimers[name] = null;
                }
            });

            if (gameState.powerOutage.sceneActive) {
                el.powerOutageScene.classList.remove('active');
                el.container.classList.remove('hide-ui');
                gameState.powerOutage.sceneActive = false;
            }

            const overlay = el.screamerOverlay;
            const face = el.screamerFace;

            overlay.className = 'screamer-overlay';
            face.className = 'screamer-face';

            face.textContent = faceEmoji;

            let styleClass = '';
            if (faceEmoji.includes('🐰')) {
                styleClass = 'bonnie-style';
                face.classList.add('bonnie');
            } else if (faceEmoji.includes('🐤')) {
                styleClass = 'chica-style';
                face.classList.add('chica');
            } else if (faceEmoji.includes('🐻')) {
                styleClass = 'freddy-style';
                face.classList.add('freddy');
            } else if (faceEmoji.includes('🦊')) {
                styleClass = 'foxy-style';
                face.classList.add('foxy');
            }

            if (styleClass) {
                overlay.classList.add(styleClass);
            }

            if (navigator.vibrate) {
                navigator.vibrate([100, 50, 100, 50, 200]);
            }

            overlay.classList.add('active');

            setTimeout(() => {
                overlay.querySelector('.screamer-static').style.opacity = '0.6';
            }, 800);

            screamerTimeout = setTimeout(() => {
                overlay.classList.remove('active');
                overlay.querySelector('.screamer-static').style.opacity = '0';

                el.gameoverReason.textContent = reason;
                el.gameoverTime.textContent = el.time.textContent;
                el.gameoverOverlay.classList.add('active');
            }, 3000);
        }

        // ============================================================
        //  СЦЕНА ОТКЛЮЧЕНИЯ
        // ============================================================

        function startPowerOutageScene() {
            if (gameState.isGameOver || gameState.powerOutage.sceneActive) return;

            clearInterval(gameLoopInterval);
            clearInterval(aiStepInterval);
            clearInterval(aiBoostInterval);
            clearInterval(aiFoxyInterval);
            clearInterval(minuteLoopInterval);
            clearInterval(powerDrainInterval);
            clearTimeout(foxyRunTimeout);
            Object.keys(inOfficeLeaveTimers).forEach(name => {
                if (inOfficeLeaveTimers[name]) {
                    clearTimeout(inOfficeLeaveTimers[name]);
                    inOfficeLeaveTimers[name] = null;
                }
            });

            gameState.powerOutage.sceneActive = true;
            gameState.powerOutage.timer = 0;
            gameState.powerOutage.phase = 'waiting';

            el.container.classList.add('hide-ui');

            const scene = el.powerOutageScene;
            const bg = el.poBg;
            const freddy = el.poFreddy;
            const timer = el.poTimer;
            const stat = el.poStatic;

            scene.classList.add('active');
            bg.className = 'po-bg waiting';
            freddy.classList.remove('visible');
            stat.classList.remove('active');
            timer.textContent = '⚡ 30';
            timer.className = 'po-timer';

            console.log('⚡ СЦЕНА ОТКЛЮЧЕНИЯ ЭЛЕКТРИЧЕСТВА НАЧАЛАСЬ!');

            if (powerOutageInterval) clearInterval(powerOutageInterval);
            powerOutageInterval = setInterval(updatePowerOutageScene, 1000);
        }

        function updatePowerOutageScene() {
            gameState.powerOutage.timer++;
            const timer = gameState.powerOutage.timer;
            const scene = el.powerOutageScene;
            const bg = el.poBg;
            const freddy = el.poFreddy;
            const timerEl = el.poTimer;
            const stat = el.poStatic;
            const flash = el.poFlash;

            if (timer <= CONFIG.POWER_OUTAGE_WAIT) {
                const remaining = CONFIG.POWER_OUTAGE_WAIT - timer;
                timerEl.textContent = `⚡ ${remaining}`;
                timerEl.className = 'po-timer';

                if (timer % 2 === 0) {
                    flash.classList.remove('active');
                    setTimeout(() => {
                        flash.classList.add('active');
                        setTimeout(() => {
                            flash.classList.remove('active');
                        }, 200);
                    }, 50);
                }
                return;
            }

            if (timer <= CONFIG.POWER_OUTAGE_WAIT + CONFIG.POWER_OUTAGE_MUSIC) {
                const musicTimer = timer - CONFIG.POWER_OUTAGE_WAIT;
                const totalMusic = CONFIG.POWER_OUTAGE_MUSIC;
                timerEl.textContent = `🎵 ${musicTimer}/${totalMusic}`;
                timerEl.className = 'po-timer warning';

                bg.className = 'po-bg music';

                if (!freddy.classList.contains('visible')) {
                    freddy.classList.add('visible');
                    console.log('🎵 Фредди играет музыку! (15 секунд)');
                }

                if (musicTimer > 3) {
                    stat.classList.add('active');
                }

                if (musicTimer % 3 === 0) {
                    flash.classList.remove('active');
                    setTimeout(() => {
                        flash.classList.add('active');
                        setTimeout(() => {
                            flash.classList.remove('active');
                        }, 150);
                    }, 50);
                }
                return;
            }

            if (timer <= CONFIG.POWER_OUTAGE_WAIT + CONFIG.POWER_OUTAGE_MUSIC + CONFIG.POWER_OUTAGE_DARK) {
                const darkTimer = timer - CONFIG.POWER_OUTAGE_WAIT - CONFIG.POWER_OUTAGE_MUSIC;
                const totalDark = CONFIG.POWER_OUTAGE_DARK;
                timerEl.textContent = `🌑 ${darkTimer}/${totalDark}`;
                timerEl.className = 'po-timer warning';

                bg.className = 'po-bg dark';
                freddy.classList.remove('visible');
                stat.classList.add('active');

                if (darkTimer === 1) {
                    flash.classList.remove('active');
                    setTimeout(() => {
                        flash.classList.add('active');
                        setTimeout(() => {
                            flash.classList.remove('active');
                        }, 300);
                    }, 50);
                    console.log('🌑 ПОЛНАЯ ТЬМА! (5 секунд)');
                }
                return;
            }

            if (!gameState.isGameOver) {
                timerEl.textContent = '💀';
                timerEl.className = 'po-timer warning';

                console.log('💀 СКРИМЕР ФРЕДДИ!');

                flash.classList.remove('active');
                setTimeout(() => {
                    flash.classList.add('active');
                    setTimeout(() => {
                        flash.classList.remove('active');
                    }, 200);
                }, 50);

                setTimeout(() => {
                    scene.classList.remove('active');
                    el.container.classList.remove('hide-ui');
                    gameState.powerOutage.sceneActive = false;

                    clearInterval(powerOutageInterval);
                    powerOutageInterval = null;

                    setTimeout(() => {
                        showScreamer('🐻', '🔴 Фредди добрался до офиса!');
                    }, 300);
                }, 500);
            }
        }

        // ============================================================
        //  ОСТАЛЬНЫЕ ФУНКЦИИ (сокращены для экономии места, но полные)
        // ============================================================

        function showVictoryScreen() {
            victoryActive = true;
            clearInterval(gameLoopInterval);
            clearInterval(aiStepInterval);
            clearInterval(aiBoostInterval);
            clearInterval(aiFoxyInterval);
            clearInterval(minuteLoopInterval);
            clearInterval(powerDrainInterval);
            if (powerOutageInterval) clearInterval(powerOutageInterval);

            if (gameState.powerOutage.sceneActive) {
                el.powerOutageScene.classList.remove('active');
                el.container.classList.remove('hide-ui');
                gameState.powerOutage.sceneActive = false;
            }

            el.victoryScreen.classList.add('active');
            setTimeout(() => {
                el.victoryScreen.classList.add('fade-in');
            }, 100);

            document.getElementById('victoryTime').textContent = '6:00 AM';
            console.log('🎉 Ночь пройдена! 6:00 AM!');
        }

        // ===== ЧИТЕРСКАЯ КОМБИНАЦИЯ =====
        const keysPressed = {};

        document.addEventListener('keydown', (event) => {
            const key = event.key.toLowerCase();
            keysPressed[key] = true;

            if (keysPressed['c'] && keysPressed['d'] && keysPressed['+']) {
                if (gameState.isGameOver) return;
                console.log('🎮 ЧИТЕРСКАЯ КОМБИНАЦИЯ АКТИВИРОВАНА!');
                showWarning('⚡ ПРОПУСК НОЧИ АКТИВИРОВАН!');
                gameState.time = 6;
                gameState.minute = 0;
                updateTime();
                showVictoryScreen();
            }
        });

        document.addEventListener('keyup', (event) => {
            keysPressed[event.key.toLowerCase()] = false;
        });

        // ===== ФУНКЦИИ ИИ =====
        function initAI(night) {
            if (night === 7 && window.customAiLevels) {
                const custom = window.customAiLevels;
                aiState.levels.freddy = custom.freddy ?? 20;
                aiState.levels.bonnie = custom.bonnie ?? 20;
                aiState.levels.chica = custom.chica ?? 20;
                aiState.levels.foxy = custom.foxy ?? 20;
                console.log('🎮 Custom Night: загружены пользовательские настройки ИИ');
            } else {
                const base = AI_LEVELS[night] || AI_LEVELS[1];
                aiState.levels.freddy = base.freddy;
                aiState.levels.bonnie = base.bonnie;
                aiState.levels.chica = base.chica;
                aiState.levels.foxy = base.foxy;
            }

            aiState.positions.freddy = 'cam_1a';
            aiState.positions.bonnie = 'cam_1a';
            aiState.positions.chica = 'cam_1a';
            aiState.positions.foxy = 'cam_1c';
            aiState.inOffice = { bonnie: false, chica: false };
            aiState.atDoor = { bonnie: false, chica: false };
            aiState.atDoorTimers = { bonnie: null, chica: null };
            aiState.foxyStage = 1;
            aiState.isFoxyRunning = false;
            aiState.cooldown = { freddy: 0, bonnie: 0, chica: 0, foxy: 0 };

            console.log('🤖 ИИ инициализирован для ночи', night);
            console.log('📊 Уровни:', aiState.levels);
        }

        function checkAIBoosts() {
            const currentHour = gameState.time;
            if (AI_BOOSTS[currentHour]) {
                const boost = AI_BOOSTS[currentHour];
                let changed = false;
                Object.keys(boost).forEach(name => {
                    if (aiState.levels[name] !== undefined) {
                        aiState.levels[name] += boost[name];
                        changed = true;
                    }
                });
                if (changed) {
                    console.log(`⬆️ ${currentHour}:00 AM — Повышение уровней ИИ!`);
                    console.log('📊 Новые уровни:', aiState.levels);
                }
            }
        }

        function makeAIStep() {
            if (gameState.isGameOver || gameState.powerOutage.sceneActive) return;
            const names = ['freddy', 'bonnie', 'chica'];
            names.forEach(name => {
                if (aiState.cooldown[name] > 0) {
                    aiState.cooldown[name]--;
                    return;
                }
                const level = aiState.levels[name];
                if (level <= 0) return;
                const chance = level / 20;
                if (Math.random() < chance) {
                    moveAnimatronic(name);
                }
            });
        }

        function moveAnimatronic(name) {
            console.log(`🚶 ${name.toUpperCase()} делает шаг...`);
            const path = PATHS[name];
            if (!path) return;

            if (aiState.inOffice[name]) return;
            if (aiState.atDoor[name]) return;

            const currentPos = aiState.positions[name];

            if (name === 'freddy' && currentPos === 'office_right') return;

            if (currentPos === 'office_left' || currentPos === 'office_right') {
                attackAnimatronic(name);
                return;
            }

            const currentIndex = path.indexOf(currentPos);

            if (currentIndex >= path.length - 1) {
                attackAnimatronic(name);
                return;
            }

            const nextPos = path[currentIndex + 1];
            aiState.positions[name] = nextPos;
            updateAnimatronicIndicator(name);
            updateDoorVisitors();

            if (nextPos === 'office_left' || nextPos === 'office_right') {
                attackAnimatronic(name);
            }
        }

        function retreatAnimatronic(name) {
            const path = PATHS[name];
            if (!path) return;

            if (aiState.atDoor[name]) {
                aiState.atDoor[name] = false;
                if (aiState.atDoorTimers[name]) {
                    clearTimeout(aiState.atDoorTimers[name]);
                    aiState.atDoorTimers[name] = null;
                }
                console.log(`⏹️ ${name.toUpperCase()} перестал ждать у двери (отступление)`);
            }

            const currentIndex = path.indexOf(aiState.positions[name]);
            const backStep = Math.min(2, currentIndex);
            const fallbackIndex = Math.max(0, currentIndex - backStep);
            aiState.positions[name] = path[fallbackIndex];
            aiState.cooldown[name] = 3 + Math.floor(Math.random() * 2);
            console.log(`🚶 ${name.toUpperCase()} отступил на ${backStep} шага назад`);
            updateAnimatronicIndicator(name);
            updateDoorVisitors();
        }

        function startOfficeEntryDelay(name) {
            const door = name === 'bonnie' ? 'left' : 'right';
            const isClosed = door === 'left' ? gameState.leftDoorClosed : gameState.rightDoorClosed;

            if (isClosed) {
                console.log(`🚪 ${name.toUpperCase()} у ${door} двери, но она закрыта → отступление`);
                retreatAnimatronic(name);
                return;
            }

            aiState.atDoor[name] = true;
            console.log(`⏳ ${name.toUpperCase()} у ${door} двери! Войдёт через ${CONFIG.OFFICE_ENTRY_DELAY} секунд...`);

            showDangerWarning();
            showWarning(`⚠️ ${name.toUpperCase()} у ${door} двери! Закройте дверь!`);

            if (aiState.atDoorTimers[name]) {
                clearTimeout(aiState.atDoorTimers[name]);
            }

            aiState.atDoorTimers[name] = setTimeout(() => {
                const doorNow = name === 'bonnie' ? 'left' : 'right';
                const isClosedNow = doorNow === 'left' ? gameState.leftDoorClosed : gameState.rightDoorClosed;

                if (isClosedNow) {
                    console.log(`🚪 ${name.toUpperCase()} у двери, но её закрыли! Отступление.`);
                    aiState.atDoor[name] = false;
                    aiState.atDoorTimers[name] = null;
                    retreatAnimatronic(name);
                    return;
                }

                console.log(`🚪 ${name.toUpperCase()} вошёл в офис через ${CONFIG.OFFICE_ENTRY_DELAY} секунд!`);
                aiState.atDoor[name] = false;
                aiState.atDoorTimers[name] = null;
                enterOffice(name);
            }, CONFIG.OFFICE_ENTRY_DELAY * 1000);
        }

        function enterOffice(name) {
            aiState.inOffice[name] = true;
            console.log(`👻 ${name.toUpperCase()} проник в офис! Двери и свет не помогут.`);

            if (inOfficeLeaveTimers[name]) {
                clearTimeout(inOfficeLeaveTimers[name]);
                inOfficeLeaveTimers[name] = null;
            }

            if (!gameState.isTabletMode && !gameState.powerOutage.sceneActive) {
                startOfficeLeaveTimer(name);
            } else if (gameState.powerOutage.sceneActive) {
                console.log(`⏳ ${name.toUpperCase()} в офисе, но идёт сцена отключения`);
            }

            updateOfficeControls();
            updateDoorVisitors();
            updateAnimatronicIndicator(name);
        }

        function startOfficeLeaveTimer(name) {
            if (inOfficeLeaveTimers[name]) {
                clearTimeout(inOfficeLeaveTimers[name]);
                inOfficeLeaveTimers[name] = null;
            }

            const delay = 9000 + Math.floor(Math.random() * 4000);
            console.log(`⏱️ Запущен таймер для ${name.toUpperCase()} (${delay}мс). Он уйдёт если планшет не будет поднят.`);

            inOfficeLeaveTimers[name] = setTimeout(() => {
                if (gameState.isGameOver) return;
                if (!aiState.inOffice[name]) return;

                if (gameState.isTabletMode || gameState.powerOutage.sceneActive) {
                    console.log(`⏳ ${name.toUpperCase()} всё ещё в офисе, но планшет поднят или идёт сцена. Таймер приостановлен.`);
                    inOfficeLeaveTimers[name] = setTimeout(() => {
                        startOfficeLeaveTimer(name);
                    }, 2000);
                    return;
                }

                aiState.inOffice[name] = false;
                aiState.positions[name] = name === 'bonnie' ? 'cam_2b' : 'cam_4b';
                aiState.cooldown[name] = 4 + Math.floor(Math.random() * 3);
                console.log(`🚶 ${name.toUpperCase()} покинул офис (планшет был опущен)`);
                updateAnimatronicIndicator(name);
                updateOfficeControls();
                updateDoorVisitors();
                inOfficeLeaveTimers[name] = null;
            }, delay);
        }

        function attackAnimatronic(name) {
            if (name === 'freddy') {
                if (gameState.rightDoorClosed) {
                    console.log('🚪 Фредди у правой двери, но она закрыта');
                    retreatAnimatronic('freddy');
                } else {
                    console.log('🐻 Фредди у правой двери — закройте дверь или не включайте свет!');
                    aiState.positions.freddy = 'office_right';
                    updateAnimatronicIndicator('freddy');
                    updateDoorVisitors();
                }
                return;
            }

            if (name === 'bonnie' || name === 'chica') {
                const door = name === 'bonnie' ? 'left' : 'right';
                const isClosed = door === 'left' ? gameState.leftDoorClosed : gameState.rightDoorClosed;

                if (isClosed) {
                    console.log(`🚪 ${name.toUpperCase()} стучится в ${door} дверь, но она закрыта`);
                    retreatAnimatronic(name);
                } else {
                    startOfficeEntryDelay(name);
                }
                return;
            }

            const door = aiState.positions[name] === 'office_left' ? 'left' : 'right';
            const isClosed = door === 'left' ? gameState.leftDoorClosed : gameState.rightDoorClosed;

            if (isClosed) {
                retreatAnimatronic(name);
            } else {
                const emojiMap = {
                    'freddy': '🐻',
                    'bonnie': '🐰',
                    'chica': '🐤'
                };
                showScreamer(emojiMap[name] || '💀', `${name.toUpperCase()} проник в офис!`);
            }
        }

        // ===== УПРАВЛЕНИЕ ПЛАНШЕТОМ =====
        function toggleTablet() {
            if (gameState.isBlackout || gameState.powerOutage.sceneActive) return;
            if (gameState.isGameOver) return;

            if (gameState.isTabletMode) {
                // ОПУСКАЕМ планшет
                if (aiState.inOffice.bonnie) {
                    console.log('💀 Бонни в офисе! Игрок опускает планшет -> СКРИМЕР!');
                    showScreamer('🐰', '🐰 Бонни в офисе!');
                    return;
                }
                if (aiState.inOffice.chica) {
                    console.log('💀 Чика в офисе! Игрок опускает планшет -> СКРИМЕР!');
                    showScreamer('🐤', '🐤 Чика в офисе!');
                    return;
                }

                gameState.isTabletMode = false;
                el.container.classList.remove('tablet-mode');
                el.container.classList.add('office-mode');
                el.tabletToggle.textContent = '📱 ПОДНЯТЬ ПЛАНШЕТ';
                el.tabletToggle.classList.add('office-mode-btn');
                el.tabletToggle.style.borderColor = '#44ff44';
                el.tabletToggle.style.color = '#44ff44';

                el.cameraBtns.forEach(btn => {
                    btn.classList.add('disabled');
                    btn.style.opacity = '0.3';
                    btn.style.cursor = 'not-allowed';
                });

                updateOfficeControls();
                updateUsage();
                console.log('📱 Планшет опущен');

                if (aiState.inOffice.bonnie && !inOfficeLeaveTimers.bonnie) {
                    startOfficeLeaveTimer('bonnie');
                }
                if (aiState.inOffice.chica && !inOfficeLeaveTimers.chica) {
                    startOfficeLeaveTimer('chica');
                }
                return;
            }

            // ПОДНИМАЕМ планшет
            gameState.isTabletMode = true;
            el.container.classList.remove('office-mode');
            el.container.classList.add('tablet-mode');
            el.tabletToggle.textContent = '📱 ОПУСТИТЬ ПЛАНШЕТ';
            el.tabletToggle.classList.remove('office-mode-btn');
            el.tabletToggle.style.borderColor = '#ffaa44';
            el.tabletToggle.style.color = '#ffaa44';

            el.cameraBtns.forEach(btn => {
                btn.classList.remove('disabled');
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            });

            // Панели управления скрываются автоматически через CSS
            // Дополнительно блокируем кнопки
            el.leftDoor.classList.add('disabled');
            el.rightDoor.classList.add('disabled');
            el.leftLight.classList.add('disabled');
            el.rightLight.classList.add('disabled');

            if (inOfficeLeaveTimers.bonnie) {
                clearTimeout(inOfficeLeaveTimers.bonnie);
                inOfficeLeaveTimers.bonnie = null;
                console.log('⏸️ Таймер Бонни приостановлен (планшет поднят)');
            }
            if (inOfficeLeaveTimers.chica) {
                clearTimeout(inOfficeLeaveTimers.chica);
                inOfficeLeaveTimers.chica = null;
                console.log('⏸️ Таймер Чики приостановлен (планшет поднят)');
            }

            switchCamera(gameState.currentCamera);
            console.log('📱 Планшет поднят');
        }

        // ============================================================
        //  ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
        // ============================================================

        function showDangerWarning() {
            const warning = el.dangerWarning;
            warning.classList.add('active');

            if (dangerTimeout) clearTimeout(dangerTimeout);
            dangerTimeout = setTimeout(() => {
                warning.classList.remove('active');
            }, 1500);
        }

        function showWarning(message) {
            document.querySelectorAll('.warning-message').forEach(el => el.remove());
            const warning = document.createElement('div');
            warning.className = 'warning-message';
            warning.textContent = message;
            document.body.appendChild(warning);
            setTimeout(() => {
                if (warning.parentNode) warning.remove();
            }, 2000);
        }

        function updateHallwayLights() {
            el.officeDoorLeft.classList.toggle('lit', gameState.leftLightOn);
            el.officeDoorRight.classList.toggle('lit', gameState.rightLightOn);
            el.leftLight.classList.toggle('active', gameState.leftLightOn);
            el.rightLight.classList.toggle('active', gameState.rightLightOn);
        }

        function updateOfficeControls() {
            const blockLeft = aiState.inOffice.bonnie;
            const blockRight = aiState.inOffice.chica;

            if (gameState.isTabletMode || gameState.powerOutage.sceneActive) {
                el.leftDoor.classList.add('disabled');
                el.rightDoor.classList.add('disabled');
                el.leftLight.classList.add('disabled');
                el.rightLight.classList.add('disabled');
                return;
            }

            el.leftDoor.classList.toggle('disabled', blockLeft);
            el.leftLight.classList.toggle('disabled', blockLeft);
            el.rightDoor.classList.toggle('disabled', blockRight);
            el.rightLight.classList.toggle('disabled', blockRight);
        }

        function updateDoorVisitors() {
            const leftVisitor = document.getElementById('leftHallwayVisitor');
            const rightVisitor = document.getElementById('rightHallwayVisitor');
            if (!leftVisitor || !rightVisitor) return;

            leftVisitor.classList.remove('visible');
            rightVisitor.classList.remove('visible');

            if (gameState.leftLightOn && aiState.positions.bonnie === 'office_left' && !aiState.inOffice.bonnie) {
                leftVisitor.textContent = '🐰';
                leftVisitor.classList.add('visible');
            }

            if (gameState.rightLightOn) {
                if (aiState.positions.freddy === 'office_right') {
                    rightVisitor.textContent = '🐻';
                    rightVisitor.classList.add('visible');
                } else if (aiState.positions.chica === 'office_right' && !aiState.inOffice.chica) {
                    rightVisitor.textContent = '🐤';
                    rightVisitor.classList.add('visible');
                }
            }
        }

        function updateAnimatronicIndicator(name) {
            const led = el.leds[name];
            if (!led) return;

            if (gameMode === 'hard') {
                led.className = 'led';
                led.style.background = '#1a1a1a';
                led.style.borderColor = '#2a2a2a';
                led.style.boxShadow = 'none';
                led.style.animation = 'none';
                return;
            }

            const pos = aiState.positions[name];
            const level = aiState.levels[name];
            const atDoor = aiState.atDoor[name];

            led.style.animation = 'none';

            if (name === 'foxy') {
                updateFoxyIndicator(led);
                return;
            }

            if (aiState.inOffice[name]) {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                led.style.animation = 'dangerPulse 0.5s infinite';
                return;
            }

            if (atDoor) {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                led.style.animation = 'dangerPulse 0.8s infinite';
                return;
            }

            if (level <= 0) {
                led.className = 'led';
                led.style.background = '#1a1a1a';
                led.style.borderColor = '#2a2a2a';
                led.style.boxShadow = 'none';
                return;
            }

            if (pos === 'cam_1a') {
                led.className = 'led';
                led.style.background = '#1a1a1a';
                led.style.borderColor = '#2a2a2a';
                led.style.boxShadow = 'none';
                return;
            }

            if (pos === 'cam_1b' || pos === 'dining_area' || pos === 'cam_5' || pos === 'backstage') {
                led.className = 'led green';
                led.style.background = '#44ff44';
                led.style.borderColor = '#44ff44';
                led.style.boxShadow = '0 0 15px rgba(68,255,68,0.3)';
                return;
            }

            if (pos === 'cam_7' || pos === 'restrooms') {
                led.className = 'led';
                led.style.background = '#88dd44';
                led.style.borderColor = '#88dd44';
                led.style.boxShadow = '0 0 15px rgba(136,221,68,0.3)';
                return;
            }

            if (pos === 'cam_6' || pos === 'kitchen' || pos === 'cam_3' || pos === 'closet') {
                led.className = 'led orange';
                led.style.background = '#ffaa44';
                led.style.borderColor = '#ffaa44';
                led.style.boxShadow = '0 0 15px rgba(255,170,68,0.3)';
                return;
            }

            if (pos === 'cam_2a' || pos === 'cam_4a' || pos === 'west_hall' || pos === 'east_hall') {
                led.className = 'led orange';
                led.style.background = '#ff8800';
                led.style.borderColor = '#ff8800';
                led.style.boxShadow = '0 0 15px rgba(255,136,0,0.3)';
                return;
            }

            if (pos === 'cam_2b' || pos === 'cam_4b' || pos === 'west_corner' || pos === 'east_corner') {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                return;
            }

            if (pos === 'office_left' || pos === 'office_right') {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                led.style.animation = 'dangerPulse 0.5s infinite';
                return;
            }

            led.className = 'led green';
            led.style.background = '#44ff44';
            led.style.borderColor = '#44ff44';
            led.style.boxShadow = '0 0 15px rgba(68,255,68,0.3)';
        }

        function updateFoxyIndicator(led) {
            const level = aiState.levels.foxy;
            const stage = aiState.foxyStage;

            if (level <= 0) {
                led.className = 'led';
                led.style.background = '#1a1a1a';
                led.style.borderColor = '#2a2a2a';
                led.style.boxShadow = 'none';
                led.style.animation = 'none';
                return;
            }

            if (stage === 1) {
                led.className = 'led green';
                led.style.background = '#44ff44';
                led.style.borderColor = '#44ff44';
                led.style.boxShadow = '0 0 15px rgba(68,255,68,0.3)';
                led.style.animation = 'none';
                return;
            }

            if (stage === 2) {
                led.className = 'led orange';
                led.style.background = '#ff8800';
                led.style.borderColor = '#ff8800';
                led.style.boxShadow = '0 0 15px rgba(255,136,0,0.3)';
                led.style.animation = 'none';
                return;
            }

            if (stage === 3) {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                led.style.animation = 'dangerPulse 1s infinite';
                return;
            }

            if (stage === 4) {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                led.style.animation = 'foxyPulse 0.5s infinite';
                return;
            }
        }

        function updateFoxy() {
            if (gameState.isGameOver || aiState.isFoxyRunning || gameState.powerOutage.sceneActive) return;
            if (gameState.night < 2) return;

            const watchingCove = gameState.isTabletMode && gameState.currentCamera === 'cam_1c';

            if (watchingCove) {
                if (aiState.foxyStage > 1) {
                    aiState.foxyStage = 1;
                    console.log('🦊 Фокси спрятался обратно за занавес (игрок смотрит на CAM 1C)');
                    updateAnimatronicIndicator('foxy');
                    if (gameState.currentCamera === 'cam_1c') {
                        switchCamera('cam_1c');
                    }
                }
                return;
            }

            const level = aiState.levels.foxy;
            const progressChance = level / 40;
            if (Math.random() < progressChance && aiState.foxyStage < 4) {
                aiState.foxyStage += 1;
                console.log(`🦊 Стадия Фокси: ${aiState.foxyStage}`);
                updateAnimatronicIndicator('foxy');
                if (gameState.currentCamera === 'cam_1c') {
                    switchCamera('cam_1c');
                }
            }

            if (gameState.isTabletMode && gameState.currentCamera === 'cam_2a' && aiState.foxyStage === 4) {
                foxyStartRun();
            }
        }

        function foxyStartRun() {
            if (aiState.isFoxyRunning) return;
            aiState.isFoxyRunning = true;
            showWarning('🦊 ФОКСИ СОРВАЛСЯ С МЕСТА!');
            console.log('🏃 Фокси бежит к офису!');

            foxyRunTimeout = setTimeout(() => {
                if (gameState.isGameOver || gameState.powerOutage.sceneActive) return;
                if (gameState.leftDoorClosed) {
                    showWarning('💥 ДВЕРЬ ВЫДЕРЖАЛА!');
                    aiState.foxyStage = 1;
                    aiState.isFoxyRunning = false;
                    aiState.positions.foxy = 'cam_1c';
                } else {
                    showScreamer('🦊', '🦊 Фокси добрался до офиса!');
                }
            }, 4000);
        }

        // ============================================================
        //  ЭНЕРГИЯ И ИНТЕРФЕЙС
        // ============================================================

        function calculatePowerDrain(actions) {
            let drain = 1;
            if (actions === 1) drain += 2;
            else if (actions === 2) drain += 5;
            else if (actions >= 3) drain += 10;
            return drain;
        }

        function updateUsage() {
            const bars = el.usageBars;
            if (!bars) return 0;

            let actions = 0;
            if (gameState.leftDoorClosed) actions++;
            if (gameState.rightDoorClosed) actions++;
            if (gameState.isTabletMode) actions++;
            if (gameState.isLightOn) actions++;

            let activeBars = 0;
            if (actions === 0) activeBars = 1;
            else if (actions === 1) activeBars = 2;
            else if (actions === 2) activeBars = 3;
            else if (actions >= 3) activeBars = 4;

            bars.forEach((bar, index) => {
                bar.classList.remove('active');
                if (index < activeBars) {
                    bar.classList.add('active');
                }
            });

            return actions;
        }

        function startPowerDrain() {
            powerDrainInterval = setInterval(() => {
                if (gameState.isGameOver || gameState.powerOutage.sceneActive) return;

                const activeActions = updateUsage();
                const drainPerHour = calculatePowerDrain(activeActions);
                const drainPerSecond = drainPerHour / (CONFIG.HOUR_DURATION / 1000);

                gameState.power = Math.max(0, gameState.power - drainPerSecond);
                updatePower();

                if (gameState.power <= 0 && !gameState.isBlackout) {
                    clearInterval(powerDrainInterval);
                    startPowerOutageScene();
                }
            }, 1000);
        }

        function updatePower() {
            const p = Math.round(gameState.power);
            el.powerDisplay.textContent = p + '%';
            el.powerBar.style.width = p + '%';
            const isLow = p < 20;
            const isMedium = p >= 20 && p < 50;
            el.powerDisplay.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
            el.powerBar.style.background = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
        }

        function updateTime() {
            const hours = 12 + gameState.time;
            const ampm = hours >= 12 ? 'AM' : 'PM';
            const displayHours = hours > 12 ? hours - 12 : hours;
            const displayMinutes = String(gameState.minute).padStart(2, '0');
            el.time.textContent = `${displayHours}:${displayMinutes} ${ampm}`;
        }

        function minuteTick() {
            if (gameState.isGameOver || gameState.powerOutage.sceneActive) return;
            const msPerGameMinute = CONFIG.HOUR_DURATION / 60;
            const elapsed = Date.now() - gameState.hourStartTimestamp;
            gameState.minute = Math.min(59, Math.floor(elapsed / msPerGameMinute));
            updateTime();
        }

        function switchCamera(camera) {
            if (!gameState.isTabletMode || gameState.powerOutage.sceneActive) {
                if (!gameState.powerOutage.sceneActive) showWarning('⛔ Поднимите планшет чтобы смотреть камеры!');
                return;
            }
            if (gameState.isGameOver) return;
            gameState.currentCamera = camera;
            el.cameraBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.camera === camera);
            });
            const names = {
                cam_1a: 'CAM 1A — СЦЕНА',
                cam_1b: 'CAM 1B — ЗАЛ',
                cam_1c: 'CAM 1C — КОВ',
                cam_2a: 'CAM 2A — ЗАП. ХОЛЛ',
                cam_2b: 'CAM 2B — УГ. ЗАП.',
                cam_3: 'CAM 3 — ЧУЛАН',
                cam_4a: 'CAM 4A — ВОСТ. ХОЛЛ',
                cam_4b: 'CAM 4B — УГ. ВОСТ.',
                cam_5: 'CAM 5 — ЗАД. СЦ.',
                cam_6: 'CAM 6 — КУХНЯ',
                cam_7: 'CAM 7 — ТУАЛЕТ'
            };
            el.cameraLabel.textContent = names[camera] || camera;

            const POSITION_LABELS = {
                cam_1a: 'stage',
                cam_1b: 'dining_area',
                cam_1c: 'cove',
                cam_2a: 'west_hall',
                cam_2b: 'west_corner',
                cam_3: 'closet',
                cam_4a: 'east_hall',
                cam_4b: 'east_corner',
                cam_5: 'backstage',
                cam_6: 'kitchen',
                cam_7: 'restrooms'
            };
            const toLabel = (camId) => POSITION_LABELS[camId] || camId;

            const query = new URLSearchParams({
                freddy: toLabel(aiState.positions.freddy),
                bonnie: toLabel(aiState.positions.bonnie),
                chica: toLabel(aiState.positions.chica),
                foxy: toLabel(aiState.positions.foxy),
                foxy_stage: aiState.foxyStage,
                foxy_running: aiState.isFoxyRunning ? '1' : '0',
                light_left: gameState.leftLightOn ? '1' : '0',
                light_right: gameState.rightLightOn ? '1' : '0'
            }).toString();

            fetch(`/camera/${camera}?${query}`)
                .then(response => response.text())
                .then(html => {
                    el.cameraImage.innerHTML = html;
                    if (camera === 'cam_2a' && aiState.foxyStage === 4 && !aiState.isFoxyRunning) {
                        foxyStartRun();
                    }
                })
                .catch(() => {
                    el.cameraImage.innerHTML = `
                        <div style="color: #333; font-size: 24px;">📹 ${names[camera] || camera}</div>
                        <div style="color: #444; font-size: 14px; margin-top: 10px;">Камера не активна</div>
                    `;
                });
            if (gameState.power > 0) {
                gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_CAMERA);
                updatePower();
            }
            updateUsage();
        }

        function toggleDoor(door) {
            if (gameState.isTabletMode || gameState.powerOutage.sceneActive) {
                if (!gameState.powerOutage.sceneActive) showWarning('⛔ Опустите планшет чтобы управлять дверями!');
                return;
            }
            if (gameState.isGameOver || gameState.isBlackout) return;

            if (door === 'left' && aiState.inOffice.bonnie) {
                showWarning('⛔ Бонни уже в офисе — дверь не поможет!');
                return;
            }
            if (door === 'right' && aiState.inOffice.chica) {
                showWarning('⛔ Чика уже в офисе — дверь не поможет!');
                return;
            }

            if (door === 'left') {
                gameState.leftDoorClosed = !gameState.leftDoorClosed;
                const status = el.leftDoor.querySelector('.status');
                status.textContent = gameState.leftDoorClosed ? 'ЗАКР.' : 'ОТКР.';
                el.leftDoor.classList.toggle('closed', gameState.leftDoorClosed);
                el.leftDoorLed.className = 'led ' + (gameState.leftDoorClosed ? 'red' : 'green');
                el.officeDoorLeft.classList.toggle('shut', gameState.leftDoorClosed);
                if (gameState.leftDoorClosed && gameState.power > 0) {
                    gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_DOOR);
                    updatePower();
                }
                if (gameState.leftDoorClosed) {
                    if (aiState.atDoor.bonnie) {
                        retreatAnimatronic('bonnie');
                    }
                    if (aiState.positions.bonnie === 'office_left' && !aiState.inOffice.bonnie) {
                        retreatAnimatronic('bonnie');
                    }
                }
            } else if (door === 'right') {
                gameState.rightDoorClosed = !gameState.rightDoorClosed;
                const status = el.rightDoor.querySelector('.status');
                status.textContent = gameState.rightDoorClosed ? 'ЗАКР.' : 'ОТКР.';
                el.rightDoor.classList.toggle('closed', gameState.rightDoorClosed);
                el.rightDoorLed.className = 'led ' + (gameState.rightDoorClosed ? 'red' : 'green');
                el.officeDoorRight.classList.toggle('shut', gameState.rightDoorClosed);
                if (gameState.rightDoorClosed && gameState.power > 0) {
                    gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_DOOR);
                    updatePower();
                }
                if (gameState.rightDoorClosed) {
                    if (aiState.atDoor.chica) {
                        retreatAnimatronic('chica');
                    }
                    if (aiState.positions.freddy === 'office_right') {
                        retreatAnimatronic('freddy');
                    }
                    if (aiState.positions.chica === 'office_right' && !aiState.inOffice.chica) {
                        retreatAnimatronic('chica');
                    }
                }
            }
            updateUsage();
        }

        function toggleLight(door) {
            if (gameState.isTabletMode || gameState.powerOutage.sceneActive) {
                if (!gameState.powerOutage.sceneActive) showWarning('⛔ Опустите планшет чтобы включить свет!');
                return;
            }
            if (gameState.isGameOver || gameState.isBlackout) return;
            if (door === 'left' && aiState.inOffice.bonnie) {
                showWarning('⛔ Бонни уже в офисе — свет не поможет!');
                return;
            }
            if (door === 'right' && aiState.inOffice.chica) {
                showWarning('⛔ Чика уже в офисе — свет не поможет!');
                return;
            }

            if (door === 'left') {
                gameState.leftLightOn = !gameState.leftLightOn;
            } else if (door === 'right') {
                gameState.rightLightOn = !gameState.rightLightOn;
            }
            gameState.isLightOn = gameState.leftLightOn || gameState.rightLightOn;

            if (door === 'right' && gameState.rightLightOn && aiState.positions.freddy === 'office_right') {
                gameState.rightLightOn = false;
                gameState.isLightOn = gameState.leftLightOn;
                updateHallwayLights();
                updateDoorVisitors();
                showScreamer('🐻', '🐻 Фредди добрался до офиса!');
                return;
            }

            if (gameState.power > 0) {
                gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_LIGHT);
                updatePower();
            }

            updateHallwayLights();
            updateDoorVisitors();
            console.log(`🔦 Свет на ${door} двери ${gameState[door + 'LightOn'] ? 'включён' : 'выключен'}`);
            updateUsage();
        }

        function advanceHour() {
            if (gameState.isGameOver || gameState.powerOutage.sceneActive) return;
            gameState.time += 1;
            gameState.minute = 0;
            gameState.hourStartTimestamp = Date.now();
            updateTime();
            if (gameState.time >= 6) {
                showVictoryScreen();
                return;
            }
            console.log(`⏰ ${gameState.time}:00 AM, Энергия: ${Math.round(gameState.power)}%`);
        }

        function completeNight(score, powerUsed) {
            fetch('{{ route('night.complete') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ score: score || 0, power_used: powerUsed || 0 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route('menu') }}';
                } else {
                    alert('❌ Ошибка сохранения прогресса!');
                    window.location.href = '{{ route('menu') }}';
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('❌ Ошибка соединения!');
                window.location.href = '{{ route('menu') }}';
            });
        }

        function openNote() {
            if (el.noteOverlay) {
                el.noteOverlay.classList.remove('hidden');
                el.noteOverlay.style.display = 'flex';
                if (el.noteBtn) el.noteBtn.classList.remove('pulse');
            }
        }

        function closeNote() {
            if (el.noteOverlay) {
                el.noteOverlay.classList.add('hidden');
                el.noteOverlay.style.display = 'none';
                if (el.noteBtn && !el.noteBtn.classList.contains('pulse')) {
                    el.noteBtn.classList.add('pulse');
                }
            }
        }

        // ============================================================
        //  ОБРАБОТЧИКИ СОБЫТИЙ
        // ============================================================

        el.cameraBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!gameState.isGameOver && gameState.isTabletMode && !gameState.powerOutage.sceneActive) {
                    switchCamera(btn.dataset.camera);
                }
            });
        });

        el.leftDoor.addEventListener('click', () => toggleDoor('left'));
        el.rightDoor.addEventListener('click', () => toggleDoor('right'));
        el.leftLight.addEventListener('click', () => toggleLight('left'));
        el.rightLight.addEventListener('click', () => toggleLight('right'));
        el.tabletToggle.addEventListener('click', toggleTablet);

        if (el.noteBtn) el.noteBtn.addEventListener('click', openNote);
        if (el.noteCloseBtn) el.noteCloseBtn.addEventListener('click', closeNote);

        el.victoryBtn.addEventListener('click', () => {
            const powerUsed = 100 - gameState.power;
            completeNight(0, Math.round(powerUsed));
        });

        el.gameoverBtn.addEventListener('click', () => {
            window.location.href = '{{ route('menu') }}';
        });

        // ============================================================
        //  ЗАПУСК
        // ============================================================

        el.container.classList.add('office-mode');
        el.container.classList.remove('tablet-mode');
        el.tabletToggle.textContent = '📱 ПОДНЯТЬ ПЛАНШЕТ';
        el.tabletToggle.classList.add('office-mode-btn');
        el.tabletToggle.style.borderColor = '#44ff44';
        el.tabletToggle.style.color = '#44ff44';

        el.leftDoor.classList.remove('disabled');
        el.rightDoor.classList.remove('disabled');
        el.leftLight.classList.remove('disabled');
        el.rightLight.classList.remove('disabled');

        el.cameraBtns.forEach(btn => {
            btn.classList.add('disabled');
            btn.style.opacity = '0.3';
            btn.style.cursor = 'not-allowed';
        });

        initAI(gameState.night);
        updateHallwayLights();
        updateOfficeControls();
        updateDoorVisitors();

        updateTime();
        updatePower();
        switchCamera('cam_1a');
        updateUsage();

        if (el.noteBtn) el.noteBtn.classList.add('pulse');

        gameLoopInterval = setInterval(advanceHour, CONFIG.HOUR_DURATION);
        aiStepInterval = setInterval(makeAIStep, 4500);
        aiBoostInterval = setInterval(checkAIBoosts, 5000);
        aiFoxyInterval = setInterval(updateFoxy, 3000);
        minuteLoopInterval = setInterval(minuteTick, 250);
        startPowerDrain();

        setInterval(() => {
            const overlay = document.querySelector('.static-overlay');
            if (overlay) overlay.style.opacity = 0.2 + Math.random() * 0.6;
        }, 1200);

        console.log('🎮 FNAF 1 - Ночь', gameState.night);
        console.log('========================================');
        console.log('✅ ИСПРАВЛЕНИЯ:');
        console.log('   🎯 Левая панель управления — слева от левой двери');
        console.log('   🎯 Правая панель управления — справа от правой двери');
        console.log('   📱 При поднятии планшета — панели управления скрываются');
        console.log('   📱 При опускании планшета — панели управления появляются');
        console.log('   ❌ Убрана подсказка "поднимите планшет"');
        console.log('========================================');
        console.log('⚡ СЦЕНА ОТКЛЮЧЕНИЯ ЭЛЕКТРИЧЕСТВА:');
        console.log(`   ⏱️ 30 сек — ожидание`);
        console.log(`   🎵 15 сек — Фредди играет музыку`);
        console.log(`   🌑 5 сек — полная тьма`);
        console.log(`   💀 Скример Фредди!`);
        console.log('========================================');
    </script>
</body>
</html>
