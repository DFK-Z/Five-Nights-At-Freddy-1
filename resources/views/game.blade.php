<!DOCTYPE html>
<html>
<head>
    <title>Ночь {{ $session->night }}</title>
</head>
<body>
    <h1>ИГРА ЗАПУЩЕНА!</h1>
    <p>Ночь: {{ $session->night }}</p>
    <p id="time">12:00 AM</p>
    <p>⚡ <span id="power">100</span>%</p>
    <a href="/">В МЕНЮ</a>

    <script>
        // Простой тест
        console.log('✅ Скрипт работает!');
        console.log('Ночь:', {{ $session->night }});

        let time = 0;
        let power = 100;
        const timeEl = document.getElementById('time');
        const powerEl = document.getElementById('power');

        setInterval(() => {
            time++;
            power -= 5;
            timeEl.textContent = `${12 + time}:00 AM`;
            powerEl.textContent = Math.round(power);

            if (time >= 6) {
                alert('🎉 Ночь пройдена!');
                window.location.href = '/';
            }
            if (power <= 0) {
                alert('💀 Энергия кончилась!');
                window.location.href = '/';
            }
        }, 5000);
    </script>
</body>
</html>
