import { writable } from 'svelte/store';
import { seconds, resetGlobalTimer, stopGlobalTimer } from './timerStore';

// Hämta initialt värde från localStorage om det finns
const storedWorkout = typeof window !== 'undefined' ? localStorage.getItem('active_workout') : null;

export const workout = writable(storedWorkout ? JSON.parse(storedWorkout) : null);

// Prenumerera på ändringar och spara till localStorage
if (typeof window !== 'undefined') {
    workout.subscribe(value => {
        if (value) {
            localStorage.setItem('active_workout', JSON.stringify(value));
        } else {
            localStorage.removeItem('active_workout');
        }
    });
}

export function discardWorkout() {
    workout.set(null);
    localStorage.removeItem('active_workout');
    resetGlobalTimer();
    stopGlobalTimer();
}