<script>
    import { seconds, isPaused, displayTime } from "$lib/stores/timerStore";

    function togglePause() {
        isPaused.update((p) => !p);
    }

    function addMinute() {
        seconds.update((s) => s + 60);
    }

    function subtractMinute() {
        seconds.update((s) => Math.max(0, s - 60));
    }
</script>

<div class="timer-container">
    <div class="controls">
        <button onclick={subtractMinute}>-1m</button>

        <div class="time {$isPaused ? 'paused' : ''}">
            {$displayTime}
        </div>

        <button onclick={addMinute}>+1m</button>
        
        <button onclick={togglePause}>
            {#if $isPaused}
                <img 
                    src="/icons/play.png" 
                    alt="Resume" 
                    class="control-icon" 
                />
            {:else}
                <img 
                    src="/icons/pause.png" 
                    alt="Pause" 
                    class="control-icon" 
                />
            {/if}
        </button>
    </div>
</div>

<style lang="scss">
    .timer-container {
        display: flex;
        flex-direction: row;
        align-items: center;

        .time {
            font-size: 1.6rem;
            &.paused {
                color: #ff4444;
                opacity: 0.7;
            }
        }

        .controls {
            display: flex;
            gap: 0.5rem;
            margin-left: 4rem;

            button {
                display: flex;
                align-items: center;
                font-size: 1rem;
                padding: 2px 8px;
                cursor: pointer;
                font-size: 1rem;
                .control-icon {
                    width: 1.6rem;
                }
            }
        }
    }
</style>