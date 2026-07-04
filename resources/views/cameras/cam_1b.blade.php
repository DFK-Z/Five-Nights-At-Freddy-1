<div class="camera-content" style="width:100%; height:100%; position:relative; overflow:hidden;">
    <div class="dining-scene" style="
        width:100%; height:100%;
        background:
            radial-gradient(ellipse at 50% 15%, rgba(40,50,120,0.25), transparent 60%),
            linear-gradient(180deg, #050818 0%, #0a0d28 55%, #030410 100%);
        position:relative; display:flex; flex-direction:column; justify-content:flex-end;
    ">
        {{-- пол в сине-красную шашечку --}}
        <div style="
            position:absolute; bottom:0; left:0; width:100%; height:34%;
            background-image:
                linear-gradient(45deg, #2a1030 25%, transparent 25%),
                linear-gradient(-45deg, #2a1030 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #2a1030 75%),
                linear-gradient(-45deg, transparent 75%, #2a1030 75%);
            background-size: 36px 36px;
            background-color: #1a1030;
            opacity: 0.65;
            transform: perspective(190px) rotateX(33deg);
            transform-origin: bottom;
        "></div>

        <div style="position:absolute; top:8px; left:0; width:100%; text-align:center; color:#4455aa; font-size:11px; letter-spacing:4px; z-index:3;">
            DINING AREA
        </div>

        {{-- ряд праздничных столов --}}
        <div style="position:relative; z-index:2; display:flex; justify-content:center; align-items:flex-end; gap:8%; padding-bottom:14%; height:100%;">

            @for ($i = 0; $i < 3; $i++)
                <div style="text-align:center;">
                    {{-- колпак --}}
                    <div style="
                        width:0; height:0;
                        border-left: 8px solid transparent;
                        border-right: 8px solid transparent;
                        border-bottom: 22px solid {{ $i % 2 == 0 ? '#7755cc' : '#cc4466' }};
                        margin: 0 auto 4px;
                        opacity: 0.85;
                    "></div>
                    {{-- стол --}}
                    <div style="
                        width:70px; height:14px;
                        background: linear-gradient(180deg, #e8e0f0, #b8a8d0);
                        border-radius: 2px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.5);
                    "></div>
                    {{-- ножка стола --}}
                    <div style="width:6px; height:20px; background:#0a0a15; margin:0 auto;"></div>
                </div>
            @endfor
        </div>

        {{-- Фредди, Бонни и Чика, если пришли в столовую --}}
        <div style="position:absolute; bottom:16%; left:0; width:100%; display:flex; justify-content:center; gap:60px; z-index:4;">
            @if($freddy_position === 'dining_area')
                <div style="text-align:center; filter: drop-shadow(0 0 16px rgba(140,90,20,0.5));">
                    <div style="font-size:74px; line-height:1;">🐻</div>
                    <div style="color:#cc9944; font-size:10px; letter-spacing:2px;">ФРЕДДИ</div>
                </div>
            @endif
            @if($bonnie_position === 'dining_area')
                <div style="text-align:center; filter: drop-shadow(0 0 14px rgba(100,60,200,0.5));">
                    <div style="font-size:66px; line-height:1;">🐰</div>
                    <div style="color:#9977dd; font-size:10px; letter-spacing:2px;">БОННИ</div>
                </div>
            @endif
            @if($chica_position === 'dining_area')
                <div style="text-align:center; filter: drop-shadow(0 0 14px rgba(220,190,40,0.4));">
                    <div style="font-size:66px; line-height:1;">🐤</div>
                    <div style="color:#ccbb44; font-size:10px; letter-spacing:2px;">ЧИКА</div>
                </div>
            @endif
        </div>

        @if($freddy_position !== 'dining_area' && $bonnie_position !== 'dining_area' && $chica_position !== 'dining_area')
            <div style="position:absolute; bottom:5%; left:0; width:100%; text-align:center; color:#333355; font-size:11px; letter-spacing:1px; z-index:5;">
                🍽️ пустые столы...
            </div>
        @endif
    </div>
</div>
