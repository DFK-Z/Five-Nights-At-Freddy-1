<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            <!-- ===== РЕЖИМЫ СЛОЖНОСТИ (ТОЛЬКО 2 КНОПКИ) ===== -->
            <div class="mode-selector">
                <span class="mode-label">⚡ РЕЖИМ:</span>
                <button class="mode-btn {{ session('game_mode', 'easy') === 'easy' ? 'active' : '' }}"
                        onclick="setMode('easy')">
                    🟢 ЛЁГКИЙ
                </button>
                <button class="mode-btn {{ session('game_mode', 'easy') === 'hard' ? 'active' : '' }}"
                        onclick="setMode('hard')">
                    🔴 СЛОЖНЫЙ
                </button>
            </div>

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

    <script>
        // ============================================================
        //  УПРАВЛЕНИЕ РЕЖИМАМИ СЛОЖНОСТИ
        // ============================================================

        function setMode(mode) {
            fetch('{{ route('set.mode') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ mode: mode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Обновляем активную кнопку
                    document.querySelectorAll('.mode-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    document.querySelectorAll('.mode-btn').forEach(btn => {
                        const btnText = btn.textContent.trim();
                        if ((mode === 'easy' && btnText.includes('ЛЁГКИЙ')) ||
                            (mode === 'hard' && btnText.includes('СЛОЖНЫЙ'))) {
                            btn.classList.add('active');
                        }
                    });
                    // Перезагружаем страницу для применения настроек
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('❌ Ошибка при смене режима!');
            });
        }

        console.log('🎮 Режим сложности:', '{{ session('game_mode', 'easy') }}');
    </script>
</body>
</html>
