// ============================================================
//  FNAF 1 — ИГРОВАЯ ЛОГИКА
//  (Перенесено из game.blade.php)
// ============================================================

// ========== КОНСТАНТЫ ==========
const CONFIG = {
    HOUR_DURATION: 90000,        // 90 секунд на 1 игровой час
    POWER_DRAIN_PER_HOUR: 8,      // 8% энергии за час
    POWER_DRAIN_CAMERA: 0.5,      // 0.5% за просмотр камеры
    POWER_DRAIN_DOOR: 2,          // 2% за закрытую дверь
    POWER_DRAIN_LIGHT: 1          // 1% за свет
};

// ========== СОСТОЯНИЕ ИГРЫ ==========
const gameState = {
    night: 1, // Будет переопределено из PHP
    time: 0,          // 0 = 12:00 AM, 1 = 1:00 AM, ... 6 = 6:00 AM
    power: 100,
    isGameOver: false,
    currentCamera: 'show',
    leftDoorClosed: false,
    rightDoorClosed: false,
    animatronics: {
        freddy: { position: 'show', isActive: true },
        bonnie: { position: 'backstage', isActive: true },
        chica: { position: 'backstage', isActive: true },
        foxy: { position: 'backstage', isActive: true }
    }
};

// ========== DOM-ЭЛЕМЕНТЫ ==========
const el = {
    time: document.getElementById('gameTime'),
    powerLevel: document.getElementById('powerLevel'),
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
    cameraBtns: document.querySelectorAll('.camera-btn'),
    leds: {
        freddy: document.getElementById('freddyLed'),
        bonnie: document.getElementById('bonnieLed'),
        chica: document.getElementById('chicaLed'),
        foxy: document.getElementById('foxyLed')
    }
};

// ========== ТАЙМЕРЫ ==========
let gameLoopInterval = null;
let timeUpdateInterval = null;

// ========== ФУНКЦИИ ==========

function updateTime() {
    const hours = 12 + gameState.time;
    const ampm = hours >= 12 ? 'AM' : 'PM';
    const displayHours = hours > 12 ? hours - 12 : hours;
    el.time.textContent = `${displayHours}:00 ${ampm}`;
}

function updatePower() {
    const p = Math.round(gameState.power);
    el.powerLevel.textContent = p;
    el.powerDisplay.textContent = p + '%';
    el.powerBar.style.width = p + '%';

    // Цвета
    const isLow = p < 20;
    const isMedium = p >= 20 && p < 50;

    el.powerLevel.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
    el.powerDisplay.className = 'power-value' + (isLow ? ' low' : isMedium ? ' medium' : '');
    el.powerBar.className = 'fill' + (isLow ? ' low' : isMedium ? ' medium' : '');
}

function switchCamera(camera) {
    if (gameState.isGameOver) return;

    gameState.currentCamera = camera;

    el.cameraBtns.forEach(btn => {
        btn.classList.toggle('active', btn.dataset.camera === camera);
    });

    const names = {
        show: 'СЦЕНА',
        backstage: 'ЗАДНЯЯ СЦЕНА',
        west: 'ЗАПАДНЫЙ КОРИДОР',
        east: 'ВОСТОЧНЫЙ КОРИДОР',
        restrooms: 'ТУАЛЕТЫ'
    };

    el.cameraLabel.textContent = names[camera] || camera;
    el.cameraImage.innerHTML = `<span style="color: #1a1a1a; font-size: 64px;">📹</span><br><span style="color: #333; font-size: 16px;">${names[camera]}</span>`;

    // Расход энергии
    if (gameState.power > 0) {
        gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_CAMERA);
        updatePower();
    }
}

function toggleDoor(door) {
    if (gameState.isGameOver) return;

    if (door === 'left') {
        gameState.leftDoorClosed = !gameState.leftDoorClosed;
        const status = el.leftDoor.querySelector('.status');
        status.textContent = gameState.leftDoorClosed ? 'ЗАКРЫТА' : 'ОТКРЫТА';
        el.leftDoor.classList.toggle('closed', gameState.leftDoorClosed);
        el.leftDoorLed.className = 'led ' + (gameState.leftDoorClosed ? 'red' : 'green');

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

        if (gameState.rightDoorClosed && gameState.power > 0) {
            gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_DOOR);
            updatePower();
        }
    }
}

function toggleLight(door) {
    if (gameState.isGameOver) return;

    if (gameState.power > 0) {
        gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_LIGHT);
        updatePower();
    }

    const view = document.querySelector('.camera-view');
    view.style.boxShadow = '0 0 60px rgba(255,255,200,0.4)';
    setTimeout(() => view.style.boxShadow = 'none', 400);

    console.log(`🔦 Свет на ${door} двери`);
}

function moveAnimatronics() {
    // Случайное мигание индикаторов
    const names = ['freddy', 'bonnie', 'chica', 'foxy'];
    names.forEach(name => {
        if (Math.random() < 0.08) {
            const colors = ['orange', 'red', 'green'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            el.leds[name].className = 'led ' + color;
            setTimeout(() => {
                if (el.leds[name]) el.leds[name].className = 'led';
            }, 2000);
        }
    });
}

function gameOver(reason) {
    if (gameState.isGameOver) return;
    gameState.isGameOver = true;

    // Останавливаем все таймеры
    clearInterval(gameLoopInterval);
    clearInterval(timeUpdateInterval);

    alert(`💀 ${reason}\nВы прожили до ${el.time.textContent}`);
    window.location.href = '/'; // Перенаправление в меню
}

// ========== ИГРОВОЙ ЦИКЛ ==========

function advanceHour() {
    if (gameState.isGameOver) return;

    // Увеличиваем час
    gameState.time += 1;
    updateTime();

    // Проверка победы
    if (gameState.time >= 6) {
        clearInterval(gameLoopInterval);
        clearInterval(timeUpdateInterval);
        setTimeout(() => {
            alert(`🎉 Ночь ${gameState.night} пройдена!`);
            window.location.href = '/';
        }, 500);
        return;
    }

    // Расход энергии за час
    gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_PER_HOUR);
    updatePower();

    // Проверка на Game Over
    if (gameState.power <= 0) {
        clearInterval(gameLoopInterval);
        clearInterval(timeUpdateInterval);
        setTimeout(() => {
            gameOver('⚡ Энергия закончилась!');
        }, 500);
        return;
    }

    // Двигаем аниматроников
    moveAnimatronics();

    console.log(`⏰ ${gameState.time}:00 AM, Энергия: ${Math.round(gameState.power)}%`);
}

// ========== ИНИЦИАЛИЗАЦИЯ ==========

function initGame() {
    // Загружаем данные из PHP (переданы через window.gameConfig)
    if (window.gameConfig && window.gameConfig.night) {
        gameState.night = window.gameConfig.night;
    }

    // Инициализация
    updateTime();
    updatePower();
    switchCamera('show');

    // Запускаем игровой цикл
    gameLoopInterval = setInterval(advanceHour, CONFIG.HOUR_DURATION);

    // Эффект статики
    setInterval(() => {
        const overlay = document.querySelector('.static-overlay');
        if (overlay) {
            overlay.style.opacity = 0.2 + Math.random() * 0.6;
        }
    }, 1200);

    // Обновление энергии каждую секунду (для плавности полоски)
    setInterval(() => {
        updatePower();
    }, 1000);

    console.log('🎮 FNAF 1 - Ночь', gameState.night);
    console.log('⏰ Длительность часа:', CONFIG.HOUR_DURATION / 1000, 'сек');
    console.log('⏱️ Общая длительность:', (CONFIG.HOUR_DURATION * 6) / 1000 / 60, 'минут');
}

// ========== ОБРАБОТЧИКИ СОБЫТИЙ ==========

// Ждём загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
    // Назначаем обработчики
    el.cameraBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (!gameState.isGameOver) switchCamera(btn.dataset.camera);
        });
    });

    el.leftDoor.addEventListener('click', () => toggleDoor('left'));
    el.rightDoor.addEventListener('click', () => toggleDoor('right'));
    el.leftLight.addEventListener('click', () => toggleLight('left'));
    el.rightLight.addEventListener('click', () => toggleLight('right'));

    // Запускаем игру
    initGame();
});
