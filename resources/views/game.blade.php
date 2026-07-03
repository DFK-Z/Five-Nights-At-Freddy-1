<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ночь {{ $session->night }} - Five Nights At Freddy's</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
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
            <div class="office-lamp"></div>

            <div class="cobweb tl"></div>
            <div class="cobweb tr"></div>

            <div class="office-wall">
                <div class="office-poster small-left">рисунки детей</div>
                <div class="office-poster main">ПРАЗДНИК!</div>
                <div class="office-poster small-right">расписание</div>
            </div>

            <div class="office-doorframe left" id="officeDoorLeft">
                <div class="office-door-panel"></div>
            </div>
            <div class="office-doorframe right" id="officeDoorRight">
                <div class="office-door-panel"></div>
            </div>

            <div class="office-floor"></div>

            <div class="office-desk">
                <div class="desk-monitor">MON</div>
                <div class="desk-fan"></div>
                <div class="desk-tally">
                    <div>НОЧЬ {{ $session->night }}</div>
                    <div>★ ★ ★</div>
                </div>
            </div>

            <div class="office-hint">
                🚪 Двери и свет — кнопками справа &nbsp;•&nbsp;
                <span class="highlight">поднимите планшет</span>, чтобы смотреть камеры
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
            POWER_DRAIN_LIGHT: 1,
            // ===== ФОКСИ =====
            FOXY_CHECK_INTERVAL: 5000,   // как часто "проверяется" стадия Фокси
            FOXY_ADVANCE_CHANCE: 0.18,   // шанс продвинуться на стадию, если не смотрят на CAM 1C
            FOXY_RUN_TIME: 4000          // сколько есть времени закрыть левую дверь, когда он побежал
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
            isTabletMode: true,
            isLightOn: false,
            // ===== ПОЗИЦИИ АНИМАТРОНИКОВ =====
            // Источник правды теперь тут, на клиенте — при каждом запросе камеры
            // эти значения уходят на сервер через query и сохраняются в сессии.
            positions: {
                freddy: 'stage',
                bonnie: 'stage',
                chica: 'stage',
                foxy: 'cove'
            },
            // ===== СОСТОЯНИЕ ФОКСИ =====
            foxy: {
                stage: 1,       // 1-4
                running: false  // true, когда он уже сорвался и бежит к офису
            }
        };

        let foxyLoopInterval = null;
        let foxyRunTimeout = null;
        let minuteLoopInterval = null;

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
            officeDoorLeft: document.getElementById('officeDoorLeft'),
            officeDoorRight: document.getElementById('officeDoorRight'),
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
            const displayMinutes = String(gameState.minute).padStart(2, '0');
            el.time.textContent = `${displayHours}:${displayMinutes} ${ampm}`;
        }

        // ===== ТИК МИНУТ =====
        // 1 игровая минута = HOUR_DURATION / 60 мс (при 90000мс/час это 1500мс на минуту)
        function minuteTick() {
            if (gameState.isGameOver) return;
            const msPerGameMinute = CONFIG.HOUR_DURATION / 60;
            const elapsed = Date.now() - gameState.hourStartTimestamp;
            gameState.minute = Math.min(59, Math.floor(elapsed / msPerGameMinute));
            updateTime();
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

            // Передаём текущие позиции аниматроников и стадию Фокси на сервер,
            // чтобы вьюха камеры рисовала актуальную картину, а не дефолт из сессии
            const query = new URLSearchParams({
                ...gameState.positions,
                foxy_stage: gameState.foxy.stage,
                foxy_running: gameState.foxy.running ? '1' : '0'
            }).toString();

            fetch(`/camera/${camera}?${query}`)
                .then(response => response.text())
                .then(html => {
                    el.cameraImage.innerHTML = html;

                    // Фокси замечен на CAM 2A в 4-й стадии — сорвался и побежал к офису
                    if (camera === 'cam_2a' && gameState.foxy.stage === 4 && !gameState.foxy.running) {
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
                el.officeDoorLeft.classList.toggle('shut', gameState.leftDoorClosed);
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
                el.officeDoorRight.classList.toggle('shut', gameState.rightDoorClosed);
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
            clearInterval(foxyLoopInterval);
            clearInterval(minuteLoopInterval);
            clearTimeout(foxyRunTimeout);
            alert(`💀 ${reason}\nВы прожили до ${el.time.textContent}`);
            window.location.href = '{{ route('menu') }}';
        }

        // ===== ЛОГИКА ФОКСИ =====
        // По канону у Фокси AI = 0 на первую ночь — он вообще не двигается,
        // спит за закрытым занавесом всю ночь. Активничать начинает с ночи 2.
        // Каждые FOXY_CHECK_INTERVAL мс: если смотрим на CAM 1C — Фокси успокаивается
        // (стадия сбрасывается на 1), иначе — есть шанс продвинуться дальше.
        function foxyTick() {
            if (gameState.isGameOver || gameState.foxy.running) return;
            if (gameState.night < 2) return; // ночь 1 — Фокси неактивен

            const watchingCove = gameState.isTabletMode && gameState.currentCamera === 'cam_1c';

            if (watchingCove) {
                if (gameState.foxy.stage !== 1) {
                    gameState.foxy.stage = 1;
                    console.log('🦊 Фокси спрятался обратно за занавес');
                }
            } else if (gameState.foxy.stage < 4) {
                if (Math.random() < CONFIG.FOXY_ADVANCE_CHANCE) {
                    gameState.foxy.stage += 1;
                    console.log(`🦊 Стадия Фокси: ${gameState.foxy.stage}`);
                }
            }

            // Если смотрим прямо сейчас на CAM 1C или CAM 2A — перерисовываем,
            // чтобы изменение стадии было видно без переключения камер
            if (gameState.isTabletMode && (gameState.currentCamera === 'cam_1c' || gameState.currentCamera === 'cam_2a')) {
                switchCamera(gameState.currentCamera);
            }
        }

        // Фокси сорвался с места на CAM 2A — гонка с левой дверью
        function foxyStartRun() {
            gameState.foxy.running = true;
            showWarning('🦊 ФОКСИ СОРВАЛСЯ С МЕСТА!');
            console.log('🏃 Фокси бежит к офису!');

            foxyRunTimeout = setTimeout(() => {
                if (gameState.isGameOver) return;

                if (gameState.leftDoorClosed) {
                    // Успели закрыть дверь — Фокси стучится и уходит обратно в бухту
                    showWarning('💥 ДВЕРЬ ВЫДЕРЖАЛА!');
                    setTimeout(() => {
                        gameState.foxy.stage = 1;
                        gameState.foxy.running = false;
                        if (gameState.isTabletMode && gameState.currentCamera === 'cam_1c') {
                            switchCamera('cam_1c');
                        }
                    }, 1500);
                } else {
                    gameOver('🦊 Фокси добрался до офиса!');
                }
            }, CONFIG.FOXY_RUN_TIME);
        }

        // ===== ДВИЖЕНИЕ АНИМАТРОНИКОВ (НОЧЬ 1) =====
        // На первой ночи Бонни и Чика уходят со сцены в середине 2-го часа (~2:30 AM)
        // и направляются в столовую (CAM 1B) — первая точка на их маршруте к офису.
        function moveNight1Animatronics() {
            if (gameState.isGameOver) return;

            gameState.positions.bonnie = 'dining_area';
            gameState.positions.chica = 'dining_area';

            console.log('👀 Бонни и Чика покинули сцену и пришли в столовую...');

            // Перерисовываем текущую камеру, если смотрим на 1A (сцена опустела)
            // или 1B (туда они как раз пришли)
            if (gameState.isTabletMode && (gameState.currentCamera === 'cam_1a' || gameState.currentCamera === 'cam_1b')) {
                switchCamera(gameState.currentCamera);
            }
        }

        // ===== ИГРОВОЙ ЦИКЛ =====
        function advanceHour() {
            if (gameState.isGameOver) return;

            gameState.time += 1;
            gameState.minute = 0;
            gameState.hourStartTimestamp = Date.now();
            updateTime();

            // Ровно в начале 2-го часа планируем событие на его середину
            if (gameState.night === 1 && gameState.time === 2) {
                setTimeout(moveNight1Animatronics, CONFIG.HOUR_DURATION / 2);
            }

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
        foxyLoopInterval = setInterval(foxyTick, CONFIG.FOXY_CHECK_INTERVAL);
        minuteLoopInterval = setInterval(minuteTick, 250);

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
