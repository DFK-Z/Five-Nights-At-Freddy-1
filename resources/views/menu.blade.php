<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Five Nights At Freddy's</title>
    <!-- ===== ПОДКЛЮЧАЕМ ВНЕШНИЙ CSS ===== -->
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
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

            <!-- ===== ЗВЁЗДЫ ПОД ЗАГОЛОВКОМ ===== -->
            <div class="stars-display">
                @for ($i = 1; $i <= 3; $i++)
                    @if ($i <= ($session->stars ?? 0))
                        <span class="star-filled">★</span>
                    @else
                        <span class="star-empty">☆</span>
                    @endif
                @endfor
            </div>

            <div class="divider-space"></div>

            <ul class="menu-list">
                @for ($i = 1; $i <= 7; $i++)
                    @php
                        $isUnlocked = $i <= $session->max_night;
                        $isCompleted = $session->completed_night >= $i;
                        $isCurrent = $i == $session->night;
                    @endphp
                    <li class="{{ !$isUnlocked ? 'locked' : '' }} {{ $isCurrent && $isUnlocked ? 'active' : '' }}">
                        @if ($isUnlocked)
                            @if ($i == 7)
                                <a href="{{ route('custom.night') }}">СВОЯ НОЧЬ</a>
                            @else
                                <a href="{{ route('night.start', $i) }}">НОЧЬ {{ $i }}</a>
                            @endif
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
