// ============================================================
//  ГЛАВНЫЙ ФАЙЛ ИГРЫ (собирает все модули)
// ============================================================

// Импортируем все модули
import { CONFIG } from './parts/config.js';
import { gameState } from './parts/gameState.js';
import { showWarning } from './parts/utils.js';
import { setElements as setUIElements, updateTime, updatePower, updateUsage, updateAnimatronicIndicator } from './parts/ui.js';
import { setElements as setCameraElements, switchCamera } from './parts/camera.js';
import { setElements as setDoorElements, toggleDoor, toggleLight } from './parts/doors.js';
import { setElements as setTabletElements, toggleTablet } from './parts/tablet.js';

// ===== DOM-ЭЛЕМЕНТЫ =====
const el = {
    container: document.getElementById('gameContainer'),
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
    tabletToggle: document.getElementById('tabletToggle'),
    usageBars: document.querySelectorAll('.usage-bar'),
    leds: {
        freddy: document.getElementById('freddyLed'),
        bonnie: document.getElementById('bonnieLed'),
        chica: document.getElementById('chicaLed'),
        foxy: document.getElementById('foxyLed')
    }
};

// ===== ПЕРЕДАЁМ DOM-ЭЛЕМЕНТЫ ВО ВСЕ МОДУЛИ =====
setUIElements(el);
setCameraElements(el);
setDoorElements(el);
setTabletElements(el);

// ===== НАСТРАИВАЕМ gameState =====
gameState.night = window.gameConfig.night;

// ===== ИГРОВОЙ ЦИКЛ =====
let gameLoopInterval = null;

function gameOver(reason) {
    if (gameState.isGameOver) return;
    gameState.isGameOver = true;
    clearInterval(gameLoopInterval);
    alert(`💀 ${reason}\nВы прожили до ${el.time.textContent}`);
    window.location.href = '/';
}

function advanceHour() {
    if (gameState.isGameOver) return;

    gameState.time += 1;
    updateTime();

    if (gameState.time >= 6) {
        clearInterval(gameLoopInterval);
        setTimeout(() => {
            alert(`🎉 Ночь ${gameState.night} пройдена!`);
            window.location.href = '/';
        }, 500);
        return;
    }

    gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_PER_HOUR);
    updatePower();

    if (gameState.power <= 0) {
        clearInterval(gameLoopInterval);
        setTimeout(() => {
            gameOver('⚡ Энергия закончилась!');
        }, 500);
        return;
    }

    // Мигание индикаторов (заглушка для ИИ)
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

    console.log(`⏰ ${gameState.time}:00 AM, Энергия: ${Math.round(gameState.power)}%`);
}

// ===== ОБРАБОТЧИКИ СОБЫТИЙ =====
el.cameraBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        if (!gameState.isGameOver && gameState.isTabletMode) {
            switchCamera(btn.dataset.camera);
        }
    });
});

el.leftDoor.addEventListener('click', () => toggleDoor('left'));
el.rightDoor.addEventListener('click', () => toggleDoor('right'));
el.leftLight.addEventListener('click', () => toggleLight('left'));
el.rightLight.addEventListener('click', () => toggleLight('right'));
el.tabletToggle.addEventListener('click', toggleTablet);

// ===== ЗАПУСК =====
// Инициализация режима
el.container.classList.add('tablet-mode');
el.container.classList.remove('office-mode');
el.tabletToggle.textContent = '📱 ОПУСТИТЬ ПЛАНШЕТ';
el.tabletToggle.style.borderColor = '#ffaa44';
el.tabletToggle.style.color = '#ffaa44';

el.leftDoor.classList.add('disabled');
el.rightDoor.classList.add('disabled');
el.leftLight.classList.add('disabled');
el.rightLight.classList.add('disabled');

// Первоначальное обновление
updateTime();
updatePower();
switchCamera('cam_1a');
updateUsage();

// Запуск игрового цикла
gameLoopInterval = setInterval(advanceHour, CONFIG.HOUR_DURATION);

// Эффект статики
setInterval(() => {
    const overlay = document.querySelector('.static-overlay');
    if (overlay) {
        overlay.style.opacity = 0.2 + Math.random() * 0.6;
    }
}, 1200);

console.log('🎮 FNAF 1 - Ночь', gameState.night);
console.log('📹 Загружено 11 камер');
console.log('⚡ Система USAGE активирована');
