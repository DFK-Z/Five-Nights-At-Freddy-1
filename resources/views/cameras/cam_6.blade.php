<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden; background:#050505;">
    <div class="kitchen-scene" style="width:100%; height:100%; position:relative;">

        {{-- шумовая текстура на весь экран, имитация "видео отключено" --}}
        <div style="
            position:absolute; inset:0;
            background-image:
                repeating-linear-gradient(0deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 3px),
                repeating-linear-gradient(90deg, rgba(255,255,255,0.02) 0 2px, transparent 2px 5px);
            opacity:0.7; z-index:1;
        "></div>

        {{-- красный индикатор записи --}}
        <div style="position:absolute; top:6%; left:4%; z-index:3; display:flex; align-items:center; gap:8px;">
            <div style="
                width:22px; height:22px; border-radius:50%;
                background:#dd1111; box-shadow:0 0 12px rgba(220,20,20,0.7);
                animation: kitchenRecPulse 1.4s infinite;
            "></div>
        </div>

        {{-- ночь / время передаются извне общим HUD, тут просто подпись камеры --}}
        <div style="position:absolute; top:8%; left:0; width:100%; text-align:center; z-index:3;
            font-family:'Courier New', monospace; color:#e8e8e8; letter-spacing:3px;">
            <div style="font-size:15px; opacity:0.85;">-CAMERA DISABLED-</div>
            <div style="font-size:13px; opacity:0.7; margin-top:2px;">AUDIO ONLY</div>
        </div>

        {{-- подпись комнаты --}}
        <div style="position:absolute; top:42%; left:0; width:100%; text-align:center; z-index:3;
            font-family:'Courier New', monospace; color:#666; letter-spacing:2px; font-size:16px;">
            Kitchen
        </div>

        {{-- аудио-статус и подсказки --}}
        <div style="position:absolute; bottom:16%; left:0; width:100%; text-align:center; z-index:3;
            font-family:'Courier New', monospace;">
            <div style="color:#888; font-size:10px; letter-spacing:2px; margin-bottom:8px;">
                🔊 АУДИО-ФИД АКТИВЕН
            </div>

            @if($chica_position === 'cam_6')
                <div style="color:#dd4444; font-size:12px;">🔴 Слышны шаги и звон посуды на кухне...</div>
                <div style="color:#cc8844; font-size:11px; margin-top:4px;">🍳 Чика здесь!</div>
            @elseif($chica_position === 'kitchen' || $chica_position === 'dining_area')
                <div style="color:#dd8844; font-size:12px;">🔴 Слышны шаги на кухне...</div>
            @else
                <div style="color:#444; font-size:12px;">⚪ Тишина на кухне</div>
            @endif
        </div>
    </div>
</div>
