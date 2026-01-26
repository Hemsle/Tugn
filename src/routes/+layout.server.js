// src/routes/+layout.server.js

// Importera din caching-funktion från utils-filen
import { getExercises } from '$lib/utils/apiServer'; 

export async function load() {
    // getExercises() körs nu säkert på servern och använder cachen.
    const apiData = await getExercises();
    
    // Returnera datan. Den blir tillgänglig som data.apiData i layouts och sidor.
    return {
        ...apiData,
    };
}

