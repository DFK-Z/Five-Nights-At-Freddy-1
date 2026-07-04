<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="corner-scene" style="
        width:100%; height:100%;
        background: linear-gradient(180deg, #0a0a0a 0%, #050505 60%, #020202 100%);
        position:relative;
    ">
        {{-- шахматный пол сверху, вид в угол --}}
        <div style="
            position:absolute; bottom:0; left:15%; width:70%; height:55%;
            background-image:
                linear-gradient(45deg, #0a0a0a 25%, transparent 25%),
                linear-gradient(-45deg, #0a0a0a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #0a0a0a 75%),
                linear-gradient(-45deg, transparent 75%, #0a0a0a 75%);
            background-size: 30px 30px;
            background-color: #262a30;
            opacity: 0.5;
            transform: perspective(220px) rotateX(58deg) rotateZ(3deg);
            transform-origin: top;
        "></div>

        {{-- шахматный бордюр по верху стен с красной полосой --}}
        <div style="
            position:absolute; top:20%; left:0; width:100%; height:16%;
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

        {{-- постер "RULES FOR SAFETY" на правой стене --}}
        <div style="
            position:absolute; top:2%; right:14%; width:20%; height:34%;
            background: #d8d5c8; border: 2px solid #0a0a0a;
            display:flex; flex-direction:column; align-items:center; justify-content:flex-start;
            padding:4px; opacity:0.5;
        ">
            <div style="color:#222; font-size:8px; letter-spacing:1px; font-weight:bold; text-align:center;">RULES FOR SAFETY</div>
            <div style="color:#333; font-size:5px; text-align:left; margin-top:3px; line-height:1.5;">
                1. Don't run.<br>
                2. Don't yell.<br>
                3. Don't scream.<br>
                4. Stay close.<br>
                5. Don't touch Freddy.
            </div>
        </div>

        {{-- звёзды по краям --}}
        <div style="position:absolute; top:14%; left:14%; font-size:14px; opacity:0.35; color:#aaa;">✦</div>
        <div style="position:absolute; top:34%; left:22%; font-size:16px; opacity:0.4; color:#aaa;">✦</div>
        <div style="position:absolute; top:10%; right:36%; font-size:14px; opacity:0.3; color:#aaa;">✦</div>
        <div style="position:absolute; top:24%; right:6%; font-size:12px; opacity:0.35; color:#aaa;">✦</div>

        {{-- свисающие провода слева --}}
        <div style="position:absolute; top:2%; left:0; width:14%; height:60%; z-index:2; opacity:0.35;">
            <div style="width:1px; height:100%; background:#888; margin-left:20%;"></div>
            <div style="width:1px; height:80%; background:#888; margin-left:60%; margin-top:-90%;"></div>
        </div>

        {{-- разбросанные листы на правой стене --}}
        <div style="position:absolute; top:44%; right:2%; width:16%; height:40%; opacity:0.3;">
            <div style="display:flex; flex-wrap:wrap; gap:4px;">
                <div style="width:70%; height:26px; background:#c8c2b0; border:1px solid #0a0a0a; transform:rotate(-3deg);"></div>
                <div style="width:70%; height:24px; background:#c8c2b0; border:1px solid #0a0a0a; transform:rotate(2deg);"></div>
                <div style="width:70%; height:24px; background:#c8c2b0; border:1px solid #0a0a0a; transform:rotate(-2deg);"></div>
            </div>
        </div>

        {{-- мятые бумаги и лист на полу --}}
        <div style="position:absolute; bottom:30%; left:45%; z-index:2; opacity:0.4; font-size:16px;">📄</div>
        <div style="position:absolute; bottom:38%; left:52%; z-index:2; opacity:0.3; font-size:12px;">🗞️</div>
        <div style="position:absolute; bottom:38%; left:47%; z-index:2; opacity:0.3; font-size:12px;">🗞️</div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#3a3025; font-size:11px; letter-spacing:4px; z-index:5;">
            EAST HALL CORNER
        </div>

        {{-- Фредди, если он завернул в этот угол --}}
        @if($freddy_position === 'east_corner')
            <div style="position:absolute; bottom:12%; left:38%; z-index:6; text-align:center; filter: drop-shadow(0 0 14px rgba(140,90,20,0.5));">
                <div style="font-size:68px; line-height:1;">🐻</div>
                <div style="color:#cc9944; font-size:10px; letter-spacing:2px;">ФРЕДДИ</div>
            </div>
        @endif

        {{-- Чика, если она завернула в этот угол --}}
        @if($chica_position === 'east_corner')
            <div style="position:absolute; bottom:12%; left:{{ $freddy_position === 'east_corner' ? '56%' : '46%' }}; z-index:6; text-align:center; filter: drop-shadow(0 0 14px rgba(220,190,40,0.5));">
                <div style="font-size:62px; line-height:1;">🐤</div>
                <div style="color:#ccbb44; font-size:10px; letter-spacing:2px;">ЧИКА</div>
            </div>
        @endif

        @if($light_right)
            <div style="position:absolute; inset:0; background: rgba(255,255,220,0.12); z-index:7;"></div>
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#ffee99; font-size:11px; letter-spacing:2px; z-index:8;">
                💡 СВЕТ ВКЛЮЧЁН
            </div>
        @endif

        @if($freddy_position !== 'east_corner' && $chica_position !== 'east_corner')
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#2a2a2a; font-size:11px; letter-spacing:1px; z-index:5;">
                ⚠️ опасный поворот...
            </div>
        @endif
    </div>
</div>
