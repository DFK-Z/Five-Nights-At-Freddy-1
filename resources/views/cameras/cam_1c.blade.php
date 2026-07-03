<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="cove-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 50% 30%, rgba(60,20,10,0.2), transparent 60%),
            linear-gradient(180deg, #100805 0%, #0a0603 70%, #060402 100%);
        position:relative; display:flex; flex-direction:column; justify-content:flex-end;
    ">
        {{-- пол --}}
        <div style="
            position:absolute; bottom:0; left:0; width:100%; height:32%;
            background-image:
                linear-gradient(45deg, #1a1005 25%, transparent 25%),
                linear-gradient(-45deg, #1a1005 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #1a1005 75%),
                linear-gradient(-45deg, transparent 75%, #1a1005 75%);
            background-size: 36px 36px;
            background-color: #0e0803;
            opacity: 0.6;
            transform: perspective(180px) rotateX(32deg);
            transform-origin: bottom;
        "></div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#553311; font-size:11px; letter-spacing:4px; z-index:3;">
            ★ ✦ PIRATE COVE ✦ ★
        </div>

        <div style="position:relative; z-index:2; display:flex; justify-content:center; align-items:flex-end; height:100%; padding-bottom:16%;">

            @if($foxy_stage == 1)
                {{-- СТАДИЯ 1: занавес закрыт, Фокси спит --}}
                <div style="text-align:center;">
                    <div style="
                        width:140px; height:150px;
                        background: repeating-linear-gradient(90deg, #4a1010 0 14px, #5a1818 14px 28px);
                        border-radius: 6px 6px 0 0;
                        box-shadow: 0 0 20px rgba(0,0,0,0.7);
                        display:flex; align-items:flex-end; justify-content:center;
                    ">
                        <div style="color:#7a4a3a; font-size:10px; padding-bottom:6px; animation: zzzPulse 2s infinite;">💤 zzz...</div>
                    </div>
                    <div style="color:#664433; font-size:10px; letter-spacing:2px; margin-top:6px;">🎭 ЗАНАВЕС ЗАКРЫТ</div>
                </div>

            @elseif($foxy_stage == 2)
                {{-- СТАДИЯ 2: занавес приоткрыт, выглядывает --}}
                <div style="text-align:center; position:relative;">
                    <div style="
                        width:140px; height:150px;
                        background: repeating-linear-gradient(90deg, #4a1010 0 14px, #5a1818 14px 28px);
                        border-radius: 6px 6px 0 0;
                        box-shadow: 0 0 20px rgba(0,0,0,0.7);
                        clip-path: polygon(0 0, 30% 0, 30% 100%, 0 100%, 0 0, 70% 0, 100% 0, 100% 100%, 70% 100%);
                        position:relative;
                    ">
                        <div style="position:absolute; left:32%; top:35%; font-size:26px; filter: drop-shadow(0 0 6px rgba(255,180,60,0.5));">🦊</div>
                    </div>
                    <div style="color:#aa5533; font-size:10px; letter-spacing:2px; margin-top:6px;">👀 ЧТО-ТО ШЕВЕЛИТСЯ...</div>
                </div>

            @elseif($foxy_stage == 3)
                {{-- СТАДИЯ 3: занавес открыт, Фокси готовится бежать --}}
                <div style="text-align:center; filter: drop-shadow(0 0 14px rgba(200,60,30,0.4));">
                    <div style="font-size:78px; line-height:1; transform: scaleX(-1); animation: foxyStage3Pulse 1s infinite;">🦊</div>
                    <div style="color:#cc4422; font-size:11px; letter-spacing:2px; margin-top:4px;">⚡ ГОТОВ БЕЖАТЬ!</div>
                </div>

            @else
                {{-- СТАДИЯ 4: бухта пуста, Фокси уже в коридоре --}}
                <div style="text-align:center;">
                    <div style="
                        width:140px; height:150px;
                        background: repeating-linear-gradient(90deg, #2a0a0a 0 14px, #1a0505 14px 28px);
                        border-radius: 6px 6px 0 0;
                        border: 2px dashed #331a10;
                        display:flex; align-items:center; justify-content:center;
                    ">
                        <div style="color:#331a10; font-size:12px;">🚫</div>
                    </div>
                    <div style="color:#552222; font-size:11px; letter-spacing:2px; margin-top:6px; animation: foxyPulse 0.5s infinite;">🏃 БУХТА ПУСТА!</div>
                </div>
            @endif
        </div>
    </div>
</div>
