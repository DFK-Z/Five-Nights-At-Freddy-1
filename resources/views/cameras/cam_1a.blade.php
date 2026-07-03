<div class="camera-content">
    <div class="camera-scene" style="background: #1a0a0a; padding: 40px; border-radius: 10px;">
        <h3 style="color: #ffaa44;">🎭 SHOW STAGE</h3>
        <div style="display: flex; gap: 20px; justify-content: center; margin: 20px 0;">
            @if($freddy_position === 'stage')
                <div style="background: #8B4513; padding: 15px; border-radius: 5px; color: #ffd700;">🐻 ФРЕДДИ</div>
            @endif
            @if($chica_position === 'stage')
                <div style="background: #FFD700; padding: 15px; border-radius: 5px; color: #8B4513;">🐤 ЧИКА</div>
            @endif
        </div>
        <div style="color: #666; font-size: 12px;">🎵 Музыка играет...</div>
    </div>
</div>
