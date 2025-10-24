//routes/exercises/+page.server.js
import { json } from "@sveltejs/kit";

export async function load() {
    const apiKey = 'hSPjo6dvdgFyNfRBO7EVRQ==31s6QTzAQhWCWldf';
    let muscle = '';

    const muscleGroups = [
        'abdominals',
        'abductors',
        'adductors',
        'biceps',
        'calves',
        'chest',
        'forearms',
        'glutes',
        'hamstrings',
        'lats',
        'lower_back',
        'middle_back',
        'neck',
        'quadriceps',
        'traps',
        'triceps'
    ];

    const urls = muscleGroups.map(muscle =>
        `https://api.api-ninjas.com/v1/exercises?muscle=${muscle}`
    );

    try {
        // Kör alla fetches parallellt
        const responses = await Promise.all(
            urls.map(url =>
                fetch(url, { headers: { 'X-Api-Key': apiKey } })
            )
        );

        // Konvertera alla responses till JSON
        const results = await Promise.all(responses.map(res => res.json()));

        // Slå ihop alla resultat till en enda array
        const exercises = results.flat();

        console.log('Exercises from API:', exercises);

        // Extrahera olika delar av en övning, muskler, typ av övning...
        const muscles = [...new Set(exercises.map(ex => ex.muscle))].sort();
        const equipments = [...new Set(exercises.map(ex => ex.equipment))].sort();
        const types = [...new Set(exercises.map(ex => ex.type))].sort();
        const difficulties = [... new Set(exercises.map(ex => ex.difficulty))].sort();

        return { exercises, muscles, equipments, types, difficulties };
    } catch (err) {
        return { exercises: [], muscles: [], equipments: [], types: [], difficulties: [] };
    }
}