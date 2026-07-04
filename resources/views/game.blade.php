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
            <div id="cameraImage">
                <!-- Сюда через AJAX подгружаются файлы из cameras/ -->
            </div>
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

            <!-- ===== ЭКРАН ПОБЕДЫ (6:00 AM) ===== -->
            <div class="victory-screen" id="victoryScreen">
                <div class="victory-overlay"></div>
                <div class="victory-content">
                    <div class="victory-time" id="victoryTime">6:00 AM</div>
                    <div class="victory-subtitle">НОЧЬ {{ $session->night }} ПРОЙДЕНА</div>
                    <button class="victory-btn" id="victoryBtn">▶ ПРОДОЛЖИТЬ</button>
                </div>
            </div>

            <!-- ===== ЭФФЕКТ ОТКЛЮЧЕНИЯ ЭЛЕКТРИЧЕСТВА ===== -->
            <div class="power-outage-overlay" id="powerOutageOverlay">
                <div class="blackout-layer" id="blackoutLayer"></div>
                <div class="freddy-music" id="freddyMusic">
                    <div class="music-icon">🎵</div>
                    <div class="music-text">...Фредди играет...</div>
                </div>
                <div class="screamer-layer" id="screamerLayer">
                    <div class="screamer-face">🐻</div>
                </div>
                <div class="static-burst" id="staticBurst"></div>
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
    <button class="tablet-toggle-btn office-mode-btn" id="tabletToggle" style="border-color:#44ff44;color:#44ff44;">📱 ПОДНЯТЬ ПЛАНШЕТ</button>

    <script>
        // ============================================================
        //  ВСЯ ИГРОВАЯ ЛОГИКА (ОДИН ФАЙЛ)
        // ============================================================

        // ===== РЕЖИМ СЛОЖНОСТИ (ТОЛЬКО 2 РЕЖИМА) =====
        const gameMode = '{{ session('game_mode', 'easy') }}';

        const CONFIG = {
            HOUR_DURATION: 90000,
            POWER_DRAIN_PER_HOUR: 8,
            POWER_DRAIN_CAMERA: 0.5,
            POWER_DRAIN_DOOR: 2,
            POWER_DRAIN_LIGHT: 1
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
            foxyStage: 1,
            isFoxyRunning: false,
            cooldown: { freddy: 0, bonnie: 0, chica: 0, foxy: 0 }
        };

        const PATHS = {
            freddy: ['cam_1a', 'cam_1b', 'cam_7', 'cam_6', 'cam_4a', 'cam_4b', 'office_right'],
            bonnie: ['cam_1a', 'cam_1b', 'cam_2a', 'cam_2b', 'cam_3', 'cam_5', 'office_left'],
            chica: ['cam_1a', 'cam_1b', 'cam_4a', 'cam_4b', 'cam_6', 'cam_7', 'office_right']
            // foxy сюда не входит — см. foxyStage / updateFoxy() / foxyStartRun()
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
                musicStarted: false,
                blackoutStarted: false,
                screamerShown: false
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
            powerOutageOverlay: document.getElementById('powerOutageOverlay'),
            blackoutLayer: document.getElementById('blackoutLayer'),
            freddyMusic: document.getElementById('freddyMusic'),
            screamerLayer: document.getElementById('screamerLayer'),
            staticBurst: document.getElementById('staticBurst'),
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
        let powerDrainInterval = null;
        let powerOutageInterval = null;

        // ============================================================
        //  ЭКРАН ПОБЕДЫ (6:00 AM)
        // ============================================================

        let victoryActive = false;

        function showVictoryScreen() {
            victoryActive = true;

            clearInterval(gameLoopInterval);
            clearInterval(aiStepInterval);
            clearInterval(aiBoostInterval);
            clearInterval(aiFoxyInterval);
            clearInterval(minuteLoopInterval);
            clearInterval(powerDrainInterval);
            if (powerOutageInterval) clearInterval(powerOutageInterval);

            el.victoryScreen.classList.add('active');

            setTimeout(() => {
                el.victoryScreen.classList.add('fade-in');
            }, 100);

            const victoryTime = document.getElementById('victoryTime');
            victoryTime.textContent = '6:00 AM';

            console.log('🎉 Ночь пройдена! 6:00 AM!');
        }

        // ============================================================
        //  ЧИТЕРСКАЯ КОМБИНАЦИЯ (C + D + NumPad+)
        // ============================================================

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

        // ============================================================
        //  ФУНКЦИИ ИИ
        // ============================================================

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
            if (gameState.isGameOver) return;
            // 'foxy' сюда не входит — им управляет ИСКЛЮЧИТЕЛЬНО updateFoxy() через
            // foxyStage. Раньше он одновременно жил в этой системе (PATHS.foxy) и в
            // системе стадий занавеса — из-за этого он мог "телепортом" добраться до
            // офиса и убить, пока индикатор всё ещё показывал стадию 1 (занавес закрыт).
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

            const currentPos = aiState.positions[name];
            const currentIndex = path.indexOf(currentPos);

            if (currentPos === 'office_left' || currentPos === 'office_right') {
                attackAnimatronic(name);
                return;
            }

            if (currentIndex >= path.length - 1) {
                attackAnimatronic(name);
                return;
            }

            const nextPos = path[currentIndex + 1];
            aiState.positions[name] = nextPos;
            updateAnimatronicIndicator(name);
            updateDoorVisitors();
        }

        function attackAnimatronic(name) {
            const door = aiState.positions[name] === 'office_left' ? 'left' : 'right';
            const isClosed = door === 'left' ? gameState.leftDoorClosed : gameState.rightDoorClosed;

            if (isClosed) {
                console.log(`🚪 ${name.toUpperCase()} стучится в ${door} дверь, но она закрыта`);

                const path = PATHS[name];
                if (path) {
                    const currentIndex = path.indexOf(aiState.positions[name]);
                    const backStep = Math.min(2, currentIndex);
                    const fallbackIndex = Math.max(0, currentIndex - backStep);
                    aiState.positions[name] = path[fallbackIndex];
                    console.log(`🚶 ${name.toUpperCase()} отступил на ${backStep} шага назад`);
                }

                aiState.cooldown[name] = 3 + Math.floor(Math.random() * 2);
                updateAnimatronicIndicator(name);
                updateDoorVisitors();
            } else {
                gameOver(`${name.toUpperCase()} проник в офис!`);
            }
        }

        // ===== ВИДИМОСТЬ АНИМАТРОНИКОВ В КОРИДОРЕ ЗА ДВЕРЬЮ =====
        // Если Бонни/Фредди/Чика дошли до самого порога (office_left/office_right),
        // они должны быть видны в коридоре за дверным проёмом, пока дверь не закрыта —
        // ровно как в оригинале, где их можно заметить до того, как решишь закрыться.
        function updateDoorVisitors() {
            const leftVisitor = document.getElementById('leftHallwayVisitor');
            const rightVisitor = document.getElementById('rightHallwayVisitor');
            if (!leftVisitor || !rightVisitor) return;

            if (aiState.positions.bonnie === 'office_left') {
                leftVisitor.textContent = '🐰';
                leftVisitor.classList.add('visible');
            } else {
                leftVisitor.classList.remove('visible');
            }

            // Правая дверь делят Фредди и Чика — показываем того, кто реально дошёл
            if (aiState.positions.freddy === 'office_right') {
                rightVisitor.textContent = '🐻';
                rightVisitor.classList.add('visible');
            } else if (aiState.positions.chica === 'office_right') {
                rightVisitor.textContent = '🐤';
                rightVisitor.classList.add('visible');
            } else {
                rightVisitor.classList.remove('visible');
            }
        }

        function updateAnimatronicIndicator(name) {
            const led = el.leds[name];
            if (!led) return;

            // ===== СЛОЖНЫЙ РЕЖИМ: ИНДИКАТОРЫ СКРЫТЫ =====
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

            led.style.animation = 'none';

            if (name === 'foxy') {
                updateFoxyIndicator(led);
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

            if (pos === 'cam_1b' || pos === 'dining_area') {
                led.className = 'led green';
                led.style.background = '#44ff44';
                led.style.borderColor = '#44ff44';
                led.style.boxShadow = '0 0 15px rgba(68,255,68,0.3)';
                return;
            }

            if (pos === 'cam_5' || pos === 'backstage') {
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

            if (pos === 'cam_6' || pos === 'kitchen') {
                led.className = 'led orange';
                led.style.background = '#ffaa44';
                led.style.borderColor = '#ffaa44';
                led.style.boxShadow = '0 0 15px rgba(255,170,68,0.3)';
                return;
            }

            if (pos === 'cam_3' || pos === 'closet') {
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

            // ===== ПРАВИЛЬНАЯ ЦВЕТОВАЯ СХЕМА ДЛЯ ФОКСИ =====
            // Стадия 1: Спит в бухте — ЗЕЛЁНЫЙ
            if (stage === 1) {
                led.className = 'led green';
                led.style.background = '#44ff44';
                led.style.borderColor = '#44ff44';
                led.style.boxShadow = '0 0 15px rgba(68,255,68,0.3)';
                led.style.animation = 'none';
                return;
            }

            // Стадия 2: Выглядывает — ОРАНЖЕВЫЙ (предупреждение)
            if (stage === 2) {
                led.className = 'led orange';
                led.style.background = '#ff8800';
                led.style.borderColor = '#ff8800';
                led.style.boxShadow = '0 0 15px rgba(255,136,0,0.3)';
                led.style.animation = 'none';
                return;
            }

            // Стадия 3: Готов бежать — КРАСНЫЙ (опасность близко)
            if (stage === 3) {
                led.className = 'led red';
                led.style.background = '#ff4444';
                led.style.borderColor = '#ff4444';
                led.style.boxShadow = '0 0 20px rgba(255,68,68,0.4)';
                led.style.animation = 'dangerPulse 1s infinite';
                return;
            }

            // Стадия 4: Бежит! — КРАСНЫЙ МЕРЦАЮЩИЙ (немедленная угроза)
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
            if (gameState.isGameOver || aiState.isFoxyRunning) return;
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
                if (gameState.isGameOver) return;
                if (gameState.leftDoorClosed) {
                    showWarning('💥 ДВЕРЬ ВЫДЕРЖАЛА!');
                    aiState.foxyStage = 1;
                    aiState.isFoxyRunning = false;
                    aiState.positions.foxy = 'cam_1c';
                } else {
                    playScreamer('🦊', '🦊 Фокси добрался до офиса!');
                }
            }, 4000);
        }

        // ===== ОБЩИЙ СКРИМЕР (переиспользуется для любого аниматроника) =====
        // Показывает морду на весь экран, трясёт кадр, затем помехи, и только
        // после этого — настоящий game over. Раньше атака убивала мгновенным
        // alert() без какой-либо визуальной реакции.
        function playScreamer(faceEmoji, reason) {
            if (gameState.isGameOver) return;

            el.powerOutageOverlay.classList.add('active');
            const face = el.screamerLayer.querySelector('.screamer-face');
            if (face) face.textContent = faceEmoji;
            el.screamerLayer.classList.add('active');

            if (navigator.vibrate) {
                navigator.vibrate(300);
            }

            setTimeout(() => {
                el.staticBurst.classList.add('active');
            }, 1500);

            setTimeout(() => {
                gameOver(reason);
            }, 3000);
        }

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
                if (gameState.isGameOver) return;

                const activeActions = updateUsage();
                const drainPerHour = calculatePowerDrain(activeActions);
                const drainPerSecond = drainPerHour / (CONFIG.HOUR_DURATION / 1000);

                gameState.power = Math.max(0, gameState.power - drainPerSecond);
                updatePower();

                if (gameState.power <= 0 && !gameState.isBlackout) {
                    clearInterval(powerDrainInterval);
                    triggerBlackout();
                }
            }, 1000);
        }

        // ===== ОТКЛЮЧЕНИЕ ЭЛЕКТРИЧЕСТВА (FULL POWER OUTAGE) =====
        function triggerBlackout() {
            if (gameState.isGameOver || gameState.isBlackout) return;
            gameState.isBlackout = true;
            gameState.powerOutage.active = true;
            gameState.powerOutage.timer = 0;

            // Двери принудительно открываются
            if (gameState.leftDoorClosed) {
                gameState.leftDoorClosed = false;
                el.leftDoor.querySelector('.status').textContent = 'ОТКРЫТА';
                el.leftDoor.classList.remove('closed');
                el.leftDoorLed.className = 'led';
                el.officeDoorLeft.classList.remove('shut');
            }
            if (gameState.rightDoorClosed) {
                gameState.rightDoorClosed = false;
                el.rightDoor.querySelector('.status').textContent = 'ОТКРЫТА';
                el.rightDoor.classList.remove('closed');
                el.rightDoorLed.className = 'led';
                el.officeDoorRight.classList.remove('shut');
            }
            gameState.leftLightOn = false;
            gameState.rightLightOn = false;

            // Блокируем всё управление
            el.leftDoor.classList.add('disabled');
            el.rightDoor.classList.add('disabled');
            el.leftLight.classList.add('disabled');
            el.rightLight.classList.add('disabled');
            el.tabletToggle.classList.add('disabled');
            el.container.classList.remove('tablet-mode');
            el.container.classList.add('office-mode');
            gameState.isTabletMode = false;

            // Выключаем индикаторы
            document.querySelectorAll('.led').forEach(led => {
                led.className = 'led';
                led.style.background = '#1a1a1a';
                led.style.borderColor = '#2a2a2a';
                led.style.boxShadow = 'none';
                led.style.animation = 'none';
            });

            // Отключаем камеры
            el.cameraBtns.forEach(btn => {
                btn.classList.add('disabled');
                btn.style.opacity = '0.1';
            });
            el.cameraImage.innerHTML = '<div style="color: #111; font-size: 24px;">📹</div>';
            el.cameraLabel.textContent = 'ОТКЛЮЧЕНО';
            el.cameraLabel.style.color = '#222';

            // Показываем оверлей отключения
            el.powerOutageOverlay.classList.add('active');

            console.log('⚡ ОТКЛЮЧЕНИЕ ЭЛЕКТРИЧЕСТВА!');
            showWarning('⚡ ЭНЕРГИЯ ЗАКОНЧИЛАСЬ!');

            // Запускаем таймер отключения
            powerOutageInterval = setInterval(updatePowerOutage, 1000);
        }

        function updatePowerOutage() {
            gameState.powerOutage.timer++;
            const timer = gameState.powerOutage.timer;

            if (timer <= 30) {
                gameState.powerOutage.phase = 'waiting';
                if (timer % 5 === 0) {
                    const lamp = document.querySelector('.office-lamp');
                    if (lamp) {
                        lamp.style.opacity = Math.random() > 0.7 ? '0.2' : '1';
                        setTimeout(() => { lamp.style.opacity = '1'; }, 200);
                    }
                }
                return;
            }

            if (timer <= 60) {
                gameState.powerOutage.phase = 'music';
                if (!gameState.powerOutage.musicStarted) {
                    gameState.powerOutage.musicStarted = true;
                    el.freddyMusic.classList.add('active');
                    console.log('🎵 Фредди играет...');
                }
                if (timer > 50) {
                    const progress = (timer - 50) / 10;
                    el.blackoutLayer.style.opacity = progress * 0.5;
                }
                return;
            }

            if (timer <= 65) {
                gameState.powerOutage.phase = 'blackout';
                if (!gameState.powerOutage.blackoutStarted) {
                    gameState.powerOutage.blackoutStarted = true;
                    el.blackoutLayer.classList.add('active');
                    el.freddyMusic.classList.remove('active');
                    console.log('🌑 Затемнение...');
                }
                return;
            }

            if (!gameState.powerOutage.screamerShown) {
                gameState.powerOutage.screamerShown = true;
                gameState.powerOutage.phase = 'screamer';

                el.screamerLayer.classList.add('active');

                if (navigator.vibrate) {
                    navigator.vibrate(300);
                }

                console.log('💀 СКРИМЕР!');

                setTimeout(() => {
                    el.staticBurst.classList.add('active');
                }, 1500);

                setTimeout(() => {
                    clearInterval(powerOutageInterval);
                    gameState.powerOutage.active = false;
                    gameOver('🔴 Фредди добрался до офиса!');
                }, 3000);
            }
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
            el.powerDisplay.textContent = p + '%';
            el.powerBar.style.width = p + '%';
            const isLow = p < 20;
            const isMedium = p >= 20 && p < 50;
            el.powerDisplay.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
            el.powerBar.style.background = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
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
            if (gameState.isTabletMode) {
                showWarning('⛔ Опустите планшет чтобы управлять дверями!');
                return;
            }
            if (gameState.isGameOver || gameState.isBlackout) return;
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
            if (gameState.isGameOver || gameState.isBlackout) return;
            if (door === 'left') {
                gameState.leftLightOn = !gameState.leftLightOn;
            } else if (door === 'right') {
                gameState.rightLightOn = !gameState.rightLightOn;
            }
            gameState.isLightOn = gameState.leftLightOn || gameState.rightLightOn;
            if (gameState.power > 0) {
                gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_LIGHT);
                updatePower();
            }
            const view = document.querySelector('.camera-view');
            view.style.boxShadow = '0 0 60px rgba(255,255,200,0.4)';
            setTimeout(() => view.style.boxShadow = 'none', 400);
            console.log(`🔦 Свет на ${door} двери ${gameState[door + 'LightOn'] ? 'включён' : 'выключен'}`);
            updateUsage();
        }

        function toggleTablet() {
            if (gameState.isBlackout) return;
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
            clearInterval(powerDrainInterval);
            if (powerOutageInterval) clearInterval(powerOutageInterval);
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
                showVictoryScreen();
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

        el.victoryBtn.addEventListener('click', () => {
            const powerUsed = 100 - gameState.power;
            completeNight(0, Math.round(powerUsed));
        });

        // ============================================================
        //  ЗАПУСК (НАЧИНАЕМ С ОФИСА)
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
        console.log('📹 Загружено 11 камер');
        console.log('⚡ Система USAGE активирована (динамический расход)');
        console.log('📋 Система записок активирована');
        console.log('🤖 Система ИИ активирована (уровни 0-20)');
        console.log('🟢 Индикаторы: ЧЁРНЫЙ(неактивен) → ЗЕЛЁНЫЙ(далеко) → ЖЁЛТЫЙ(близко) → КРАСНЫЙ(опасность!)');
        console.log('🚪 Аниматроники отступают и возвращаются — баланс восстановлен!');
        console.log('🦊 Фокси теперь бежит с левой стороны!');
        console.log('🦊 Индикатор Фокси синхронизирован со стадиями на камере!');
        console.log('🟢 Детальная цветовая схема индикаторов активирована!');
        console.log('🎮 Custom Night: поддержка пользовательских настроек ИИ активирована!');
        console.log('⭐ Система звёзд активирована!');
        console.log('⌨️ Читерская комбинация: C + D + NumPad+');
        console.log('🏢 Игра начинается с офиса!');
        console.log('🌅 Экран победы 6:00 AM активирован!');
        console.log('⚡ Механика отключения электричества активирована!');
        console.log(`🎮 Режим сложности: ${gameMode === 'hard' ? '🔴 СЛОЖНЫЙ' : '🟢 ЛЁГКИЙ'}`);
    </script>
</body>
</html>
