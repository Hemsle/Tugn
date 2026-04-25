// src/routes/+layout.server.js
import { workout } from '$lib/stores/workoutStore.js';
import { getExercises } from '$lib/utils/fetchDB.js';


//load({ cookies, locals })
export async function load({ locals }) {
    // getExercises() körs nu säkert på servern och använder cachen.
    const apiData = await getExercises();

    return {
        ...apiData,

        user: locals.user ? { ...locals.user } : null
    };
}

