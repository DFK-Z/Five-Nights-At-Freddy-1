<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===== ПОДКЛЮЧАЕМ CSS ===== -->
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">

    <title>Ночь {{ $session->night }} - Five Nights At Freddy's</title>
</head>
<body>
    <div class="game-container tablet-mode" id="gameContainer">
        <!-- ===== ВЕРХНЯЯ ПАНЕЛЬ ===== -->
        <div class="top-panel">
            <div class="time" id="gameTime">12:00 AM</div>
            <div class="night">НОЧЬ {{ $session->night }}</div>
            <div class="power">⚡ <span id="powerLevel">100</span>%</div>
        </div>

        <!-- ===== ЛЕВАЯ ПАНЕЛЬ (камеры) ===== -->
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

        <!-- ===== ЦЕНТР (камера) ===== -->
        <div class="camera-view" id="cameraView">
            <div id="cameraImage">
                <!-- Сюда через AJAX подгружаются файлы из cameras/ -->
            </div>
            <div class="static-overlay"></div>
            <div class="camera-label" id="cameraLabel">CAM 1A — СЦЕНА</div>
        </div>

        <!-- ===== ВИД ОФИСА (без планшета) ===== -->
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

        <!-- ===== ПРАВАЯ ПАНЕЛЬ (двери) ===== -->
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

    <!-- ===== КНОПКИ ===== -->
    <a href="{{ route('menu') }}" class="back-btn">✕ В МЕНЮ</a>
    <button class="tablet-toggle-btn" id="tabletToggle">📱 ОПУСТИТЬ ПЛАНШЕТ</button>

    <!-- ===== ПЕРЕДАЁМ ДАННЫЕ ИЗ PHP В JS ===== -->
    <script>
        window.gameConfig = {
            night: {{ $session->night }}
        };
    </script>

    <!-- ===== ПОДКЛЮЧАЕМ JS ===== -->
    <script src="{{ asset('js/ai.js') }}"></script>
    <script type="module" src="{{ asset('js/game.js') }}"></script>
</body>
</html>
