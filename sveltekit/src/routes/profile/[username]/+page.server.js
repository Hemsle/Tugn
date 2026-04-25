// src/routes/profile/[username]/+page.server.js
export async function load({ params, fetch, cookies }) {
    const { username } = params;
    
    const sessionID = cookies.get('PHPSESSID');

    const response = await fetch(`http://nginx/api/userProfileStats.php?username=${params.username}`, {
        headers: {
            // Skicka vidare cookien till PHP
            cookie: `PHPSESSID=${sessionID}`
        }
    });
    const result = await response.json();

    return {
        visitedUser: result.user,
        initialWorkouts: result.workouts,
        isFollowing: result.isFollowing
    };
}