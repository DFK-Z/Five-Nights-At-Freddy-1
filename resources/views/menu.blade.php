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
                                <a href="{{ route('night.start', ['night' => $i, 'mode' => session('game_mode', 'easy')]) }}">НОЧЬ {{ $i }}</a>
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

            <!-- ===== РЕЖИМЫ СЛОЖНОСТИ ===== -->
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

            <!-- ===== ПОДСКАЗКА РЕЖИМА ===== -->
            <div class="mode-hint" id="modeHint">
                @if (session('game_mode', 'easy') === 'easy')
                    🟢 Индикаторы опасности <span class="highlight-green">видны</span>
                @else
                    🔴 Индикаторы опасности <span class="highlight-red">скрыты</span>
                @endif
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
            <span>v0.5</span>
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

                    // Обновляем подсказку
                    const hint = document.getElementById('modeHint');
                    if (mode === 'easy') {
                        hint.innerHTML = '🟢 Индикаторы опасности <span class="highlight-green">видны</span>';
                    } else {
                        hint.innerHTML = '🔴 Индикаторы опасности <span class="highlight-red">скрыты</span>';
                    }

                    // Обновляем ссылки на ночи
                    document.querySelectorAll('.menu-list a').forEach(link => {
                        const href = link.getAttribute('href');
                        if (href && href !== '#' && !href.includes('custom-night')) {
                            const url = new URL(href, window.location.origin);
                            url.searchParams.set('mode', mode);
                            link.setAttribute('href', url.toString());
                        }
                    });

                    // Перезагружаем страницу для применения настроек
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('❌ Ошибка при смене режима!');
            });
        }

        // ===== ПРИ ЗАГРУЗКЕ: ПРИМЕНЯЕМ РЕЖИМ К ССЫЛКАМ =====
        document.addEventListener('DOMContentLoaded', function() {
            const currentMode = '{{ session('game_mode', 'easy') }}';
            document.querySelectorAll('.menu-list a').forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && !href.includes('custom-night')) {
                    const url = new URL(href, window.location.origin);
                    url.searchParams.set('mode', currentMode);
                    link.setAttribute('href', url.toString());
                }
            });
        });

        console.log('🎮 Режим сложности:', '{{ session('game_mode', 'easy') }}');
    </script>
</body>
</html>
