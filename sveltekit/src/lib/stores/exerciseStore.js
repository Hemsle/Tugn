import { writable } from 'svelte/store';

export const filteredExercises = writable([]);
export const searched = writable(false);
export const selectedExercise = writable(null);
export const selectedExercises = writable([]);
export const addExercises = writable(null);
export const exerciseArray = writable(null); 
export const showLibrary = writable(false); 
