<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="hall-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 28% 0%, rgba(255,255,255,0.35), rgba(40,40,40,0.15) 35%, transparent 60%),
            linear-gradient(180deg, #0a0a0a 0%, #050505 55%, #020202 100%);
        position:relative;
    ">
        {{-- яркая лампа вверху слева, засвечивающая кадр --}}
        <div style="
            position:absolute; top:-4%; left:22%; width:16%; height:8%;
            background: radial-gradient(ellipse at 50% 0%, #fff 0%, #e8e8e8 55%, transparent 80%);
            border-radius: 0 0 50% 50%;
            box-shadow: 0 30px 60px 20px rgba(255,255,255,0.2);
            z-index:4;
        "></div>

        {{-- паутина и свисающие нити слева --}}
        <div style="position:absolute; top:5%; left:2%; width:24%; height:80%; z-index:2; opacity:0.35;">
            <div style="width:1px; height:100%; background:#888; margin-left:10%;"></div>
            <div style="width:1px; height:85%; background:#888; margin-left:20%; margin-top:-90%;"></div>
            <div style="width:1px; height:70%; background:#888; margin-left:4%; margin-top:-80%;"></div>
        </div>
        <div style="position:absolute; top:55%; left:4%; font-size:11px; opacity:0.25; color:#aaa; z-index:2;">
            ╲╱╲╱╲╱
        </div>

        {{-- звёзды-подвески --}}
        <div style="position:absolute; top:8%; left:22%; font-size:14px; opacity:0.5; color:#ccc; z-index:3;">✦</div>
        <div style="position:absolute; top:14%; left:26%; font-size:10px; opacity:0.4; color:#ccc; z-index:3;">✦</div>
        <div style="position:absolute; top:24%; left:23%; font-size:16px; opacity:0.45; color:#ccc; z-index:3;">✦</div>
        <div style="position:absolute; top:20%; left:29%; font-size:11px; opacity:0.35; color:#ccc; z-index:3;">✦</div>
        <div style="position:absolute; top:34%; left:25%; font-size:13px; opacity:0.3; color:#ccc; z-index:3;">✦</div>
        <div style="position:absolute; top:10%; left:62%; font-size:12px; opacity:0.3; color:#ccc; z-index:3;">✦</div>
        <div style="position:absolute; top:14%; left:66%; font-size:9px; opacity:0.25; color:#ccc; z-index:3;">✦</div>

        {{-- изогнутые провода/трубы, спускающиеся по коридору справа --}}
        <div style="
            position:absolute; top:0; left:66%; width:2px; height:95%;
            background:#555; opacity:0.4; z-index:2;
            border-radius:50% 0 0 50% / 20% 0 0 80%;
            transform: rotate(3deg);
        "></div>
        <div style="
            position:absolute; top:0; left:84%; width:2px; height:95%;
            background:#555; opacity:0.35; z-index:2;
            transform: rotate(-2deg);
        "></div>

        {{-- шахматный бордюр вдоль правой стены --}}
        <div style="
            position:absolute; bottom:0; right:0; width:45%; height:16%;
            background-image:
                linear-gradient(45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(-45deg, #1a1a1a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1a1a 75%),
                linear-gradient(-45deg, transparent 75%, #1a1a1a 75%);
            background-size: 20px 20px; background-color:#d8d8d8; opacity:0.3;
        "></div>

        {{-- постеры на правой стене: Фредди, Чика, Бонни --}}
        <div style="position:absolute; top:14%; right:32%; width:11%; height:38%; background:#0f0f0a; border:1px solid #050505; opacity:0.55; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; padding-bottom:4px;">
            <div style="font-size:26px; filter: grayscale(0.3) brightness(0.7);">🐻</div>
            <div style="color:#887744; font-size:7px; letter-spacing:1px;">EATING TIME!</div>
        </div>
        <div style="position:absolute; top:10%; right:20%; width:11%; height:44%; background:#0a0f0a; border:1px solid #050505; opacity:0.55; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; padding-bottom:4px;">
            <div style="font-size:26px; filter: grayscale(0.3) brightness(0.7);">🐤</div>
            <div style="color:#778844; font-size:7px; letter-spacing:1px;">FUN TIME!</div>
        </div>
        <div style="position:absolute; top:14%; right:4%; width:12%; height:40%; background:#100a14; border:1px solid #050505; opacity:0.55; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; padding-bottom:4px;">
            <div style="font-size:26px; filter: grayscale(0.3) brightness(0.7);">🐰</div>
            <div style="color:#886699; font-size:7px; letter-spacing:1px;">PARTY TIME!</div>
        </div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#3a3a3a; font-size:11px; letter-spacing:4px; z-index:5;">
            EAST HALL
        </div>

        {{-- Фредди, если он в этом коридоре --}}
        @if($freddy_position === 'east_hall')
            <div style="position:absolute; bottom:10%; left:46%; z-index:6; text-align:center; filter: drop-shadow(0 0 14px rgba(140,90,20,0.5));">
                <div style="font-size:74px; line-height:1;">🐻</div>
                <div style="color:#cc9944; font-size:10px; letter-spacing:2px;">ФРЕДДИ</div>
            </div>
        @endif

        {{-- Чика, если она в этом коридоре --}}
        @if($chica_position === 'east_hall')
            <div style="position:absolute; bottom:10%; left:{{ $freddy_position === 'east_hall' ? '62%' : '46%' }}; z-index:6; text-align:center; filter: drop-shadow(0 0 14px rgba(220,190,40,0.5));">
                <div style="font-size:68px; line-height:1;">🐤</div>
                <div style="color:#ccbb44; font-size:10px; letter-spacing:2px;">ЧИКА</div>
            </div>
        @endif

        @if($freddy_position !== 'east_hall' && $chica_position !== 'east_hall')
            <div style="position:absolute; bottom:4%; left:0; width:100%; text-align:center; color:#2a2a2a; font-size:11px; letter-spacing:1px; z-index:5;">
                ➡️ правый коридор...
            </div>
        @endif
    </div>
</div>
