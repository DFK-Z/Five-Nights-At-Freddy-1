<div class="camera-content">
    <div class="camera-scene">
        <h3>🔊 KITCHEN (CAM 6)</h3>
        <div class="kitchen-audio">
            <div class="audio-icon">🔊</div>
            <div class="audio-status">АУДИО-ФИД АКТИВЕН</div>
            <div class="audio-cues">
                @if($chica_position === 'kitchen')
                    <div class="audio-cue">🔴 Слышны шаги на кухне...</div>
                @else
                    <div class="audio-cue">⚪ Тишина на кухне</div>
                @endif
            </div>
        </div>
        <div class="camera-hint">📹 ВИДЕО ОТКЛЮЧЕНО</div>
    </div>
</div>
