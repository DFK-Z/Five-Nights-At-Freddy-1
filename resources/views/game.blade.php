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
        }

        /* Верхняя панель */
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
        }

        .top-panel .time { color: #44ff44; }
        .top-panel .night { color: #ffaa44; }
        .top-panel .power { color: #ff4444; }

        /* Левая панель (камеры) */
        .left-panel {
            grid-column: 1;
            grid-row: 2;
            background: #1a1a1a;
            border: 2px solid #2a2a2a;
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 8px;
        }

        .camera-btn {
            background: #0a0a0a;
            border: 1px solid #2a2a2a;
            color: #888;
            padding: 10px 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
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

        /* Центральное поле (камера) */
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

        /* Стили для контента камер (внутри #cameraImage) */
        .camera-content {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0a0a0a;
        }

        .camera-scene {
            text-align: center;
            padding: 20px;
            background: rgba(0,0,0,0.5);
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            min-width: 200px;
        }

        .camera-scene h3 {
            color: #ffaa44;
            font-size: 18px;
            margin-bottom: 15px;
            letter-spacing: 2px;
        }

        .animatronics {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 15px 0;
        }

        .animatronic {
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            animation: pulse 2s infinite;
        }

        .animatronic.freddy {
            background: #8B4513;
            color: #ffd700;
            border: 2px solid #ffd700;
        }

        .animatronic.bonnie {
            background: #4B0082;
            color: #9B59B6;
            border: 2px solid #9B59B6;
        }

        .animatronic.chica {
            background: #FFD700;
            color: #8B4513;
            border: 2px solid #8B4513;
        }

        .animatronic.foxy {
            background: #8B0000;
            color: #ff4444;
            border: 2px solid #ff4444;
        }

        .curtain {
            color: #666;
            font-size: 16px;
            padding: 20px;
            background: #1a1a1a;
            border: 1px solid #333;
        }

        .light-effect {
            margin-top: 10px;
            color: #ffaa44;
            font-size: 14px;
            animation: flicker-light 0.5s infinite;
        }

        .camera-hint {
            margin-top: 15px;
            color: #444;
            font-size: 11px;
            letter-spacing: 1px;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes flicker-light {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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

        /* Правая панель (двери) */
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

        .door-btn:hover {
            background: #1a1a1a;
            border-color: #444;
        }

        .door-btn.closed {
            border-color: #ff4444;
            color: #ff4444;
            background: #1a0a0a;
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

        .light-btn:hover {
            background: #1a1a0a;
            border-color: #ffaa44;
            box-shadow: 0 0 20px rgba(255,170,68,0.1);
        }

        /* Нижняя панель */
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
    <div class="game-container">
        <!-- Верхняя панель -->
        <div class="top-panel">
            <div class="time" id="gameTime">12:00 AM</div>
            <div class="night">НОЧЬ {{ $session->night }}</div>
            <div class="power">⚡ <span id="powerLevel">100</span>%</div>
        </div>

        <!-- Левая панель -->
        <div class="left-panel">
            <button class="camera-btn active" data-camera="show">СЦЕНА</button>
            <button class="camera-btn" data-camera="backstage">ЗАДНЯЯ СЦЕНА</button>
            <button class="camera-btn" data-camera="west">ЗАПАДНЫЙ КОР.</button>
            <button class="camera-btn" data-camera="east">ВОСТОЧНЫЙ КОР.</button>
            <button class="camera-btn" data-camera="restrooms">ТУАЛЕТЫ</button>
        </div>

        <!-- Центр -->
        <div class="camera-view" id="cameraView">
            <div id="cameraImage">
                <!-- Сюда будет загружаться контент камеры -->
                <div class="camera-content">
                    <div class="camera-scene">
                        <h3>📹 СЦЕНА</h3>
                        <div class="animatronics">
                            <div class="animatronic freddy">🐻 ФРЕДДИ</div>
                            <div class="animatronic bonnie">🐰 БОННИ</div>
                            <div class="animatronic chica">🐤 ЧИКА</div>
                        </div>
                        <div class="camera-hint">Нажмите на камеру для увеличения</div>
                    </div>
                </div>
            </div>
            <div class="static-overlay"></div>
            <div class="camera-label" id="cameraLabel">СЦЕНА</div>
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
        </div>
    </div>

    <a href="{{ route('menu') }}" class="back-btn">✕ В МЕНЮ</a>

    <script>
        // ============================================================
        //  ПОЛНАЯ ИГРОВАЯ ЛОГИКА
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
            currentCamera: 'show',
            leftDoorClosed: false,
            rightDoorClosed: false,
            animatronics: {
                freddy: { position: 'stage', isActive: true },
                bonnie: { position: 'backstage', isActive: true },
                chica: { position: 'stage', isActive: true },
                foxy: { position: 'cove', isActive: true }
            }
        };

        const el = {
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
            leds: {
                freddy: document.getElementById('freddyLed'),
                bonnie: document.getElementById('bonnieLed'),
                chica: document.getElementById('chicaLed'),
                foxy: document.getElementById('foxyLed')
            }
        };

        let gameLoopInterval = null;

        // ========== ФУНКЦИИ ==========

        function updateTime() {
            const hours = 12 + gameState.time;
            const ampm = hours >= 12 ? 'AM' : 'PM';
            const displayHours = hours > 12 ? hours - 12 : hours;
            el.time.textContent = `${displayHours}:00 ${ampm}`;
        }

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

        function switchCamera(camera) {
            if (gameState.isGameOver) return;

            gameState.currentCamera = camera;

            el.cameraBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.camera === camera);
            });

            const names = {
                show: 'СЦЕНА',
                backstage: 'ЗАДНЯЯ СЦЕНА',
                west: 'ЗАПАДНЫЙ КОР.',
                east: 'ВОСТОЧНЫЙ КОР.',
                restrooms: 'ТУАЛЕТЫ'
            };

            el.cameraLabel.textContent = names[camera] || camera;

            // ===== ЗАГРУЖАЕМ КАРТИНКУ КАМЕРЫ ЧЕРЕЗ AJAX =====
            fetch(`/camera/${camera}`)
                .then(response => response.text())
                .then(html => {
                    el.cameraImage.innerHTML = html;
                })
                .catch(() => {
                    // Если не загрузилось — показываем заглушку
                    el.cameraImage.innerHTML = `
                        <div class="camera-content">
                            <div class="camera-scene">
                                <h3>📹 ${names[camera] || camera}</h3>
                                <div style="color: #333; font-size: 14px;">Камера не активна</div>
                                <div class="camera-hint">⚡ Энергия: ${Math.round(gameState.power)}%</div>
                            </div>
                        </div>
                    `;
                });

            // Расход энергии
            if (gameState.power > 0) {
                gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_CAMERA);
                updatePower();
            }
        }

        function toggleDoor(door) {
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
        }

        function toggleLight(door) {
            if (gameState.isGameOver) return;

            if (gameState.power > 0) {
                gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_LIGHT);
                updatePower();
            }

            const view = document.querySelector('.camera-view');
            view.style.boxShadow = '0 0 60px rgba(255,255,200,0.4)';
            setTimeout(() => view.style.boxShadow = 'none', 400);

            console.log(`🔦 Свет на ${door} двери`);

            // Обновляем текущую камеру, чтобы показать свет
            switchCamera(gameState.currentCamera);
        }

        function moveAnimatronics() {
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
        }

        function gameOver(reason) {
            if (gameState.isGameOver) return;
            gameState.isGameOver = true;

            clearInterval(gameLoopInterval);

            alert(`💀 ${reason}\nВы прожили до ${el.time.textContent}`);
            window.location.href = '{{ route('menu') }}';
        }

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

            moveAnimatronics();
            console.log(`⏰ ${gameState.time}:00 AM, Энергия: ${Math.round(gameState.power)}%`);
        }

        // ========== ОБРАБОТЧИКИ СОБЫТИЙ ==========

        el.cameraBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!gameState.isGameOver) switchCamera(btn.dataset.camera);
            });
        });

        el.leftDoor.addEventListener('click', () => toggleDoor('left'));
        el.rightDoor.addEventListener('click', () => toggleDoor('right'));
        el.leftLight.addEventListener('click', () => toggleLight('left'));
        el.rightLight.addEventListener('click', () => toggleLight('right'));

        // ========== ЗАПУСК ИГРЫ ==========

        updateTime();
        updatePower();
        switchCamera('show');

        gameLoopInterval = setInterval(advanceHour, CONFIG.HOUR_DURATION);

        setInterval(() => {
            const overlay = document.querySelector('.static-overlay');
            if (overlay) {
                overlay.style.opacity = 0.2 + Math.random() * 0.6;
            }
        }, 1200);

        console.log('🎮 FNAF 1 - Ночь', gameState.night);
        console.log('⏰ Длительность часа:', CONFIG.HOUR_DURATION / 1000, 'сек');
    </script>
</body>
</html>
