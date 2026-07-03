// ============================================================
//  ОБНОВЛЕНИЕ ИНТЕРФЕЙСА (UI)
// ============================================================

import { gameState } from './gameState.js';

// DOM-элементы (будут переданы из game.js)
let el = {};

export function setElements(elements) {
    el = elements;
}

export function updateTime() {
    const hours = 12 + gameState.time;
    const ampm = hours >= 12 ? 'AM' : 'PM';
    const displayHours = hours > 12 ? hours - 12 : hours;
    el.time.textContent = `${displayHours}:00 ${ampm}`;
}

export function updatePower() {
    const p = Math.round(gameState.power);
    el.powerLevel.textContent = p;
    el.powerDisplay.textContent = p + '%';
    el.powerBar.style.width = p + '%';

    const isLow = p < 20;
    const isMedium = p >= 20 && p < 50;
    el.powerLevel.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
    el.powerDisplay.style.color = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
    el.powerBar.style.background = isLow ? '#ff4444' : isMedium ? '#ffaa44' : '#44ff44';
}

export function updateUsage() {
    const bars = el.usageBars;
    if (!bars) return;

    let actions = 0;
    if (gameState.leftDoorClosed) actions++;
    if (gameState.rightDoorClosed) actions++;
    if (gameState.isTabletMode) actions++;
    if (gameState.isLightOn) actions++;

    let activeBars = 0;
    if (actions === 0) activeBars = 1;
    else if (actions === 1) activeBars = 2;
    else if (actions === 2) activeBars = 3;
    else if (actions >= 3) activeBars = 4;

    bars.forEach((bar, index) => {
        bar.classList.remove('active');
        if (index < activeBars) {
            bar.classList.add('active');
        }
    });
}

export function updateAnimatronicIndicator(name, position) {
    const led = el.leds[name];
    if (!led) return;

    if (position.includes('office')) {
        led.className = 'led red';
    } else if (position.includes('cam_') && position !== 'cam_1a') {
        led.className = 'led orange';
    } else {
        led.className = 'led green';
    }
}
