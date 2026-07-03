<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ночь {{ $session->night }} - Five Nights At Freddy's</title>
    <style>
        /* ... ВСЕ СТИЛИ ОСТАВЛЯЕМ ТАКИМИ ЖЕ ... */
        /* (скопируй стили из предыдущего game.blade.php) */
    </style>
</head>
<body>
    <!-- ===== ВЕСЬ HTML ОСТАВЛЯЕМ ТАКИМ ЖЕ ===== -->
    <div class="game-container">
        <!-- ... ВСЯ РАЗМЕТКА БЕЗ ИЗМЕНЕНИЙ ... -->
    </div>

    <a href="{{ route('menu') }}" class="back-btn">✕ В МЕНЮ</a>

    <!-- ===== ПЕРЕДАЁМ ДАННЫЕ ИЗ PHP В JS ===== -->
    <script>
        window.gameConfig = {
            night: {{ $session->night }}
        };
    </script>

    <!-- ===== ПОДКЛЮЧАЕМ ВНЕШНИЙ JS ===== -->
    <script src="{{ asset('js/game.js') }}"></script>
</body>
</html>
