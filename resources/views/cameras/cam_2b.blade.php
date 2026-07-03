<div class="camera-content">
    <div class="camera-scene">
        <h3>🚪 WEST HALL CORNER (CAM 2B)</h3>
        <div class="animatronics">
            @if($bonnie_position === 'west_corner')
                <div class="animatronic bonnie">🐰 БОННИ</div>
            @endif
        </div>
        @if($light_left)
            <div class="light-effect">💡 СВЕТ ВКЛЮЧЕН</div>
        @endif
        <div class="camera-hint">⚠️ Опасный поворот</div>
    </div>
</div>
