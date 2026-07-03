// ============================================================
//  ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
// ============================================================

export function showWarning(message) {
    // Удаляем старые предупреждения
    document.querySelectorAll('.warning-message').forEach(el => el.remove());

    const warning = document.createElement('div');
    warning.className = 'warning-message';
    warning.textContent = message;
    document.body.appendChild(warning);

    setTimeout(() => {
        if (warning.parentNode) {
            warning.remove();
        }
    }, 2000);
}

export function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}
