<div class="camera-content">
    <div class="camera-scene">
        <h3>🎭 SHOW STAGE (CAM 1A)</h3>
        <div class="animatronics">
            @if($freddy_position === 'stage')
                <div class="animatronic freddy">🐻 ФРЕДДИ</div>
            @endif
            @if($bonnie_position === 'stage')
                <div class="animatronic bonnie">🐰 БОННИ</div>
            @endif
            @if($chica_position === 'stage')
                <div class="animatronic chica">🐤 ЧИКА</div>
            @endif
        </div>
        <div class="camera-hint">🎵 Музыка играет...</div>
    </div>
</div>
