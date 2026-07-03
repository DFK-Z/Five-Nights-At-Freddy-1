<div class="camera-content">
    <div class="camera-scene">
        <h3>🔊 KITCHEN (CAM 6)</h3>
        <div class="kitchen-audio">
            <div class="audio-icon">🔊</div>
            <div class="audio-status">АУДИО-ФИД АКТИВЕН</div>
            <div class="audio-cues">
                {{-- ЧИКА РАЗГРОМИЛА КУХНЮ — СЛЫШНЫ ШАГИ И ЗВУКИ ПОСУДЫ --}}
                @if($chica_position === 'cam_6')
                    <div class="audio-cue">🔴 Слышны шаги и звон посуды на кухне...</div>
                    <div class="audio-cue" style="color: #cc8844; font-size: 11px; margin-top: 4px;">🍳 Чика здесь!</div>
                @elseif($chica_position === 'kitchen' || $chica_position === 'dining_area')
                    <div class="audio-cue">🔴 Слышны шаги на кухне...</div>
                @else
                    <div class="audio-cue">⚪ Тишина на кухне</div>
                @endif
            </div>
        </div>
        <div class="camera-hint">📹 ВИДЕО ОТКЛЮЧЕНО</div>
    </div>
</div>
