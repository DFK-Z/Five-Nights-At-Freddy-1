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
            background: #000;
            min-height: 100vh;
            display: flex;
            font-family: 'Courier New', monospace;
            overflow: hidden;
            color: #d8d8d8;
        }

        .menu-screen {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            background: radial-gradient(ellipse at 70% 50%, #0a0a0a 0%, #000 70%);
        }

        /* ===== СТАТИЧНЫЙ ШУМ (VHS) ===== */
        .static-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 10;
            opacity: 0.09;
            background-image: repeating-linear-gradient(
                0deg, #fff 0px, transparent 1px, transparent 2px, #fff 3px
            ), repeating-linear-gradient(
                90deg, transparent 0 3px, rgba(255,255,255,0.4) 3px 4px
            );
            mix-blend-mode: overlay;
            animation: staticShift 0.2s steps(4) infinite;
        }
        @keyframes staticShift {
            0% { background-position: 0 0, 0 0; }
            25% { background-position: -30px 15px, 10px 0; }
            50% { background-position: 20px -10px, -15px 0; }
            75% { background-position: -10px 25px, 25px 0; }
            100% { background-position: 0 0, 0 0; }
        }

        /* ===== СКАНЛАЙН-ПОЛОСА ПОСЕРЕДИНЕ ===== */
        .scan-bar {
            position: absolute;
            left: 0; right: 0;
            top: 42%;
            height: 34px;
            background: rgba(210,210,210,0.10);
            z-index: 5;
            pointer-events: none;
            animation: scanDrift 6s ease-in-out infinite;
        }
        @keyframes scanDrift {
            0%, 100% { top: 40%; opacity: 0.7; }
            50% { top: 46%; opacity: 1; }
        }

        @keyframes flicker {
            0%, 100% { opacity: 1; }
            3% { opacity: 0.85; }
            6% { opacity: 1; }
            41% { opacity: 1; }
            43% { opacity: 0.8; }
            45% { opacity: 1; }
        }

        /* ===== ЛЕВАЯ ЧАСТЬ: ТЕКСТ ===== */
        .menu-left {
            position: relative;
            z-index: 6;
            padding: 60px 0 60px 70px;
            width: 55%;
            animation: flicker 5s infinite;
        }

        .title-line {
            font-size: 44px;
            font-weight: bold;
            color: #eee;
            line-height: 1.15;
            letter-spacing: 1px;
            text-shadow: 0 0 12px rgba(255,255,255,0.15);
        }

        .divider-space {
            height: 90px;
        }

        .menu-list {
            list-style: none;
        }

        .menu-list li {
            font-size: 26px;
            padding: 6px 0 6px 34px;
            position: relative;
            color: #666;
        }

        .menu-list li.active {
            color: #eee;
        }
        .menu-list li.active::before {
            content: '>>';
            position: absolute;
            left: 0;
            color: #eee;
        }

        .menu-list a,
        .menu-list button {
            all: unset;
            color: inherit;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
        }

        .menu-list li.locked {
            color: #3a3a3a;
            cursor: not-allowed;
        }
        .menu-list li.locked a { pointer-events: none; }

        .menu-list .lock-icon {
            font-size: 15px;
            margin-left: 10px;
            opacity: 0.6;
        }
        .menu-list .stars {
            font-size: 13px;
            margin-left: 10px;
            color: #999;
            letter-spacing: 2px;
        }

        .reset-item {
            margin-top: 26px;
            font-size: 16px !important;
            color: #555 !important;
        }
        .reset-item:hover {
            color: #ccc !important;
        }

        .stats-line {
            margin-top: 30px;
            font-size: 13px;
            color: #444;
            line-height: 1.8;
        }

        .flash-message {
            margin-top: 14px;
            font-size: 13px;
        }
        .flash-message.error { color: #cc6666; }
        .flash-message.success { color: #88bb88; }

        /* ===== ПРАВАЯ ЧАСТЬ: СИЛУЭТ ===== */
        .menu-right {
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 45%;
            z-index: 3;
            overflow: hidden;
        }

        .silhouette-head {
            position: absolute;
            right: -8%;
            top: 50%;
            transform: translateY(-50%);
            width: 480px;
            height: 480px;
            border-radius: 50% 50% 45% 45%;
            background: radial-gradient(circle at 40% 35%, #2a2118 0%, #100c08 55%, #000 80%);
            filter: blur(1px);
            opacity: 0.85;
        }

        .silhouette-ear {
            position: absolute;
            top: -40px;
            width: 90px;
            height: 130px;
            background: radial-gradient(circle at 40% 35%, #2a2118, #0a0805);
            border-radius: 50% 50% 40% 40%;
        }
        .silhouette-ear.left { right: 320px; }
        .silhouette-ear.right { right: 130px; }

        .silhouette-eye {
            position: absolute;
            top: 44%;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: radial-gradient(circle, #fff 0%, #ffdd99 40%, transparent 75%);
            box-shadow: 0 0 25px 8px rgba(255,220,150,0.5);
            animation: eyeGlow 3.5s infinite;
        }
        .silhouette-eye.left { right: 250px; }
        .silhouette-eye.right { right: 175px; top: 42%; }

        @keyframes eyeGlow {
            0%, 100% { opacity: 1; }
            48% { opacity: 1; }
            50% { opacity: 0.15; }
            52% { opacity: 1; }
        }

        .menu-footer-bar {
            position: absolute;
            left: 0; right: 0; bottom: 0;
            display: flex;
            justify-content: space-between;
            padding: 14px 24px;
            font-size: 11px;
            color: #444;
            z-index: 6;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="menu-screen">
        <div class="static-overlay"></div>
        <div class="scan-bar"></div>

        <div class="menu-right">
            <div class="silhouette-head"></div>
            <div class="silhouette-ear left"></div>
            <div class="silhouette-ear right"></div>
            <div class="silhouette-eye left"></div>
            <div class="silhouette-eye right"></div>
        </div>

        <div class="menu-left">
            <div class="title-line">Five</div>
            <div class="title-line">Nights</div>
            <div class="title-line">at</div>
            <div class="title-line">Freddy's</div>

            <div class="divider-space"></div>

            <ul class="menu-list">
                @for ($i = 1; $i <= 7; $i++)
                    @php
                        $isUnlocked = $i <= $session->max_night;
                        $isCompleted = $session->max_night > $i;
                        $isCurrent = $i == $session->night;
                    @endphp
                    <li class="{{ !$isUnlocked ? 'locked' : '' }} {{ $isCurrent && $isUnlocked ? 'active' : '' }}">
                        @if ($isUnlocked)
                            <a href="{{ route('night.start', $i) }}">НОЧЬ {{ $i }}</a>
                            @if ($isCompleted)
                                <span class="stars">★★★</span>
                            @endif
                        @else
                            НОЧЬ {{ $i }}
                            <span class="lock-icon">🔒</span>
                        @endif
                    </li>
                @endfor

                <li class="reset-item">
                    <form action="{{ route('reset.progress') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Сбросить прогресс</button>
                    </form>
                </li>
            </ul>

            <div class="stats-line">
                Текущая ночь: {{ $session->night }}<br>
                Рекорд: {{ $session->high_score }} очков
            </div>

            @if (session('error'))
                <div class="flash-message error">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="flash-message success">{{ session('success') }}</div>
            @endif
        </div>

        <div class="menu-footer-bar">
            <span>v0.1</span>
            <span>fan-made project</span>
        </div>
    </div>
</body>
</html>
