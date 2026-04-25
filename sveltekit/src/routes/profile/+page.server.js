// src/routes/profile/+page.server.js

import { workout } from '$lib/stores/workoutStore.js';

export async function load({ fetch, locals, parent, cookies }) {
    //data från layout för att checka user
    const layoutData = await parent();

    if (!layoutData.user) return {};

    const sessionID = cookies.get('PHPSESSID');//skickar med PHPSESSID för att php ska veta vem som är inloggad

    const response = await fetch('http://nginx/api/userProfileStats.php?offset=0', {
        headers: {
            cookie: `PHPSESSID=${sessionID}`
        }
    });
    const result = await response.json();

    //bra flöde
    return {
        initialWorkouts: result.workouts
    }
}