<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="stage-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 50% 20%, rgba(80,50,10,0.25), transparent 60%),
            linear-gradient(180deg, #120a06 0%, #0a0603 70%, #060402 100%);
        position:relative; display:flex; flex-direction:column; justify-content:flex-end;
    ">
        {{-- шахматный пол сцены --}}
        <div style="
            position:absolute; bottom:0; left:0; width:100%; height:35%;
            background-image:
                linear-gradient(45deg, #1a1005 25%, transparent 25%),
                linear-gradient(-45deg, #1a1005 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1005 75%),
                linear-gradient(-45deg, transparent 75%, #1a1005 75%);
            background-size: 40px 40px;
            background-color: #0e0803;
            background-position: 0 0, 0 20px, 20px -20px, -20px 0px;
            opacity: 0.7;
            transform: perspective(200px) rotateX(35deg);
            transform-origin: bottom;
        "></div>

        {{-- занавес --}}
        <div style="position:absolute; top:0; left:0; width:100%; height:30%;
            background: repeating-linear-gradient(90deg, #2a0a0a 0 20px, #3a1010 20px 40px);
            opacity:0.5;"></div>

        <div style="position:relative; z-index:2; display:flex; justify-content:center; align-items:flex-end; gap:40px; padding-bottom:18%; height:100%;">

            @if($bonnie_position === 'stage')
                <div style="text-align:center; filter: drop-shadow(0 0 12px rgba(80,20,90,0.4));">
                    <div style="font-size:64px; line-height:1;">🐰</div>
                    <div style="color:#8855aa; font-size:10px; letter-spacing:2px; margin-top:4px;">БОННИ</div>
                </div>
            @endif

            @if($freddy_position === 'stage')
                <div style="text-align:center; filter: drop-shadow(0 0 16px rgba(140,90,20,0.5));">
                    <div style="font-size:80px; line-height:1;">🐻</div>
                    <div style="color:#cc9944; font-size:11px; letter-spacing:2px; margin-top:4px;">ФРЕДДИ</div>
                </div>
            @endif

            @if($chica_position === 'stage')
                <div style="text-align:center; filter: drop-shadow(0 0 12px rgba(180,150,20,0.4));">
                    <div style="font-size:64px; line-height:1;">🐤</div>
                    <div style="color:#bbaa33; font-size:10px; letter-spacing:2px; margin-top:4px;">ЧИКА</div>
                </div>
            @endif

            @if($bonnie_position !== 'stage' && $chica_position !== 'stage' && $freddy_position === 'stage')
                <div style="position:absolute; color:#552222; font-size:11px; letter-spacing:1px; bottom:-6px;">
                    ⚠ сцена частично пуста
                </div>
            @endif
        </div>

        <div style="position:absolute; top:10px; left:0; width:100%; text-align:center; color:#553311; font-size:11px; letter-spacing:4px; z-index:2;">
            ★ ✦ SHOW STAGE ✦ ★
        </div>
    </div>
</div>
