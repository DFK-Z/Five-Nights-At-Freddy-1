<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Custom Night - Five Nights At Freddy's</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #000;
            color: #fff;
            font-family: 'Courier New', monospace;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .custom-container {
            background: #0a0a0a;
            border: 2px solid #2a1a0a;
            border-radius: 8px;
            padding: 40px 50px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 0 60px rgba(0,0,0,0.9), inset 0 0 30px rgba(30,15,5,0.2);
            position: relative;
        }

        .custom-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(0,0,0,0.03) 2px,
                    rgba(0,0,0,0.03) 4px
                );
            pointer-events: none;
            border-radius: 8px;
        }

        .custom-title {
            text-align: center;
            color: #cc8844;
            font-size: 22px;
            letter-spacing: 6px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .custom-subtitle {
            text-align: center;
            color: #554433;
            font-size: 12px;
            letter-spacing: 4px;
            margin-bottom: 30px;
            border-bottom: 1px solid #1a1008;
            padding-bottom: 15px;
        }

        .slider-group {
            margin-bottom: 20px;
        }

        .slider-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #b8a898;
            font-size: 14px;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .slider-label .name {
            text-transform: uppercase;
        }

        .slider-label .value {
            color: #ffaa44;
            font-weight: bold;
            font-size: 16px;
            min-width: 30px;
            text-align: center;
        }

        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 6px;
            background: #1a1a1a;
            border-radius: 3px;
            outline: none;
            transition: all 0.3s;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #cc8844;
            cursor: pointer;
            border: 2px solid #2a1a0a;
            box-shadow: 0 0 10px rgba(204,136,68,0.3);
            transition: all 0.3s;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            background: #ffaa44;
            box-shadow: 0 0 20px rgba(204,136,68,0.5);
            transform: scale(1.1);
        }

        .preset-buttons {
            display: flex;
            gap: 10px;
            margin: 25px 0 20px 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .preset-btn {
            background: #0a0a0a;
            border: 1px solid #2a1a0a;
            color: #888;
            padding: 8px 16px;
            cursor: pointer;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            letter-spacing: 1px;
            transition: all 0.3s;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .preset-btn:hover {
            border-color: #cc8844;
            color: #cc8844;
            box-shadow: 0 0 20px rgba(204,136,68,0.1);
        }

        .preset-btn.active {
            border-color: #cc8844;
            color: #ffaa44;
            background: #1a1008;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            border-top: 1px solid #1a1008;
            padding-top: 20px;
        }

        .action-btn {
            flex: 1;
            background: #0a0a0a;
            border: 2px solid #2a1a0a;
            color: #888;
            padding: 12px 20px;
            cursor: pointer;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            letter-spacing: 3px;
            transition: all 0.3s;
            border-radius: 4px;
            text-transform: uppercase;
            text-decoration: none;
            text-align: center;
        }

        .action-btn:hover {
            border-color: #ffaa44;
            color: #ffaa44;
            background: #1a1008;
        }

        .action-btn.primary {
            border-color: #6a9a1a;
            color: #8fd633;
        }

        .action-btn.primary:hover {
            border-color: #8fd633;
            color: #aaff44;
            background: #1a2a0a;
            box-shadow: 0 0 30px rgba(140,220,50,0.15);
        }

        .action-btn.danger {
            border-color: #5a1a1a;
            color: #cc4444;
        }

        .action-btn.danger:hover {
            border-color: #ff4444;
            color: #ff4444;
            background: #1a0a0a;
        }
    </style>
</head>
<body>
    <div class="custom-container">
        <div class="custom-title">✦ CUSTOM NIGHT ✦</div>
        <div class="custom-subtitle">НАСТРОЙКА АГРЕССИИ АНИМАТРОНИКОВ</div>

        <form action="{{ route('night.start.custom') }}" method="POST">
            @csrf
            <input type="hidden" name="night" value="7">

            {{-- Фредди --}}
            <div class="slider-group">
                <div class="slider-label">
                    <span class="name">🐻 ФРЕДДИ</span>
                    <span class="value" id="freddyValue">0</span>
                </div>
                <input type="range" name="freddy" id="freddySlider" min="0" max="20" value="0" oninput="updateValue('freddy', this.value)">
            </div>

            {{-- Бонни --}}
            <div class="slider-group">
                <div class="slider-label">
                    <span class="name">🐰 БОННИ</span>
                    <span class="value" id="bonnieValue">0</span>
                </div>
                <input type="range" name="bonnie" id="bonnieSlider" min="0" max="20" value="0" oninput="updateValue('bonnie', this.value)">
            </div>

            {{-- Чика --}}
            <div class="slider-group">
                <div class="slider-label">
                    <span class="name">🐤 ЧИКА</span>
                    <span class="value" id="chicaValue">0</span>
                </div>
                <input type="range" name="chica" id="chicaSlider" min="0" max="20" value="0" oninput="updateValue('chica', this.value)">
            </div>

            {{-- Фокси --}}
            <div class="slider-group">
                <div class="slider-label">
                    <span class="name">🦊 ФОКСИ</span>
                    <span class="value" id="foxyValue">0</span>
                </div>
                <input type="range" name="foxy" id="foxySlider" min="0" max="20" value="0" oninput="updateValue('foxy', this.value)">
            </div>

            {{-- Пресеты --}}
            <div class="preset-buttons">
                <button type="button" class="preset-btn" onclick="setPreset(0,0,0,0)">🟢 ЛЁГКИЙ</button>
                <button type="button" class="preset-btn" onclick="setPreset(5,5,5,5)">🟡 СРЕДНИЙ</button>
                <button type="button" class="preset-btn" onclick="setPreset(10,10,10,10)">🟠 СЛОЖНЫЙ</button>
                <button type="button" class="preset-btn" onclick="setPreset(20,20,20,20)">🔴 4/20</button>
            </div>

            {{-- Кнопки --}}
            <div class="action-buttons">
                <a href="{{ route('menu') }}" class="action-btn">✕ НАЗАД</a>
                <button type="submit" class="action-btn primary">▶ СТАРТ</button>
            </div>
        </form>
    </div>

    <script>
        // ===== ОБНОВЛЕНИЕ ЗНАЧЕНИЙ =====
        function updateValue(name, value) {
            document.getElementById(name + 'Value').textContent = value;
        }

        // ===== УСТАНОВКА ПРЕСЕТОВ =====
        function setPreset(freddy, bonnie, chica, foxy) {
            document.getElementById('freddySlider').value = freddy;
            document.getElementById('bonnieSlider').value = bonnie;
            document.getElementById('chicaSlider').value = chica;
            document.getElementById('foxySlider').value = foxy;

            updateValue('freddy', freddy);
            updateValue('bonnie', bonnie);
            updateValue('chica', chica);
            updateValue('foxy', foxy);

            // Подсветка активного пресета
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            const presets = {
                '0,0,0,0': 'ЛЁГКИЙ',
                '5,5,5,5': 'СРЕДНИЙ',
                '10,10,10,10': 'СЛОЖНЫЙ',
                '20,20,20,20': '4/20'
            };
            const key = `${freddy},${bonnie},${chica},${foxy}`;
            document.querySelectorAll('.preset-btn').forEach(btn => {
                if (btn.textContent.trim() === presets[key]) {
                    btn.classList.add('active');
                }
            });
        }
    </script>
</body>
</html>
