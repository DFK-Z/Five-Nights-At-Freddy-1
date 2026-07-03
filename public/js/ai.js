// resources/js/ai.js
class AnimatronicAI {
    constructor(name, startPosition, aiLevel) {
        this.name = name;
        this.position = startPosition;
        this.aiLevel = aiLevel; // Сложность (0-20)
        this.isAttacking = false;
        this.moveTimer = 0;
        // ... другие свойства
    }

    // Метод, который вызывается каждый игровой "тик"
    update(gameState) {
        if (this.isAttacking) return;

        // Шанс на движение зависит от AI уровня
        const moveChance = this.aiLevel / 20;
        if (Math.random() < moveChance) {
            this.move(gameState);
        }
    }

    move(gameState) {
        // Логика передвижения по карте
        // 1. Определить текущую позицию
        // 2. Выбрать следующую позицию по пути к офису
        // 3. Если дошёл до двери — атаковать
        console.log(`${this.name} двигается...`);
    }

    attack(gameState) {
        this.isAttacking = true;
        // Проверка, закрыта ли дверь
        // Если закрыта — уйти обратно
        // Если открыта — вызвать Game Over
    }
}

// Создать экземпляры для каждого аниматроника
const freddy = new AnimatronicAI('freddy', 'cam_1a', 0);
const bonnie = new AnimatronicAI('bonnie', 'cam_5', 3);
// ... и так далее
