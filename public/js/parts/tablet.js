// ============================================================
//  УПРАВЛЕНИЕ ПЛАНШЕТОМ
// ============================================================

import { gameState } from './gameState.js';
import { switchCamera } from './camera.js';
import { updateUsage } from './ui.js';

let el = {};

export function setElements(elements) {
    el = elements;
}

export function toggleTablet() {
    gameState.isTabletMode = !gameState.isTabletMode;

    if (gameState.isTabletMode) {
        el.container.classList.remove('office-mode');
        el.container.classList.add('tablet-mode');
        el.tabletToggle.textContent = '📱 ОПУСТИТЬ ПЛАНШЕТ';
        el.tabletToggle.classList.remove('office-mode-btn');
        el.tabletToggle.style.borderColor = '#ffaa44';
        el.tabletToggle.style.color = '#ffaa44';

        el.cameraBtns.forEach(btn => {
            btn.classList.remove('disabled');
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        });

        el.leftDoor.classList.add('disabled');
        el.rightDoor.classList.add('disabled');
        el.leftLight.classList.add('disabled');
        el.rightLight.classList.add('disabled');

        switchCamera(gameState.currentCamera);
    } else {
        el.container.classList.remove('tablet-mode');
        el.container.classList.add('office-mode');
        el.tabletToggle.textContent = '📱 ПОДНЯТЬ ПЛАНШЕТ';
        el.tabletToggle.classList.add('office-mode-btn');
        el.tabletToggle.style.borderColor = '#44ff44';
        el.tabletToggle.style.color = '#44ff44';

        el.cameraBtns.forEach(btn => {
            btn.classList.add('disabled');
            btn.style.opacity = '0.3';
            btn.style.cursor = 'not-allowed';
        });

        el.leftDoor.classList.remove('disabled');
        el.rightDoor.classList.remove('disabled');
        el.leftLight.classList.remove('disabled');
        el.rightLight.classList.remove('disabled');
    }

    updateUsage();
}
