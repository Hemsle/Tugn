import { writable } from 'svelte/store';

export const filteredExercises = writable([]);
export const searched = writable([]);
export const selectedExercise = writable(null);