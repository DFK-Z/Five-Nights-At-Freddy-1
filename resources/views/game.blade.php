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

            <!-- ===== КНОПКА ЗАПИСКИ ===== -->
            <button class="note-btn" id="noteBtn">📋 ЗАПИСКА</button>

            <!-- ===== ОКНО ЗАПИСКИ ===== -->
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

        // ============================================================
        //  НОВАЯ СИСТЕМА ИИ (FNAF 1)
        // ============================================================

        // Базовые уровни по ночам
        const AI_LEVELS = {
            1: { freddy: 0, bonnie: 3, chica: 3, foxy: 0 },
            2: { freddy: 0, bonnie: 5, chica: 5, foxy: 0 },
            3: { freddy: 1, bonnie: 6, chica: 6, foxy: 1 },
            4: { freddy: 2, bonnie: 8, chica: 8, foxy: 2 },
            5: { freddy: 3, bonnie: 9, chica: 9, foxy: 3 },
            6: { freddy: 6, bonnie: 15, chica: 15, foxy: 6 },
            7: { freddy: 20, bonnie: 20, chica: 20, foxy: 20 }
        };

        // Повышения уровней по времени
        const AI_BOOSTS = {
            2: { bonnie: 1 },
            3: { bonnie: 1, chica: 1, foxy: 1 },
            4: { bonnie: 1, chica: 1, foxy: 1 }
        };

        // Состояние ИИ
        const aiState = {
            levels: { freddy: 0, bonnie: 0, chica: 0, foxy: 0 },
            positions: {
                freddy: 'cam_1a',
                bonnie: 'cam_5',
                chica: 'cam_1a',
                foxy: 'cam_1c'
            },
            foxyStage: 1,
            isFoxyRunning: false
        };

        // ===== ПРАВИЛЬНЫЕ КАРТЫ ДВИЖЕНИЯ (FNAF 1) =====
        const PATHS = {
            freddy: ['cam_1a', 'cam_1b', 'cam_7', 'cam_6', 'cam_4a', 'cam_4b', 'office_right'],
            bonnie: ['cam_5', 'cam_1a', 'cam_2a', 'cam_2b', 'office_left'],
            chica: ['cam_1a', 'cam_1b', 'cam_4a', 'cam_4b', 'office_right'],
            foxy: ['cam_1c', 'cam_2a', 'cam_4a', 'office_right']
        };

        // ===== ИГРОВОЕ СОСТОЯНИЕ =====
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
            officeDoorLeft: document.getElementById('officeDoorLeft'),
            officeDoorRight: document.getElementById('officeDoorRight'),
            cameraBtns: document.querySelectorAll('.camera-btn'),
            tabletToggle: document.getElementById('tabletToggle'),
            usageBars: document.querySelectorAll('.usage-bar'),
            noteBtn: document.getElementById('noteBtn'),
            noteOverlay: document.getElementById('noteOverlay'),
            noteCloseBtn: document.getElementById('noteCloseBtn'),
            leds: {
                freddy: document.getElementById('freddyLed'),
                bonnie: document.getElementById('bonnieLed'),
                chica: document.getElementById('chicaLed'),
                foxy: document.getElementById('foxyLed')
            }
        };

        let gameLoopInterval = null;
        let aiStepInterval = null;
        let aiBoostInterval = null;
        let aiFoxyInterval = null;
        let minuteLoopInterval = null;
        let foxyRunTimeout = null;

        // ============================================================
        //  ФУНКЦИИ ИИ
        // ============================================================

        function initAI(night) {
            const base = AI_LEVELS[night] || AI_LEVELS[1];
            aiState.levels.freddy = base.freddy;
            aiState.levels.bonnie = base.bonnie;
            aiState.levels.chica = base.chica;
            aiState.levels.foxy = base.foxy;

            aiState.positions.freddy = 'cam_1a';
            aiState.positions.bonnie = 'cam_5';
            aiState.positions.chica = 'cam_1a';
            aiState.positions.foxy = 'cam_1c';
            aiState.foxyStage = 1;
            aiState.isFoxyRunning = false;

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
            if (gameState.isGameOver) return;
            const names = ['freddy', 'bonnie', 'chica', 'foxy'];
            names.forEach(name => {
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

            const currentPos = aiState.positions[name];
            const currentIndex = path.indexOf(currentPos);

            if (currentPos === 'office_left' || currentPos === 'office_right') {
                if (name === 'foxy') {
                    foxyAttack();
                } else {
                    attackAnimatronic(name);
                }
                return;
            }

            if (currentIndex >= path.length - 1) {
                if (name === 'foxy') {
                    foxyAttack();
                } else {
                    attackAnimatronic(name);
                }
                return;
            }

            const nextPos = path[currentIndex + 1];
            aiState.positions[name] = nextPos;
            updateAnimatronicIndicator(name);

            if (name === 'foxy' && nextPos === 'cam_2a' && aiState.foxyStage === 4) {
                foxyStartRun();
            }
        }

        function attackAnimatronic(name) {
            const door = aiState.positions[name] === 'office_left' ? 'left' : 'right';
            const isClosed = door === 'left' ? gameState.leftDoorClosed : gameState.rightDoorClosed;

            if (isClosed) {
                console.log(`🚪 ${name.toUpperCase()} стучится в ${door} дверь, но она закрыта`);
                const path = PATHS[name];
                if (path) {
                    aiState.positions[name] = path[0];
                }
            } else {
                gameOver(`${name.toUpperCase()} проник в офис!`);
            }
        }

        // ===== ОБНОВЛЕНИЕ ИНДИКАТОРОВ (С ЦВЕТАМИ) =====
        function updateAnimatronicIndicator(name) {
            const led = el.leds[name];
            if (!led) return;

            const pos = aiState.positions[name];
            const level = aiState.levels[name];

            // 1. Если ИИ = 0 или аниматроник неактивен — ЧЁРНЫЙ
            if (level <= 0) {
                led.className = 'led';
                led.style.background = '#1a1a1a';
                led.style.borderColor = '#2a2a2a';
                led.style.boxShadow = 'none';
                return;
            }

            // 2. У двери — КРАСНЫЙ (опасность!)
            if (pos === 'office_left' || pos === 'office_right') {
                led.className = 'led red';
                return;
            }

            // 3. В коридорах (2A, 2B, 4A, 4B) — ЖЁЛТЫЙ (приближается)
            if (pos === 'cam_2a' || pos === 'cam_2b' || pos === 'cam_4a' || pos === 'cam_4b') {
                led.className = 'led orange';
                return;
            }

            // 4. На других камерах — ЗЕЛЁНЫЙ (далеко)
            if (pos.includes('cam_')) {
                led.className = 'led green';
                return;
            }

            // 5. Если ничего не подошло — ЗЕЛЁНЫЙ (по умолчанию)
            led.className = 'led green';
        }

        // ===== ФОКСИ =====
        function updateFoxy() {
            if (gameState.isGameOver || aiState.isFoxyRunning) return;
            if (gameState.night < 2) return;

            const watchingCove = gameState.isTabletMode && gameState.currentCamera === 'cam_1c';

            if (watchingCove) {
                if (aiState.foxyStage > 1) {
                    aiState.foxyStage = 1;
                    console.log('🦊 Фокси спрятался обратно за занавес');
                }
            } else {
                const level = aiState.levels.foxy;
                const progressChance = level / 40;
                if (Math.random() < progressChance && aiState.foxyStage < 4) {
                    aiState.foxyStage += 1;
                    console.log(`🦊 Стадия Фокси: ${aiState.foxyStage}`);
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
                if (gameState.isGameOver) return;
                if (gameState.leftDoorClosed) {
                    showWarning('💥 ДВЕРЬ ВЫДЕРЖАЛА!');
                    aiState.foxyStage = 1;
                    aiState.isFoxyRunning = false;
                    aiState.positions.foxy = 'cam_1c';
                } else {
                    gameOver('🦊 Фокси добрался до офиса!');
                }
            }, 4000);
        }

        function foxyAttack() {
            if (!gameState.leftDoorClosed) {
                gameOver('🦊 Фокси ворвался в офис!');
            }
        }

        // ============================================================
        //  ОСТАЛЬНЫЕ ФУНКЦИИ
        // ============================================================

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
                    alert(`🎉 Ночь ${gameState.night} пройдена! Открыта ночь ${data.max_night}`);
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

        function updateTime() {
            const hours = 12 + gameState.time;
            const ampm = hours >= 12 ? 'AM' : 'PM';
            const displayHours = hours > 12 ? hours - 12 : hours;
            const displayMinutes = String(gameState.minute).padStart(2, '0');
            el.time.textContent = `${displayHours}:${displayMinutes} ${ampm}`;
        }

        function minuteTick() {
            if (gameState.isGameOver) return;
            const msPerGameMinute = CONFIG.HOUR_DURATION / 60;
            const elapsed = Date.now() - gameState.hourStartTimestamp;
            gameState.minute = Math.min(59, Math.floor(elapsed / msPerGameMinute));
            updateTime();
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
                if (index < activeBars) bar.classList.add('active');
            });
        }

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

            const query = new URLSearchParams({
                freddy_pos: aiState.positions.freddy,
                bonnie_pos: aiState.positions.bonnie,
                chica_pos: aiState.positions.chica,
                foxy_pos: aiState.positions.foxy,
                foxy_stage: aiState.foxyStage,
                foxy_running: aiState.isFoxyRunning ? '1' : '0'
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

        function gameOver(reason) {
            if (gameState.isGameOver) return;
            gameState.isGameOver = true;
            clearInterval(gameLoopInterval);
            clearInterval(aiStepInterval);
            clearInterval(aiBoostInterval);
            clearInterval(aiFoxyInterval);
            clearInterval(minuteLoopInterval);
            clearTimeout(foxyRunTimeout);
            alert(`💀 ${reason}\nВы прожили до ${el.time.textContent}`);
            window.location.href = '{{ route('menu') }}';
        }

        function advanceHour() {
            if (gameState.isGameOver) return;
            gameState.time += 1;
            gameState.minute = 0;
            gameState.hourStartTimestamp = Date.now();
            updateTime();
            if (gameState.time >= 6) {
                clearInterval(gameLoopInterval);
                clearInterval(aiStepInterval);
                clearInterval(aiBoostInterval);
                clearInterval(aiFoxyInterval);
                clearInterval(minuteLoopInterval);
                setTimeout(() => {
                    const powerUsed = 100 - gameState.power;
                    completeNight(0, Math.round(powerUsed));
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
            console.log(`⏰ ${gameState.time}:00 AM, Энергия: ${Math.round(gameState.power)}%`);
        }

        // ============================================================
        //  ОБРАБОТЧИКИ СОБЫТИЙ
        // ============================================================

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

        if (el.noteBtn) el.noteBtn.addEventListener('click', openNote);
        if (el.noteCloseBtn) el.noteCloseBtn.addEventListener('click', closeNote);

        // ============================================================
        //  ЗАПУСК
        // ============================================================

        el.container.classList.add('tablet-mode');
        el.container.classList.remove('office-mode');
        el.tabletToggle.textContent = '📱 ОПУСТИТЬ ПЛАНШЕТ';
        el.tabletToggle.style.borderColor = '#ffaa44';
        el.tabletToggle.style.color = '#ffaa44';
        el.leftDoor.classList.add('disabled');
        el.rightDoor.classList.add('disabled');
        el.leftLight.classList.add('disabled');
        el.rightLight.classList.add('disabled');

        initAI(gameState.night);

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

        setInterval(() => {
            const overlay = document.querySelector('.static-overlay');
            if (overlay) overlay.style.opacity = 0.2 + Math.random() * 0.6;
        }, 1200);

        console.log('🎮 FNAF 1 - Ночь', gameState.night);
        console.log('📹 Загружено 11 камер');
        console.log('⚡ Система USAGE активирована');
        console.log('📋 Система записок активирована');
        console.log('🤖 Система ИИ активирована (уровни 0-20)');
        console.log('🟢 Индикаторы: ЧЁРНЫЙ(неактивен) → ЗЕЛЁНЫЙ(далеко) → ЖЁЛТЫЙ(близко) → КРАСНЫЙ(опасность!)');
    </script>
</body>
</html>
