import { writable } from 'svelte/store';

export const filteredExercises = writable([]);
export const searched = writable([]);
export const selectedExercise = writable(null);
export const addExercises = writable(null);
export const exerciseArray = writable(null); 

export const exerciseData = writable(null);
