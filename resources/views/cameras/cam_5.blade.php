<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="backstage-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 70% 40%, rgba(20,40,60,0.3), transparent 65%),
            linear-gradient(180deg, #040a10 0%, #06121a 55%, #030608 100%);
        position:relative;
    ">
        {{-- текстура стены слева (потёртая штукатурка) --}}
        <div style="
            position:absolute; top:0; left:0; width:60%; height:100%;
            background:
                repeating-linear-gradient(100deg, rgba(255,255,255,0.02) 0 2px, transparent 2px 6px),
                linear-gradient(180deg, #0a1620, #050c12);
        "></div>

        {{-- полка с масками аниматроников --}}
        <div style="position:absolute; top:12%; left:22%; display:flex; gap:22px; z-index:2;">
            <div style="text-align:center; opacity:0.75;">
                <div style="font-size:34px; filter: grayscale(0.3) brightness(0.8);">🐻</div>
            </div>
            <div style="text-align:center; opacity:0.8;">
                <div style="font-size:34px; filter: grayscale(0.2) brightness(0.85);">🐤</div>
            </div>
            <div style="text-align:center; opacity:0.7;">
                <div style="font-size:30px; filter: grayscale(0.4) brightness(0.7);">🐻</div>
            </div>
        </div>

        {{-- запчасти эндоскелета в углу --}}
        <div style="position:absolute; bottom:8%; left:4%; z-index:2; opacity:0.55; filter: grayscale(0.5) brightness(0.6);">
            <div style="font-size:46px;">🦴</div>
        </div>

        {{-- Бонни, если он здесь --}}
        @if($bonnie_position === 'backstage')
            <div style="position:absolute; bottom:6%; left:30%; z-index:4; text-align:center; filter: drop-shadow(0 0 16px rgba(100,60,200,0.5));">
                <div style="font-size:82px; line-height:1;">🐰</div>
                <div style="color:#9977dd; font-size:11px; letter-spacing:2px;">БОННИ</div>
            </div>
        @endif

        {{-- дверной проём справа: свет, шахматный пол, табличка --}}
        <div style="
            position:absolute; top:0; right:0; width:40%; height:100%;
            background: linear-gradient(90deg, transparent, rgba(200,220,255,0.06));
            z-index:3;
        ">
            <div style="
                position:absolute; bottom:0; right:0; width:100%; height:55%;
                background-image:
                    linear-gradient(45deg, #dfe6ef 25%, transparent 25%),
                    linear-gradient(-45deg, #dfe6ef 25%, transparent 25%),
                    linear-gradient(45deg, transparent 75%, #dfe6ef 75%),
                    linear-gradient(-45deg, transparent 75%, #dfe6ef 75%);
                background-size: 30px 30px;
                background-color: #10171e;
                background-position: 0 0, 0 15px, 15px -15px, -15px 0px;
                opacity: 0.5;
                transform: perspective(160px) rotateX(38deg);
                transform-origin: bottom right;
            "></div>

            <div style="
                position:absolute; top:6%; right:10%;
                background:#0a1015; border:1px solid #2a3a44; color:#aabbcc;
                font-size:8px; letter-spacing:1px; padding:4px 6px;
                box-shadow: 0 0 12px rgba(150,200,255,0.15);
            ">EMPLOYEES ONLY</div>
        </div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#33445a; font-size:11px; letter-spacing:4px; z-index:5;">
            PARTS &amp; SERVICE
        </div>

        @if($bonnie_position !== 'backstage')
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#223344; font-size:11px; letter-spacing:1px; z-index:5;">
                ⚠️ тёмная комната...
            </div>
        @endif
    </div>
</div>
