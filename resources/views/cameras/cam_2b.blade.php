<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="corner-scene" style="
        width:100%; height:100%;
        background: linear-gradient(180deg, #0a0a0a 0%, #050505 60%, #020202 100%);
        position:relative;
    ">
        {{-- шахматный пол сверху, как будто смотрим в угол комнаты --}}
        <div style="
            position:absolute; bottom:0; left:20%; width:65%; height:60%;
            background-image:
                linear-gradient(45deg, #0a0a0a 25%, transparent 25%),
                linear-gradient(-45deg, #0a0a0a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #0a0a0a 75%),
                linear-gradient(-45deg, transparent 75%, #0a0a0a 75%);
            background-size: 30px 30px;
            background-color: #2a2a2a;
            opacity: 0.5;
            transform: perspective(220px) rotateX(58deg) rotateZ(-4deg);
            transform-origin: top;
        "></div>

        {{-- шахматный бордюр по верху стен с красной полосой --}}
        <div style="
            position:absolute; top:22%; left:0; width:100%; height:14%;
            background-image:
                linear-gradient(45deg, #0a0a0a 25%, transparent 25%),
                linear-gradient(-45deg, #0a0a0a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #0a0a0a 75%),
                linear-gradient(-45deg, transparent 75%, #0a0a0a 75%);
            background-size: 24px 24px;
            background-color: #3a3a3a;
            opacity: 0.35;
            border-top: 2px solid #4a1515;
            border-bottom: 2px solid #4a1515;
        "></div>

        {{-- постер "LET'S PARTY!" с Фредди на левой стене --}}
        <div style="
            position:absolute; top:4%; left:6%; width:24%; height:38%;
            background: #1a1610; border: 2px solid #0a0a0a;
            display:flex; flex-direction:column; align-items:center; justify-content:flex-start;
            padding-top:6px; opacity:0.6;
        ">
            <div style="color:#998855; font-size:9px; letter-spacing:1px; font-weight:bold;">LET'S PARTY!</div>
            <div style="font-size:34px; margin-top:6px; filter: grayscale(0.3) brightness(0.7);">🐻</div>
        </div>

        {{-- звёзды на стене справа от постера --}}
        <div style="position:absolute; top:10%; left:34%; font-size:14px; opacity:0.4; color:#aaa;">✦</div>
        <div style="position:absolute; top:16%; left:38%; font-size:10px; opacity:0.3; color:#aaa;">✦</div>

        {{-- разбросанные листы/рисунки на правой стене --}}
        <div style="position:absolute; top:2%; right:4%; width:22%; height:30%; opacity:0.3;">
            <div style="display:flex; flex-wrap:wrap; gap:4px;">
                <div style="width:45%; height:26px; background:#c8c2b0; border:1px solid #0a0a0a; transform:rotate(-4deg);"></div>
                <div style="width:45%; height:26px; background:#c8c2b0; border:1px solid #0a0a0a; transform:rotate(3deg);"></div>
                <div style="width:45%; height:24px; background:#c8c2b0; border:1px solid #0a0a0a; transform:rotate(2deg);"></div>
            </div>
        </div>

        {{-- свисающие провода/швабра в углу справа --}}
        <div style="position:absolute; top:6%; right:2%; z-index:2; opacity:0.4; filter: grayscale(1) brightness(0.6);">
            <div style="font-size:30px;">🧹</div>
        </div>

        {{-- мусорный бак и мятые бумаги на полу --}}
        <div style="position:absolute; bottom:14%; left:56%; z-index:2; opacity:0.5; filter: grayscale(1) brightness(0.7);">
            <div style="font-size:26px;">🗑️</div>
        </div>
        <div style="position:absolute; bottom:20%; left:42%; z-index:2; opacity:0.35; font-size:16px;">📄</div>
        <div style="position:absolute; bottom:10%; left:36%; z-index:2; opacity:0.3; font-size:12px;">🗞️</div>
        <div style="position:absolute; bottom:8%; left:48%; z-index:2; opacity:0.3; font-size:12px;">🗞️</div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#3a3025; font-size:11px; letter-spacing:4px; z-index:5;">
            WEST HALL CORNER
        </div>

        {{-- Бонни, если он завернул в этот угол --}}
        @if($bonnie_position === 'west_corner')
            <div style="position:absolute; bottom:22%; left:44%; z-index:4; text-align:center; filter: drop-shadow(0 0 14px rgba(100,60,200,0.5));">
                <div style="font-size:66px; line-height:1;">🐰</div>
                <div style="color:#9977dd; font-size:10px; letter-spacing:2px;">БОННИ</div>
            </div>
        @endif

        @if($light_left)
            <div style="position:absolute; inset:0; background: rgba(255,255,220,0.12); z-index:6;"></div>
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#ffee99; font-size:11px; letter-spacing:2px; z-index:7;">
                💡 СВЕТ ВКЛЮЧЁН
            </div>
        @endif

        @if($bonnie_position !== 'west_corner')
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#2a2a2a; font-size:11px; letter-spacing:1px; z-index:5;">
                ⚠️ опасный поворот...
            </div>
        @endif
    </div>
</div>
