// ============================================================
//  УПРАВЛЕНИЕ ДВЕРЯМИ И СВЕТОМ
// ============================================================

import { gameState } from './gameState.js';
import { showWarning } from './utils.js';
import { updatePower, updateUsage } from './ui.js';
import { CONFIG } from './config.js';

let el = {};

export function setElements(elements) {
    el = elements;
}

export function toggleDoor(door) {
    if (gameState.isTabletMode) {
        showWarning('⛔ Опустите планшет чтобы управлять дверями!');
        return;
    }

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

    updateUsage();
}

export function toggleLight(door) {
    if (gameState.isTabletMode) {
        showWarning('⛔ Опустите планшет чтобы включить свет!');
        return;
    }

    if (gameState.isGameOver) return;

    gameState.isLightOn = !gameState.isLightOn;

    if (gameState.power > 0) {
        gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_LIGHT);
        updatePower();
    }

    const view = document.querySelector('.camera-view');
    view.style.boxShadow = '0 0 60px rgba(255,255,200,0.4)';
    setTimeout(() => view.style.boxShadow = 'none', 400);

    console.log(`🔦 Свет на ${door} двери ${gameState.isLightOn ? 'включён' : 'выключен'}`);
    updateUsage();
}
