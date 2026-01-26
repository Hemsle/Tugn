//$lib/utils/apiServer.js
import { json } from "@sveltejs/kit";
import { API_NINJAS_KEY } from "$env/static/private"; //hämtar nyckeln från .env miljövariabel

// Cache för Promise-objektet som håller hämtade övningar
// Används för att undvika onödiga API-anrop vid flera anrop till getExercises
let exercisesPromise = null;
const apiKey = API_NINJAS_KEY; //Sparar nyckeln till API

const muscleGroups = [// Array med de specifika muskelgrupper som vi vill hämta data för från API:et
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

/**
 * @async
 * Hämtar övningsdata från API-Ninjas för alla definierade muskelgrupper
 * Utför alla API-anrop parallellt för snabbare laddning
 * @returns {Promise<Object>} Ett Promise som löser sig till ett objekt med rådata och unika kategorier
 */
async function loadExercises() {

    const urls = muscleGroups.map(muscle =>// Mappar muskelgrupperna till en array av API-adresser
        `https://api.api-ninjas.com/v1/exercises?muscle=${muscle}`
    );

    try {
        // Kör alla fetches parallellt med Promise.all för effektivitet
        const responses = await Promise.all(
            urls.map(url =>
                fetch(url, { headers: { 'X-Api-Key': apiKey } })// Lägger till den nödvändiga API-nyckeln i headern
            )
        );

        // Konvertera alla responses till JSON
        const results = await Promise.all(responses.map(res => res.json()));

        // Slå ihop alla resultat till en enda array med alla övningar
        const exercises = results.flat();

        // Extrahera olika delar av en övning, muskler, typ av övning...
        // Extrahera unika värden (med Set) och sortera dem för att användas som filter i gränssnittet
        const muscles = [...new Set(exercises.map(ex => ex.muscle))].sort(); //Set tillåter bara unika värden

        const equipments = [...new Set(
            exercises.map(ex => ex.equipments).flat()
        )].filter(item => item).sort();

        //const equipments = [... new Set(exercises.map(ex => ex.equipment))].sort();
        const types = [...new Set(exercises.map(ex => ex.type))].sort();
        const difficulties = [... new Set(exercises.map(ex => ex.difficulty))];

        return { exercises, muscles, equipments, types, difficulties };
    } catch (err) {
        // Returnera tomma listor vid fel för att förhindra applikationskrasch
        return { exercises: [], muscles: [], equipments: [], types: [], difficulties: [] };
    }
}


/**
 * Offentlig funktion för att hämta övningsdatan.
 * Implementerar en cache-mekanism (memoization) för att säkerställa att API:et endast anropas en gång.
 * @returns {Promise<Object>} Ett Promise som löser sig till övningsdata.
 */
export function getExercises() {
    // Om Promise-objektet inte finns, skapa och spara det (första anropet)
    if (exercisesPromise == null) {
        exercisesPromise = loadExercises();
    }
    // Returnera det befintliga Promise-objektet (cachen) för efterföljande anrop
    return exercisesPromise;
}