<div class="camera-content">
    <style>
        /* Основной контейнер сцены CAM 7 */
        .restroom-scene {
            position: relative;
            width: 100%;
            height: 450px;
            background-color: #0b0b0d;
            /* Имитация текстуры грязных стен и окружения из Restroom.jfif */
            background-image:
                linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.85)),
                radial-gradient(circle at 30% 50%, transparent 20%, #000 80%);
            border: 4px solid #222;
            overflow: hidden;
            font-family: 'Courier New', Courier, monospace;
            color: #fff;
        }

        /* Эффект шума старой камеры над всей сценой */
        .restroom-scene::before {
            content: " ";
            display: block;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            z-index: 10;
            background-size: 100% 4px, 6px 100%;
            pointer-events: none;
            opacity: 0.4;
        }

        /* Заголовок камеры в стиле интерфейса FNAF */
        .camera-header {
            position: absolute;
            top: 15px;
            left: 20px;
            margin: 0;
            font-size: 1.2rem;
            letter-spacing: 2px;
            text-shadow: 0 0 5px rgba(255,255,255,0.6);
            z-index: 5;
        }

        /* Знаменитый шахматный пол и панели из Restroom.jfif */
        .checkerboard-floor {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 120px;
            background-color: #1a1a1a;
            background-image:
                linear-gradient(45deg, #050505 25%, transparent 25%, transparent 75%, #050505 75%, #050505),
                linear-gradient(45deg, #050505 25%, #333 25%, #333 75%, #050505 75%, #050505);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            transform: perspective(100px) rotateX(20deg);
            transform-origin: bottom;
            opacity: 0.7;
            border-top: 5px solid #111;
        }

        /* Декорации стен: Табличка туалета из Restroom.jfif */
        .restroom-sign {
            position: absolute;
            left: 40px;
            top: 45%;
            width: 35px;
            height: 45px;
            background: #eee;
            color: #111;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: inset 0 0 5px #000;
            opacity: 0.4;
        }

        /* Декорации стен: Рисунки пиццы */
        .pizza-decor {
            position: absolute;
            left: 25px;
            top: 25%;
            font-size: 2rem;
            opacity: 0.25;
            filter: grayscale(40%);
        }

        /* Стилизация плашек аниматроников под жуткие силуэты */
        .animatronic {
            position: absolute;
            padding: 8px 15px;
            background: rgba(0, 0, 0, 0.75);
            border: 1px dashed;
            font-weight: bold;
            text-transform: uppercase;
            box-shadow: 0 0 15px rgba(0,0,0,0.9);
            z-index: 4;
            animation: glitch-flicker 4s infinite alternate;
        }

        /* Позиция Чики: Слева, у входа в туалет */
        .animatronic.chica {
            left: 15%;
            top: 50%;
            color: #ffd700;
            border-color: #ffd700;
            text-shadow: 0 0 8px #ffd700;
        }

        /* Позиция Фредди: Справа, скрывается в глубокой темноте коридора */
        .animatronic.freddy {
            right: 15%;
            top: 55%;
            color: #8b5a2b;
            border-color: #8b5a2b;
            text-shadow: 0 0 12px #ff0000; /* Красные светящиеся глаза в темноте */
            background: rgba(10, 5, 5, 0.9);
        }

        /* Нижний блок с подсказкой/атмосферой */
        .camera-hint {
            position: absolute;
            bottom: 15px;
            right: 20px;
            font-size: 0.85rem;
            color: #666;
            z-index: 5;
            animation: pulse 2.5s infinite;
        }

        /* Анимации мерцания камеры */
        @keyframes glitch-flicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { opacity: 1; filter: hue-rotate(0deg); }
            20%, 24%, 55% { opacity: 0.5; filter: drop-shadow(0 0 10px red); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }
    </style>

    <div class="camera-scene restroom-scene">
        <h3 class="camera-header">📶 RESTROOMS (CAM 7)</h3>

        <!-- Элементы окружения в стиле кадра Restroom.jfif -->
        <div class="pizza-decor">🍕</div>
        <div class="restroom-sign">🚺</div>
        <div class="checkerboard-floor"></div>

        <div class="animatronics">
            {{-- ЧИКА В ТУАЛЕТЕ (по канону слева у дверей) --}}
            @if($chica_position === 'cam_7' || $chica_position === 'restrooms')
                <div class="animatronic chica">🐤 ЧИКА</div>
            @endif

            {{-- ФРЕДДИ В ТУАЛЕТЕ (скрывается в глубине коридора справа) --}}
            @if($freddy_position === 'cam_7')
                <div class="animatronic freddy">🐻 ФРЕДДИ</div>
            @endif
        </div>

        <div class="camera-hint">💧 Капает вода... 🚽</div>
    </div>
</div>
