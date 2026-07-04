<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="hall-scene" style="
        width:100%; height:100%;
        background: linear-gradient(180deg, #0a0806 0%, #050403 55%, #020202 100%);
        position:relative;
    ">
        {{-- уходящий вдаль коридор: более светлый прямоугольник по центру создаёт перспективу --}}
        <div style="
            position:absolute; top:8%; left:32%; width:36%; height:78%;
            background: linear-gradient(180deg, #0d0a08 0%, #050403 70%, #020101 100%);
            box-shadow: inset 0 0 40px rgba(0,0,0,0.8);
        "></div>

        {{-- шахматный пол, уходящий в перспективу по центральному коридору --}}
        <div style="
            position:absolute; bottom:0; left:30%; width:40%; height:55%;
            background-image:
                linear-gradient(45deg, #4a1f1f 25%, transparent 25%),
                linear-gradient(-45deg, #4a1f1f 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #4a1f1f 75%),
                linear-gradient(-45deg, transparent 75%, #4a1f1f 75%);
            background-size: 26px 26px;
            background-color: #d8d0c8;
            opacity: 0.5;
            transform: perspective(220px) rotateX(45deg);
            transform-origin: bottom;
        "></div>

        {{-- лампа в конце коридора --}}
        <div style="
            position:absolute; top:10%; left:50%; transform:translateX(-50%);
            width:34px; height:16px; border-radius:0 0 50% 50%;
            background: radial-gradient(ellipse at 50% 0%, #fff6d0 0%, #cc9944 60%, transparent 80%);
            box-shadow: 0 20px 40px 10px rgba(255,220,140,0.25);
            z-index:3;
        "></div>

        {{-- силуэты раковин в глубине коридора --}}
        <div style="position:absolute; top:38%; left:42%; width:8%; height:10%; background:#1a1614; border:1px solid #0a0806; z-index:2;"></div>
        <div style="position:absolute; top:38%; left:52%; width:8%; height:10%; background:#1a1614; border:1px solid #0a0806; z-index:2;"></div>

        {{-- звёзды-подвески слева и справа --}}
        <div style="position:absolute; top:2%; left:4%; font-size:16px; opacity:0.5; color:#ccc;">✦</div>
        <div style="position:absolute; top:8%; left:12%; font-size:12px; opacity:0.4; color:#ccc;">✦</div>
        <div style="position:absolute; top:4%; left:20%; font-size:20px; opacity:0.45; color:#ccc;">✦</div>
        <div style="position:absolute; top:3%; right:6%; font-size:16px; opacity:0.4; color:#ccc;">✦</div>
        <div style="position:absolute; top:9%; right:14%; font-size:12px; opacity:0.35; color:#ccc;">✦</div>

        {{-- рисунки детей на левой стене --}}
        <div style="position:absolute; top:22%; left:2%; width:20%; height:55%; z-index:2;">
            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                <div style="width:44%; height:60px; background:#e8e2d0; border:1px solid #0a0806; opacity:0.35; transform:rotate(-3deg);"></div>
                <div style="width:44%; height:60px; background:#e8e2d0; border:1px solid #0a0806; opacity:0.3; transform:rotate(2deg);"></div>
                <div style="width:44%; height:55px; background:#e8e2d0; border:1px solid #0a0806; opacity:0.3; transform:rotate(-2deg);"></div>
                <div style="width:44%; height:55px; background:#e8e2d0; border:1px solid #0a0806; opacity:0.28; transform:rotate(3deg);"></div>
            </div>
        </div>

        {{-- шахматный бордюр вдоль нижней части боковых стен --}}
        <div style="
            position:absolute; bottom:0; left:0; width:30%; height:14%;
            background-image:
                linear-gradient(45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(-45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1a1a 75%),
                linear-gradient(-45deg, transparent 75%, #1a1a1a 75%);
            background-size: 16px 16px; background-color:#ddd; opacity:0.25;
        "></div>
        <div style="
            position:absolute; bottom:0; right:0; width:30%; height:14%;
            background-image:
                linear-gradient(45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(-45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1a1a 75%),
                linear-gradient(-45deg, transparent 75%, #1a1a1a 75%);
            background-size: 16px 16px; background-color:#ddd; opacity:0.25;
        "></div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#3a3025; font-size:11px; letter-spacing:4px; z-index:5;">
            WEST HALL
        </div>

        {{-- Бонни, если пришёл в этот коридор --}}
        @if($bonnie_position === 'west_hall')
            <div style="position:absolute; bottom:14%; left:38%; z-index:4; text-align:center; filter: drop-shadow(0 0 14px rgba(100,60,200,0.5));">
                <div style="font-size:70px; line-height:1;">🐰</div>
                <div style="color:#9977dd; font-size:10px; letter-spacing:2px;">БОННИ</div>
            </div>
        @endif

        {{-- Фокси замечен здесь на 4 стадии, ещё не сорвался --}}
        @if($foxy_stage == 4 && !$foxy_running)
            <div style="position:absolute; bottom:14%; left:38%; z-index:4; text-align:center; filter: drop-shadow(0 0 16px rgba(200,60,30,0.5));">
                <div style="font-size:74px; line-height:1; transform: scaleX(-1);">🦊</div>
                <div style="color:#cc4422; font-size:11px; letter-spacing:2px;">⚠ ЗАМЕЧЕН</div>
            </div>
        @elseif($foxy_running)
            {{-- Фокси уже бежит прямо на камеру, к офису --}}
            <div style="position:absolute; bottom:6%; left:50%; transform:translateX(-50%) scaleX(-1); z-index:6; text-align:center; filter: drop-shadow(0 0 24px rgba(255,30,10,0.8));">
                <div style="font-size:150px; line-height:1;">🦊</div>
            </div>
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#ff2222; font-size:14px; letter-spacing:2px; z-index:6;">
                💨 ОН БЕЖИТ ПРЯМО СЮДА!
            </div>
        @endif
    </div>
</div>
