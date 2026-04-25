//src/lib/utils/fetchDB.js
let exercisesPromise = null; // någon cache variabel

async function loadExercises() {
        // Hämta data från php backend
        const response = await fetch('http://nginx/api/fetchExercises.php');  
        const results = await response.json();

        const rawExercises = results.exercises || [];

        const exercises = rawExercises.map(ex => ({
            ...ex,
            equipments: JSON.parse(ex.equipment_json || '[]'),
            type: ex.exercise_type 
        }));

        // Extrahera de olika delarna i muskler
        const muscles = [...new Set(exercises.map(ex => ex.muscle))].sort();
        const types = [...new Set(exercises.map(ex => ex.type))].sort();
        const difficulties = [... new Set(exercises.map(ex => ex.difficulty))];

        const equipments = [...new Set(
            exercises.flatMap(ex => ex.equipments)
        )].filter(Boolean).sort();

        return { exercises, muscles, types, difficulties, equipments };
}

export function getExercises() {
    if (exercisesPromise == null) {
        exercisesPromise = loadExercises();
    }
    return exercisesPromise;
}

export function refreshExercises() {
    exercisesPromise = null; // Clear the cache
}