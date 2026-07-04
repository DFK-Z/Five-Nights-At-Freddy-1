<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="cove-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 50% 30%, rgba(50,40,90,0.25), transparent 60%),
            linear-gradient(180deg, #0a0714 0%, #060510 70%, #030308 100%);
        position:relative; display:flex; flex-direction:column; justify-content:flex-end;
    ">
        {{-- пол --}}
        <div style="
            position:absolute; bottom:0; left:0; width:100%; height:32%;
            background-image:
                linear-gradient(45deg, #12101f 25%, transparent 25%),
                linear-gradient(-45deg, #12101f 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #12101f 75%),
                linear-gradient(-45deg, transparent 75%, #12101f 75%);
            background-size: 36px 36px;
            background-color: #0a0814;
            opacity: 0.6;
            transform: perspective(180px) rotateX(32deg);
            transform-origin: bottom;
        "></div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#4a4470; font-size:11px; letter-spacing:4px; z-index:3;">
            ★ ✦ PIRATE COVE ✦ ★
        </div>

        <div style="position:relative; z-index:2; display:flex; justify-content:center; align-items:flex-end; height:100%; padding-bottom:16%;">

            @if($foxy_stage == 1)
                {{-- СТАДИЯ 1: занавес закрыт, Фокси спит --}}
                <div style="text-align:center;">
                    <div style="
                        width:140px; height:150px;
                        background: repeating-linear-gradient(90deg, #241a40 0 14px, #2e2450 14px 28px);
                        border-radius: 6px 6px 0 0;
                        box-shadow: 0 0 20px rgba(0,0,0,0.7);
                        display:flex; align-items:flex-end; justify-content:center;
                    ">
                        <div style="color:#6a5f9a; font-size:10px; padding-bottom:6px; animation: zzzPulse 2s infinite;">💤 zzz...</div>
                    </div>
                    <div style="color:#5a5088; font-size:10px; letter-spacing:2px; margin-top:6px;">🎭 ЗАНАВЕС ЗАКРЫТ</div>
                </div>

            @elseif($foxy_stage == 2)
                {{-- СТАДИЯ 2: занавес приоткрыт, выглядывает --}}
                <div style="text-align:center; position:relative;">
                    <div style="
                        width:140px; height:150px;
                        background: repeating-linear-gradient(90deg, #241a40 0 14px, #2e2450 14px 28px);
                        border-radius: 6px 6px 0 0;
                        box-shadow: 0 0 20px rgba(0,0,0,0.7);
                        clip-path: polygon(0 0, 30% 0, 30% 100%, 0 100%, 0 0, 70% 0, 100% 0, 100% 100%, 70% 100%);
                        position:relative;
                    ">
                        <div style="position:absolute; left:32%; top:35%; font-size:26px; filter: drop-shadow(0 0 6px rgba(180,160,255,0.5));">🦊</div>
                    </div>
                    <div style="color:#7a6bb0; font-size:10px; letter-spacing:2px; margin-top:6px;">👀 ЧТО-ТО ШЕВЕЛИТСЯ...</div>
                </div>

            @elseif($foxy_stage == 3)
                {{-- СТАДИЯ 3: занавес открыт, Фокси готовится бежать --}}
                <div style="text-align:center; filter: drop-shadow(0 0 14px rgba(150,110,220,0.4));">
                    <div style="font-size:78px; line-height:1; transform: scaleX(-1); animation: foxyStage3Pulse 1s infinite;">🦊</div>
                    <div style="color:#9966cc; font-size:11px; letter-spacing:2px; margin-top:4px;">⚡ ГОТОВ БЕЖАТЬ!</div>
                </div>

            @else
                {{-- СТАДИЯ 4: бухта пуста, Фокси уже в коридоре --}}
                <div style="text-align:center;">
                    <div style="
                        width:140px; height:150px;
                        background: repeating-linear-gradient(90deg, #14101f 0 14px, #0e0a18 14px 28px);
                        border-radius: 6px 6px 0 0;
                        border: 2px dashed #221a38;
                        display:flex; align-items:center; justify-content:center;
                    ">
                        <div style="color:#221a38; font-size:12px;">🚫</div>
                    </div>
                    <div style="color:#4a3a70; font-size:11px; letter-spacing:2px; margin-top:6px; animation: foxyPulse 0.5s infinite;">🏃 БУХТА ПУСТА!</div>
                </div>
            @endif
        </div>
    </div>
</div>
