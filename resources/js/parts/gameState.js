// ============================================================
//  СОСТОЯНИЕ ИГРЫ
// ============================================================

export const gameState = {
    night: 0,                // Текущая ночь (устанавливается из PHP)
    time: 0,                 // 0 = 12:00 AM, 1 = 1:00 AM, ... 6 = 6:00 AM
    power: 100,
    isGameOver: false,
    currentCamera: 'cam_1a',
    leftDoorClosed: false,
    rightDoorClosed: false,
    isTabletMode: true,      // true = планшет поднят
    isLightOn: false,        // включён ли свет (для usage)
    gameLoopInterval: null
};
