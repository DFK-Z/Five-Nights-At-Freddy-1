<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Nights At Freddy's</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        .menu-container {
            background: linear-gradient(180deg, #1a0a0a 0%, #0d0d0d 100%);
            padding: 60px 80px;
            border-radius: 20px;
            border: 2px solid #3a1a1a;
            box-shadow: 0 0 80px rgba(150, 0, 0, 0.3);
            text-align: center;
            position: relative;
            animation: flicker 4s infinite;
        }

        @keyframes flicker {
            0%, 100% { opacity: 1; }
            3% { opacity: 0.8; }
            6% { opacity: 1; }
            7% { opacity: 0.9; }
            10% { opacity: 1; }
            50% { opacity: 1; }
            53% { opacity: 0.85; }
            56% { opacity: 1; }
        }

        .title {
            font-size: 64px;
            font-weight: 900;
            color: #cc2222;
            text-shadow:
                0 0 20px rgba(200, 0, 0, 0.5),
                0 0 60px rgba(200, 0, 0, 0.3),
                0 0 100px rgba(200, 0, 0, 0.2);
            margin-bottom: 10px;
            letter-spacing: 4px;
        }

        .subtitle {
            font-size: 18px;
            color: #884444;
            margin-bottom: 40px;
            letter-spacing: 8px;
            font-weight: 300;
        }

        .nights-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 30px 0;
        }

        .night-btn {
            background: #1a0a0a;
            border: 2px solid #3a1a1a;
            color: #aa5555;
            padding: 20px 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 10px;
            text-decoration: none;
            display: block;
            position: relative;
        }

        .night-btn:hover:not(.locked) {
            background: #2a0a0a;
            border-color: #aa2222;
            color: #ff6666;
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(200, 0, 0, 0.3);
        }

        .night-btn.locked {
            opacity: 0.3;
            cursor: not-allowed;
            filter: grayscale(1);
        }

        .night-btn .lock-icon {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 14px;
        }

        .night-btn .stars {
            display: block;
            font-size: 12px;
            margin-top: 5px;
            color: #ffaa00;
        }

        .night-btn.completed {
            border-color: #44aa44;
        }

        .menu-footer {
            margin-top: 30px;
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .menu-btn {
            background: transparent;
            border: 1px solid #3a1a1a;
            color: #884444;
            padding: 12px 30px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 5px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .menu-btn:hover {
            background: #1a0a0a;
            border-color: #aa2222;
            color: #ff6666;
        }

        .stats {
            color: #664444;
            font-size: 14px;
            margin-top: 20px;
            border-top: 1px solid #1a0a0a;
            padding-top: 20px;
        }

        .error-message {
            color: #ff4444;
            margin-top: 15px;
            font-size: 14px;
        }

        .success-message {
            color: #44ff44;
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <!-- Заголовок -->
        <div class="title">FIVE NIGHTS</div>
        <div class="title" style="font-size: 36px; margin-top: -10px;">AT FREDDY'S</div>
        <div class="subtitle">✦ НОЧНАЯ СМЕНА ✦</div>

        <!-- Сетка ночей -->
        <div class="nights-grid">
            @for ($i = 1; $i <= 7; $i++)
                @php
                    $isUnlocked = $i <= $session->max_night;
                    $isCompleted = $session->max_night > $i;
                @endphp

                <a href="{{ $isUnlocked ? route('night.start', $i) : '#' }}"
                   class="night-btn {{ !$isUnlocked ? 'locked' : '' }} {{ $isCompleted ? 'completed' : '' }}">
                    НОЧЬ {{ $i }}
                    @if (!$isUnlocked)
                        <span class="lock-icon">🔒</span>
                    @elseif ($isCompleted)
                        <span class="stars">★★★</span>
                    @endif
                </a>
            @endfor
        </div>

        <!-- Дополнительные кнопки -->
        <div class="menu-footer">
            <form action="{{ route('reset.progress') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="menu-btn">🔄 Сбросить</button>
            </form>
        </div>

        <!-- Статистика -->
        <div class="stats">
            <div>Текущая ночь: {{ $session->night }}</div>
            <div>Рекорд: {{ $session->high_score }} очков</div>
        </div>

        <!-- Сообщения -->
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
    </div>
</body>
</html>
