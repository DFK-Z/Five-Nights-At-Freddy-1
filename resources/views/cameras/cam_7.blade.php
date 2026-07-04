<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="restroom-scene" style="
        width:100%; height:100%;
        background: linear-gradient(180deg, #0a0a0c 0%, #050506 60%, #020203 100%);
        position:relative;
    ">
        {{-- основной пол в шахматку, уходящий в перспективу по коридору --}}
        <div style="
            position:absolute; bottom:0; left:0; width:100%; height:42%;
            background-image:
                linear-gradient(45deg, #d8dde3 25%, transparent 25%),
                linear-gradient(-45deg, #d8dde3 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #d8dde3 75%),
                linear-gradient(-45deg, transparent 75%, #d8dde3 75%);
            background-size: 34px 34px;
            background-color: #14171b;
            background-position: 0 0, 0 17px, 17px -17px, -17px 0px;
            opacity: 0.35;
            transform: perspective(200px) rotateX(35deg);
            transform-origin: bottom;
        "></div>

        {{-- дверной проём слева в ещё одну плиточную комнату (как на референсе) --}}
        <div style="
            position:absolute; top:6%; left:6%; width:26%; height:70%;
            background: linear-gradient(180deg, #1a1e24, #0a0c0e);
            border: 3px solid #050505;
            box-shadow: inset 0 0 30px rgba(0,0,0,0.8);
        ">
            <div style="
                position:absolute; bottom:0; left:0; width:100%; height:45%;
                background-image:
                    linear-gradient(45deg, #cfd6dd 25%, transparent 25%),
                    linear-gradient(-45deg, #cfd6dd 25%, transparent 25%),
                    linear-gradient(45deg, transparent 75%, #cfd6dd 75%),
                    linear-gradient(-45deg, transparent 75%, #cfd6dd 75%);
                background-size: 22px 22px;
                background-color: #1a1e24;
                opacity: 0.4;
            "></div>
        </div>

        {{-- табличка туалета на стене --}}
        <div style="
            position:absolute; top:52%; left:3%;
            width:26px; height:34px;
            background:#c8ccd0; border:1px solid #050505;
            display:flex; align-items:center; justify-content:center;
            font-size:16px; opacity:0.5;
        ">🚺</div>

        {{-- декор: кусок пиццы и круглые "тарелки" на стене, как на фото --}}
        <div style="position:absolute; top:8%; left:2%; font-size:22px; opacity:0.3; filter: grayscale(0.5);">🍕</div>
        <div style="position:absolute; top:78%; left:5%; font-size:20px; opacity:0.25; filter: grayscale(0.5);">🍕</div>
        <div style="position:absolute; top:10%; left:38%; width:34px; height:34px; border-radius:50%; border:2px solid #3a3a3a; opacity:0.3;"></div>
        <div style="position:absolute; top:16%; left:47%; width:26px; height:26px; border-radius:50%; border:2px solid #3a3a3a; opacity:0.25;"></div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#333333; font-size:11px; letter-spacing:4px; z-index:5;">
            RESTROOMS
        </div>

        {{-- Чика — у входа, слева --}}
        @if($chica_position === 'cam_7' || $chica_position === 'restrooms')
            <div style="position:absolute; bottom:20%; left:24%; z-index:4; text-align:center; filter: drop-shadow(0 0 14px rgba(220,190,40,0.5));">
                <div style="font-size:68px; line-height:1;">🐤</div>
                <div style="color:#ccbb44; font-size:10px; letter-spacing:2px;">ЧИКА</div>
            </div>
        @endif

        {{-- Фредди — едва виден в глубине тёмного коридора справа, только силуэт --}}
        @if($freddy_position === 'cam_7')
            <div style="position:absolute; bottom:24%; right:12%; z-index:4; text-align:center; opacity:0.55; filter: grayscale(0.6) drop-shadow(0 0 10px rgba(255,30,30,0.5));">
                <div style="font-size:56px; line-height:1;">🐻</div>
                <div style="color:#553322; font-size:9px; letter-spacing:2px;">●  ●</div>
            </div>
        @endif

        <div style="position:absolute; bottom:4%; right:4%; color:#3a3a3a; font-size:11px; letter-spacing:1px; z-index:5;">
            💧 капает вода...
        </div>
    </div>
</div>
