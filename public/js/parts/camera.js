// ============================================================
//  УПРАВЛЕНИЕ КАМЕРАМИ
// ============================================================

import { CONFIG } from './config.js';
import { gameState } from './gameState.js';
import { showWarning } from './utils.js';
import { updatePower, updateUsage } from './ui.js';
import { CONFIG } from './config.js';

let el = {};

export function setElements(elements) {
    el = elements;
}

export function switchCamera(camera) {
    if (!gameState.isTabletMode) {
        showWarning('⛔ Поднимите планшет чтобы смотреть камеры!');
        return;
    }

    if (gameState.isGameOver) return;

    gameState.currentCamera = camera;

    el.cameraBtns.forEach(btn => {
        btn.classList.toggle('active', btn.dataset.camera === camera);
    });

    const names = {
        cam_1a: 'CAM 1A — СЦЕНА',
        cam_1b: 'CAM 1B — ЗАЛ',
        cam_1c: 'CAM 1C — КОВ',
        cam_2a: 'CAM 2A — ЗАП. ХОЛЛ',
        cam_2b: 'CAM 2B — УГ. ЗАП.',
        cam_3: 'CAM 3 — ЧУЛАН',
        cam_4a: 'CAM 4A — ВОСТ. ХОЛЛ',
        cam_4b: 'CAM 4B — УГ. ВОСТ.',
        cam_5: 'CAM 5 — ЗАД. СЦ.',
        cam_6: 'CAM 6 — КУХНЯ',
        cam_7: 'CAM 7 — ТУАЛЕТ'
    };

    el.cameraLabel.textContent = names[camera] || camera;

    fetch(`/camera/${camera}`)
        .then(response => response.text())
        .then(html => {
            el.cameraImage.innerHTML = html;
        })
        .catch(() => {
            el.cameraImage.innerHTML = `
                <div style="color: #333; font-size: 24px;">📹 ${names[camera] || camera}</div>
                <div style="color: #444; font-size: 14px; margin-top: 10px;">Камера не активна</div>
            `;
        });

    if (gameState.power > 0) {
        gameState.power = Math.max(0, gameState.power - CONFIG.POWER_DRAIN_CAMERA);
        updatePower();
    }

    updateUsage();
}
