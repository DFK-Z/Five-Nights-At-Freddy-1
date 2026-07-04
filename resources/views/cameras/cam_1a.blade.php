<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="stage-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 50% 20%, rgba(60,70,90,0.2), transparent 60%),
            linear-gradient(180deg, #0a0d12 0%, #06080b 70%, #030405 100%);
        position:relative; display:flex; flex-direction:column; justify-content:flex-end;
    ">
        {{-- шахматный пол сцены --}}
        <div style="
            position:absolute; bottom:0; left:0; width:100%; height:35%;
            background-image:
                linear-gradient(45deg, #10141a 25%, transparent 25%),
                linear-gradient(-45deg, #10141a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #10141a 75%),
                linear-gradient(-45deg, transparent 75%, #10141a 75%);
            background-size: 40px 40px;
            background-color: #080a0d;
            background-position: 0 0, 0 20px, 20px -20px, -20px 0px;
            opacity: 0.7;
            transform: perspective(200px) rotateX(35deg);
            transform-origin: bottom;
        "></div>

        {{-- занавес --}}
        <div style="position:absolute; top:0; left:0; width:100%; height:30%;
            background: repeating-linear-gradient(90deg, #141a22 0 20px, #1c242e 20px 40px);
            opacity:0.5;"></div>

        <div style="position:relative; z-index:2; display:flex; justify-content:center; align-items:flex-end; gap:40px; padding-bottom:18%; height:100%;">

            @if($bonnie_position === 'stage')
                <div style="text-align:center; filter: drop-shadow(0 0 12px rgba(90,100,150,0.35));">
                    <div style="font-size:64px; line-height:1; filter: grayscale(0.4) brightness(0.85);">🐰</div>
                    <div style="color:#7788aa; font-size:10px; letter-spacing:2px; margin-top:4px;">БОННИ</div>
                </div>
            @endif

            @if($freddy_position === 'stage')
                <div style="text-align:center; filter: drop-shadow(0 0 16px rgba(120,130,160,0.35));">
                    <div style="font-size:80px; line-height:1; filter: grayscale(0.4) brightness(0.85);">🐻</div>
                    <div style="color:#99a0b0; font-size:11px; letter-spacing:2px; margin-top:4px;">ФРЕДДИ</div>
                </div>
            @endif

            @if($chica_position === 'stage')
                <div style="text-align:center; filter: drop-shadow(0 0 12px rgba(130,140,110,0.3));">
                    <div style="font-size:64px; line-height:1; filter: grayscale(0.4) brightness(0.85);">🐤</div>
                    <div style="color:#9aa088; font-size:10px; letter-spacing:2px; margin-top:4px;">ЧИКА</div>
                </div>
            @endif

            @if($bonnie_position !== 'stage' && $chica_position !== 'stage' && $freddy_position === 'stage')
                <div style="position:absolute; color:#445566; font-size:11px; letter-spacing:1px; bottom:-6px;">
                    ⚠ сцена частично пуста
                </div>
            @endif
        </div>

        <div style="position:absolute; top:10px; left:0; width:100%; text-align:center; color:#3a4552; font-size:11px; letter-spacing:4px; z-index:2;">
            ★ ✦ SHOW STAGE ✦ ★
        </div>
    </div>
</div>
