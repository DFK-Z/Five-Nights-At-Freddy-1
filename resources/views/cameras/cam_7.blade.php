<div class="camera-content">
    <div class="camera-scene">
        <h3>🚻 RESTROOMS (CAM 7)</h3>
        <div class="animatronics" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            {{-- ЧИКА В ТУАЛЕТЕ (по канону) --}}
            @if($chica_position === 'cam_7' || $chica_position === 'restrooms')
                <div class="animatronic chica">🐤 ЧИКА</div>
            @endif

            {{-- ФРЕДДИ В ТУАЛЕТЕ (перед тем как идти в кухню) --}}
            @if($freddy_position === 'cam_7')
                <div class="animatronic freddy">🐻 ФРЕДДИ</div>
            @endif

            {{-- БОННИ ТОЖЕ МОЖЕТ ЗАГЛЯНУТЬ В ТУАЛЕТЫ (редко) --}}
            @if($bonnie_position === 'cam_7')
                <div class="animatronic bonnie">🐰 БОННИ</div>
            @endif
        </div>
        <div class="camera-hint">💧 Капает вода... 🚽</div>
    </div>
</div>
