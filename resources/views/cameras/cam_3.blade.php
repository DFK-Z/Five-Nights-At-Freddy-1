<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="closet-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 15% 55%, rgba(220,220,220,0.15), transparent 45%),
            linear-gradient(180deg, #0c0c0c 0%, #050505 60%, #020202 100%);
        position:relative;
    ">
        {{-- шахматный потолок/пол под наклонным ракурсом сверху --}}
        <div style="
            position:absolute; top:0; left:15%; width:60%; height:55%;
            background-image:
                linear-gradient(45deg, #1c1c1c 25%, transparent 25%),
                linear-gradient(-45deg, #1c1c1c 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1c1c1c 75%),
                linear-gradient(-45deg, transparent 75%, #1c1c1c 75%);
            background-size: 34px 34px;
            background-color: #0a0a0a;
            opacity: 0.55;
            transform: perspective(200px) rotateX(55deg) rotateZ(-8deg);
            transform-origin: top left;
        "></div>

        {{-- стеллаж с коробками слева --}}
        <div style="position:absolute; top:5%; left:2%; width:22%; height:85%; z-index:2;">
            <div style="display:flex; flex-direction:column; gap:8%; height:100%; justify-content:space-between;">
                @for ($i = 0; $i < 5; $i++)
                    <div style="display:flex; gap:4px;">
                        <div style="width:60%; height:22px; background:#2a2a2a; border:1px solid #1a1a1a;"></div>
                        <div style="width:35%; height:22px; background:#232323; border:1px solid #1a1a1a;"></div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- швабра и ведро в углу --}}
        <div style="position:absolute; top:22%; left:44%; z-index:2; opacity:0.6; filter: grayscale(1) brightness(0.7);">
            <div style="font-size:38px;">🧹</div>
        </div>
        <div style="position:absolute; top:40%; left:52%; z-index:2; opacity:0.5; filter: grayscale(1) brightness(0.6);">
            <div style="font-size:30px;">🪣</div>
        </div>

        {{-- свисающие трубы справа --}}
        <div style="position:absolute; top:0; left:56%; width:2px; height:45%; background:#1a1a1a; z-index:2;"></div>
        <div style="position:absolute; top:0; left:66%; width:2px; height:38%; background:#1a1a1a; z-index:2; transform: rotate(4deg);"></div>

        {{-- яркий фонарь/лампа слева, засвечивающая кадр --}}
        <div style="
            position:absolute; top:48%; left:8%;
            width:90px; height:90px;
            background: radial-gradient(circle, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.4) 45%, transparent 75%);
            border-radius:50%;
            z-index:3;
            filter: blur(1px);
        "></div>

        {{-- Бонни, если он в чулане --}}
        @if($bonnie_position === 'closet')
            <div style="position:absolute; bottom:10%; left:38%; z-index:4; text-align:center; filter: grayscale(0.4) drop-shadow(0 0 16px rgba(150,150,255,0.35));">
                <div style="font-size:72px; line-height:1;">🐰</div>
                <div style="color:#9999cc; font-size:10px; letter-spacing:2px;">БОННИ</div>
            </div>
        @endif

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#3a3a3a; font-size:11px; letter-spacing:4px; z-index:5;">
            SUPPLY CLOSET
        </div>

        @if($bonnie_position !== 'closet')
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#2a2a2a; font-size:11px; letter-spacing:1px; z-index:5;">
                🧹 пыльный чулан...
            </div>
        @endif
    </div>
</div>
