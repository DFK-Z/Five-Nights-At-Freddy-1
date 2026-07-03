<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ночь {{ $session->night }} - Five Nights At Freddy's</title>
    <style>
        /* ============================================================
           ВСЕ СТИЛИ
           ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #000;
            color: #fff;
            font-family: 'Courier New', monospace;
            height: 100vh;
            overflow: hidden;
            user-select: none;
        }

        .game-container {
            display: grid;
            grid-template-columns: 180px 1fr 180px;
            grid-template-rows: 50px 1fr 140px;
            height: 100vh;
            gap: 4px;
            padding: 8px;
            background: #0a0a0a;
            transition: all 0.5s;
        }

        /* ===== РЕЖИМ "ПЛАНШЕТ" ===== */
        .game-container.tablet-mode .left-panel,
        .game-container.tablet-mode .camera-view {
            display: flex;
        }

        .game-container.tablet-mode .office-view {
            display: none;
        }

        /* ===== РЕЖИМ "ОФИС" ===== */
        .game-container.office-mode .left-panel,
        .game-container.office-mode .camera-view {
            display: none;
        }

        .game-container.office-mode .office-view {
            display: flex;
        }

        /* ===== ВЕРХНЯЯ ПАНЕЛЬ ===== */
        .top-panel {
            grid-column: 1 / -1;
            grid-row: 1;
            background: #1a1a1a;
            border: 2px solid #2a2a2a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            font-size: 16px;
            z-index: 10;
        }

        .top-panel .time { color: #44ff44; }
        .top-panel .night { color: #ffaa44; }
        .top-panel .power { color: #ff4444; }

        /* ===== ЛЕВАЯ ПАНЕЛЬ ===== */
        .left-panel {
            grid-column: 1;
            grid-row: 2;
            background: #1a1a1a;
            border: 2px solid #2a2a2a;
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 8px;
            overflow-y: auto;
        }

        .left-panel::-webkit-scrollbar {
            width: 4px;
        }
        .left-panel::-webkit-scrollbar-thumb {
            background: #2a2a2a;
            border-radius: 2px;
        }

        .camera-btn {
            background: #0a0a0a;
            border: 1px solid #2a2a2a;
            color: #888;
            padding: 8px 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        .camera-btn:hover {
            background: #1a1a1a;
            border-color: #ff4444;
            color: #ff4444;
        }

        .camera-btn.active {
            background: #2a0a0a;
            border-color: #ff4444;
            color: #ff4444;
            box-shadow: inset 0 0 20px rgba(255,0,0,0.1);
        }

        .camera-btn.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* ===== ЦЕНТРАЛЬНОЕ ПОЛЕ ===== */
        .camera-view {
            grid-column: 2;
            grid-row: 2;
            background: #050505;
            border: 2px solid #2a2a2a;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #cameraImage {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 48px;
            color: #1a1a1a;
        }

        .camera-label {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.85);
            padding: 5px 25px;
            border: 1px solid #2a2a2a;
            color: #aaa;
            font-size: 14px;
            letter-spacing: 3px;
        }

        .static-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,0,0,0.08) 2px,
                rgba(0,0,0,0.08) 4px
            );
            pointer-events: none;
            animation: static 0.15s infinite;
        }

        @keyframes static {
            0% { opacity: 0.3; }
            50% { opacity: 0.9; }
            100% { opacity: 0.3; }
        }

        /* ===== ОФИС ===== */
        .office-view {
            grid-column: 2;
            grid-row: 2;
            background: #0a0a0a;
            border: 2px solid #2a2a2a;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .office-view .office-content {
            text-align: center;
            padding: 20px;
        }

        .office-view .office-title {
            color: #666;
            font-size: 14px;
            letter-spacing: 4px;
            margin-bottom: 20px;
        }

        .office-view .office-desc {
            color: #333;
            font-size: 12px;
            line-height: 2;
        }

        .office-view .office-desc .highlight {
            color: #ffaa44;
        }

        /* ===== ПРАВАЯ ПАНЕЛЬ ===== */
        .right-panel {
            grid-column: 3;
            grid-row: 2;
            background: #1a1a1a;
            border: 2px solid #2a2a2a;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 15px 10px;
            justify-content: center;
        }

        .door-control {
            text-align: center;
            background: #0a0a0a;
            padding: 10px;
            border: 1px solid #1a1a1a;
        }

        .door-control .label {
            color: #666;
            font-size: 10px;
            letter-spacing: 2px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .door-btn {
            background: #0a0a0a;
            border: 2px solid #2a2a2a;
            color: #888;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
            width: 100%;
            font-size: 13px;
            margin: 3px 0;
        }

        .door-btn:hover:not(.disabled) {
            background: #1a1a1a;
            border-color: #444;
        }

        .door-btn.closed {
            border-color: #ff4444;
            color: #ff4444;
            background: #1a0a0a;
        }

        .door-btn.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .door-btn .status {
            font-size: 10px;
            color: #666;
        }

        .door-btn.closed .status {
            color: #ff4444;
        }

        .light-btn {
            background: #0a0a0a;
            border: 1px solid #2a2a2a;
            color: #ffaa44;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
            width: 100%;
            font-size: 12px;
            margin: 2px 0;
        }

        .light-btn:hover:not(.disabled) {
            background: #1a1a0a;
            border-color: #ffaa44;
            box-shadow: 0 0 20px rgba(255,170,68,0.1);
        }

        .light-btn.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* ===== НИЖНЯЯ ПАНЕЛЬ ===== */
        .bottom-panel {
            grid-column: 1 / -1;
            grid-row: 3;
            background: #1a1a1a;
            border: 2px solid #2a2a2a;
            display: grid;
            grid-template-columns: 180px 1fr 180px;
            padding: 10px;
            gap: 10px;
        }

        .power-block {
            grid-column: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #0a0a0a;
            border: 1px solid #1a1a1a;
            padding: 10px;
        }

        .power-block .power-label {
            color: #666;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .power-block .power-value {
            font-size: 28px;
            font-weight: bold;
            color: #44ff44;
            margin: 5px 0;
        }

        .power-bar {
            width: 80%;
            height: 6px;
            background: #1a1a1a;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 5px;
        }

        .power-bar .fill {
            height: 100%;
            background: #44ff44;
            transition: width 0.5s;
            border-radius: 3px;
        }

        .indicators-block {
            grid-column: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            background: #0a0a0a;
            border: 1px solid #1a1a1a;
            padding: 10px;
        }

        .indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .indicator .name {
            color: #666;
            font-size: 9px;
            letter-spacing: 1px;
        }

        .indicator .led {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            transition: all 0.5s;
        }

        .indicator .led.green { background: #44ff44; border-color: #44ff44; box-shadow: 0 0 15px rgba(68,255,68,0.3); }
        .indicator .led.red { background: #ff4444; border-color: #ff4444; box-shadow: 0 0 20px rgba(255,68,68,0.4); }
        .indicator .led.orange { background: #ffaa44; border-color: #ffaa44; box-shadow: 0 0 15px rgba(255,170,68,0.3); }

        .door-status-block {
            grid-column: 3;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            background: #0a0a0a;
            border: 1px solid #1a1a1a;
            padding: 10px;
        }

        .door-status-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #888;
        }

        .door-status-item .led {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
        }

        .door-status-item .led.green { background: #44ff44; }
        .door-status-item .led.red { background: #ff4444; }

        /* ===== БЛОК USAGE ===== */
        .usage-block {
            grid-column: 3;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #0a0a0a;
            border: 1px solid #1a1a1a;
            padding: 5px 10px;
        }

        .usage-label {
            color: #666;
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .usage-bars {
            display: flex;
            gap: 3px;
            align-items: center;
        }

        .usage-bar {
            width: 20px;
            height: 8px;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            transition: all 0.3s;
            border-radius: 1px;
        }

        .usage-bar.green.active {
            background: #44ff44;
            border-color: #44ff44;
            box-shadow: 0 0 10px rgba(68,255,68,0.3);
        }

        .usage-bar.yellow.active {
            background: #ffaa44;
            border-color: #ffaa44;
            box-shadow: 0 0 10px rgba(255,170,68,0.3);
        }

        .usage-bar.red.active {
            background: #ff4444;
            border-color: #ff4444;
            box-shadow: 0 0 10px rgba(255,68,68,0.3);
        }

        /* ===== КНОПКИ ===== */
        .back-btn {
            position: fixed;
            top: 12px;
            right: 15px;
            background: rgba(0,0,0,0.9);
            color: #666;
            border: 1px solid #2a2a2a;
            padding: 6px 15px;
            cursor: pointer;
            z-index: 100;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .back-btn:hover {
            border-color: #ff4444;
            color: #ff4444;
        }

        .tablet-toggle-btn {
            position: fixed;
            bottom: 160px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.9);
            color: #ffaa44;
            border: 2px solid #2a2a2a;
            padding: 12px 30px;
            cursor: pointer;
            z-index: 100;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            letter-spacing: 3px;
            transition: all 0.3s;
        }

        .tablet-toggle-btn:hover {
            border-color: #ffaa44;
            background: #1a1a0a;
            box-shadow: 0 0 30px rgba(255,170,68,0.2);
        }

        .tablet-toggle-btn.office-mode-btn {
            border-color: #44ff44;
            color: #44ff44;
        }

        /* ===== ПРЕДУПРЕЖДЕНИЕ ===== */
        .warning-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.95);
            color: #ff4444;
            padding: 30px 40px;
            border: 2px solid #ff4444;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            z-index: 1000;
            text-align: center;
            animation: fadeInOut 2s ease-in-out forwards;
            box-shadow: 0 0 50px rgba(255,0,0,0.3);
            pointer-events: none;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
            15% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            85% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            100% { opacity: 0; transform: translate(-50%, -50%) scale(0.9); }
        }

        @keyframes flicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.97; }
        }

        .game-container {
            animation: flicker 3s infinite;
        }
    </style>
</head>
<body>
    <div class="game-container tablet-mode" id="gameContainer">
        <!-- Верхняя панель -->
        <div class="top-panel">
            <div class="time" id="gameTime">12:00 AM</div>
            <div class="night">НОЧЬ {{ $session->night }}</div>
            <div class="power">⚡ <span id="powerLevel">100</span>%</div>
        </div>

        <!-- Левая панель -->
        <div class="left-panel">
            <button class="camera-btn active" data-camera="cam_1a">1A СЦЕНА</button>
            <button class="camera-btn" data-camera="cam_1b">1B ЗАЛ</button>
            <button class="camera-btn" data-camera="cam_1c">1C КОВ</button>
            <button class="camera-btn" data-camera="cam_2a">2A ЗАП. ХОЛЛ</button>
            <button class="camera-btn" data-camera="cam_2b">2B УГ. ЗАП.</button>
            <button class="camera-btn" data-camera="cam_3">3 ЧУЛАН</button>
            <button class="camera-btn" data-camera="cam_4a">4A ВОСТ. ХОЛЛ</button>
            <button class="camera-btn" data-camera="cam_4b">4B УГ. ВОСТ.</button>
            <button class="camera-btn" data-camera="cam_5">5 ЗАД. СЦ.</button>
            <button class="camera-btn" data-camera="cam_6">6 КУХНЯ</button>
            <button class="camera-btn" data-camera="cam_7">7 ТУАЛЕТ</button>
        </div>

        <!-- Центр -->
        <div class="camera-view" id="cameraView">
            <div id="cameraImage">
                <!-- Сюда через AJAX подгружаются файлы из cameras/ -->
            </div>
            <div class="static-overlay"></div>
            <div class="camera-label" id="cameraLabel">CAM 1A — СЦЕНА</div>
        </div>

        <!-- Офис -->
        <div class="office-view" id="officeView">
            <div class="office-content">
                <div class="office-title">🏢 ОФИС</div>
                <div class="office-desc">
                    <div>👁️ Вы в кабинете охраны</div>
                    <div>🚪 Слева и справа — двери</div>
                    <div>📹 <span class="highlight">Нажмите кнопку</span> чтобы поднять планшет</div>
                </div>
            </div>
        </div>

        <!-- Правая панель -->
        <div class="right-panel">
            <div class="door-control">
                <div class="label">ЛЕВАЯ ДВЕРЬ</div>
                <button class="door-btn" id="leftDoor">
                    🚪 <span class="status">ОТКРЫТА</span>
                </button>
                <button class="light-btn" id="leftLight">💡 СВЕТ</button>
            </div>
            <div class="door-control">
                <div class="label">ПРАВАЯ ДВЕРЬ</div>
                <button class="door-btn" id="rightDoor">
                    🚪 <span class="status">ОТКРЫТА</span>
                </button>
                <button class="light-btn" id="rightLight">💡 СВЕТ</button>
            </div>
        </div>

        <!-- Нижняя панель -->
        <div class="bottom-panel">
            <div class="power-block">
                <div class="power-label">⚡ ЭНЕРГИЯ</div>
                <div class="power-value" id="powerDisplay">100%</div>
                <div class="power-bar">
                    <div class="fill" id="powerBar" style="width: 100%"></div>
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
    </div>

    <a href="{{ route('menu') }}" class="back-btn">✕ В МЕНЮ</a>
    <button class="tablet-toggle-btn" id="tabletToggle">📱 ОПУСТИТЬ ПЛАНШЕТ</button>

    <script>
        // ============================================================
        //  ВСЯ ИГРОВАЯ ЛОГИКА (ОДИН ФАЙЛ)
        // ============================================================

        const CONFIG = {
            HOUR_DURATION: 90000,
            POWER_DRAIN_PER_HOUR: 8,
            POWER_DRAIN_CAMERA: 0.5,
            POWER_DRAIN_DOOR: 2,
            POWER_DRAIN_LIGHT: 1
        };

        const gameState = {
            night: {{ $session->night }},
            time: 0,
            power: 100,
            isGameOver: false,
            currentCamera: 'cam_1a',
            leftDoorClosed: false,
            rightDoorClosed: false,
            isTabletMode: true,
            isLightOn: false
        };

        // ===== DOM-ЭЛЕМЕНТЫ =====
        const el = {
            container: document.getElementById('gameContainer'),
            time: document.getElementById('gameTime'),
            powerLevel: document.getElementById('powerLevel'),
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
            cameraBtns: document.querySelectorAll('.camera-btn'),
            tabletToggle: document.getElementById('tabletToggle'),
            usageBars: document.querySelectorAll('.usage-bar'),
            leds: {
                freddy: document.getElementById('freddyLed'),
                bonnie: document.getElementById('bonnieLed'),
                chica: document.getElementById('chicaLed'),
                foxy: document.getElementById('foxyLed')
            }
        };

        let gameLoopInterval = null;

        // ===== ФУНКЦИЯ ПРЕДУПРЕЖДЕНИЙ =====
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

        // ===== ОБНОВЛЕНИЕ ВРЕМЕНИ =====
        function updateTime() {
            const hours = 12 + gameState.time;
            const ampm = hours >= 12 ? 'AM' : 'PM';
            const displayHours = hours > 12 ? hours - 12 : hours;
            el.time.textContent = `${displayHours}:00 ${ampm}`;
        }

        // ===== ОБНОВЛЕНИЕ ЭНЕРГИИ =====
        function updatePower() {
            const p = Math.round(gameState.power);
            el.powerLevel.textContent = p;
            el.powerDisplay.textContent = p + '%';
            el.powerBar.style.width = p + '%';

            const isLow = p < 20;
            const isMedium = p >= 20 && p < 50;
            el.powerLevel.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
            el.powerDisplay.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
            el.powerBar.style.background = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
        }

        // ===== ОБНОВЛЕНИЕ USAGE =====
        function updateUsage() {
            const bars = el.usageBars;
            if (!bars) return;

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
        }

        // ===== ПЕРЕКЛЮЧЕНИЕ КАМЕР =====
        function switchCamera(camera) {
            if (!gameState.isTabletMode) {
                showWarning('⛔ Поднимите планшет чтобы смотреть камеры!');
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

            fetch(`/camera/${camera}`)
                .then(response => response.text())
                .then(html => {
                    el.cameraImage.innerHTML = html;
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

        // ===== УПРАВЛЕНИЕ ДВЕРЯМИ =====
        function toggleDoor(door) {
            if (gameState.isTabletMode) {
                showWarning('⛔ Опустите планшет чтобы управлять дверями!');
                return;
            }
            if (gameState.isGameOver) return;

            if (door === 'left') {
                gameState.leftDoorClosed = !gameState.leftDoorClosed;
                const status = el.leftDoor.querySelector('.status');
                status.textContent = gameState.leftDoorClosed ? 'ЗАКРЫТА' : 'ОТКРЫТА';
                el.leftDoor.classList.toggle('closed', gameState.leftDoorClosed);
                el.leftDoorLed.className = 'led ' + (gameState.leftDoorClosed ? 'red' : 'green');
                if (gameState.leftDoorClosed && gameState.power > 0) {
                    gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_DOOR);
                    updatePower();
                }
            } else if (door === 'right') {
                gameState.rightDoorClosed = !gameState.rightDoorClosed;
                const status = el.rightDoor.querySelector('.status');
                status.textContent = gameState.rightDoorClosed ? 'ЗАКРЫТА' : 'ОТКРЫТА';
                el.rightDoor.classList.toggle('closed', gameState.rightDoorClosed);
                el.rightDoorLed.className = 'led ' + (gameState.rightDoorClosed ? 'red' : 'green');
                if (gameState.rightDoorClosed && gameState.power > 0) {
                    gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_DOOR);
                    updatePower();
                }
            }
            updateUsage();
        }

        // ===== УПРАВЛЕНИЕ СВЕТОМ =====
        function toggleLight(door) {
            if (gameState.isTabletMode) {
                showWarning('⛔ Опустите планшет чтобы включить свет!');
                return;
            }
            if (gameState.isGameOver) return;

            gameState.isLightOn = !gameState.isLightOn;

            if (gameState.power > 0) {
                gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_LIGHT);
                updatePower();
            }

            const view = document.querySelector('.camera-view');
            view.style.boxShadow = '0 0 60px rgba(255,255,200,0.4)';
            setTimeout(() => view.style.boxShadow = 'none', 400);

            console.log(`🔦 Свет на ${door} двери ${gameState.isLightOn ? 'включён' : 'выключен'}`);
            updateUsage();
        }

        // ===== ПЕРЕКЛЮЧЕНИЕ ПЛАНШЕТА =====
        function toggleTablet() {
            gameState.isTabletMode = !gameState.isTabletMode;

            if (gameState.isTabletMode) {
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

                el.leftDoor.classList.add('disabled');
                el.rightDoor.classList.add('disabled');
                el.leftLight.classList.add('disabled');
                el.rightLight.classList.add('disabled');

                switchCamera(gameState.currentCamera);
            } else {
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

                el.leftDoor.classList.remove('disabled');
                el.rightDoor.classList.remove('disabled');
                el.leftLight.classList.remove('disabled');
                el.rightLight.classList.remove('disabled');
            }
            updateUsage();
        }

        // ===== GAME OVER =====
        function gameOver(reason) {
            if (gameState.isGameOver) return;
            gameState.isGameOver = true;
            clearInterval(gameLoopInterval);
            alert(`💀 ${reason}\nВы прожили до ${el.time.textContent}`);
            window.location.href = '{{ route('menu') }}';
        }

        // ===== ИГРОВОЙ ЦИКЛ =====
        function advanceHour() {
            if (gameState.isGameOver) return;

            gameState.time += 1;
            updateTime();

            if (gameState.time >= 6) {
                clearInterval(gameLoopInterval);
                setTimeout(() => {
                    alert(`🎉 Ночь ${gameState.night} пройдена!`);
                    window.location.href = '{{ route('menu') }}';
                }, 500);
                return;
            }

            gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_PER_HOUR);
            updatePower();

            if (gameState.power <= 0) {
                clearInterval(gameLoopInterval);
                setTimeout(() => {
                    gameOver('⚡ Энергия закончилась!');
                }, 500);
                return;
            }

            // Мигание индикаторов
            const names = ['freddy', 'bonnie', 'chica', 'foxy'];
            names.forEach(name => {
                if (Math.random() < 0.08) {
                    const colors = ['orange', 'red', 'green'];
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    el.leds[name].className = 'led ' + color;
                    setTimeout(() => {
                        if (el.leds[name]) el.leds[name].className = 'led';
                    }, 2000);
                }
            });

            console.log(`⏰ ${gameState.time}:00 AM, Энергия: ${Math.round(gameState.power)}%`);
        }

        // ===== ОБРАБОТЧИКИ СОБЫТИЙ =====
        el.cameraBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!gameState.isGameOver && gameState.isTabletMode) {
                    switchCamera(btn.dataset.camera);
                }
            });
        });

        el.leftDoor.addEventListener('click', () => toggleDoor('left'));
        el.rightDoor.addEventListener('click', () => toggleDoor('right'));
        el.leftLight.addEventListener('click', () => toggleLight('left'));
        el.rightLight.addEventListener('click', () => toggleLight('right'));
        el.tabletToggle.addEventListener('click', toggleTablet);

        // ===== ЗАПУСК =====
        el.container.classList.add('tablet-mode');
        el.container.classList.remove('office-mode');
        el.tabletToggle.textContent = '📱 ОПУСТИТЬ ПЛАНШЕТ';
        el.tabletToggle.style.borderColor = '#ffaa44';
        el.tabletToggle.style.color = '#ffaa44';

        el.leftDoor.classList.add('disabled');
        el.rightDoor.classList.add('disabled');
        el.leftLight.classList.add('disabled');
        el.rightLight.classList.add('disabled');

        updateTime();
        updatePower();
        switchCamera('cam_1a');
        updateUsage();

        gameLoopInterval = setInterval(advanceHour, CONFIG.HOUR_DURATION);

        setInterval(() => {
            const overlay = document.querySelector('.static-overlay');
            if (overlay) {
                overlay.style.opacity = 0.2 + Math.random() * 0.6;
            }
        }, 1200);

        console.log('🎮 FNAF 1 - Ночь', gameState.night);
        console.log('📹 Загружено 11 камер');
        console.log('⚡ Система USAGE активирована');
    </script>
</body>
</html>
