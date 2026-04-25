import { writable, derived } from 'svelte/store';

const storedSeconds = typeof window !== 'undefined' ? localStorage.getItem('timer_seconds') : 0;

export const seconds = writable(storedSeconds ? parseInt(storedSeconds) : 0);
export const isPaused = writable(false);

// Spara sekunderna vid varje tick
if (typeof window !== 'undefined') {
    seconds.subscribe(value => {
        localStorage.setItem('timer_seconds', value.toString());
    });
}

let interval;

export const startGlobalTimer = () => {
    if (interval) return; // Förhindra dubbla intervaller

    interval = setInterval(() => {
        isPaused.subscribe($paused => {
            if (!$paused) {
                seconds.update(s => s + 1);
            }
        })();
    }, 1000);
};

export const stopGlobalTimer = () => {
    clearInterval(interval);
    interval = null;
};

export const resetGlobalTimer = () => {
    seconds.set(0);
};

// Formaterad tid som en derived store: HH:MM:SS
export const displayTime = derived(seconds, ($seconds) => {
    const h = Math.floor($seconds / 3600).toString().padStart(2, '0');
    const m = Math.floor(($seconds % 3600) / 60).toString().padStart(2, '0');
    const s = ($seconds % 60).toString().padStart(2, '0');
    return `${h}:${m}:${s}`;
});