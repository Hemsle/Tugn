// src/hooks.server.js
export async function handle({ event, resolve }) {
    const sessionID = event.cookies.get('PHPSESSID');

    if (sessionID) {
        try {
            const response = await event.fetch('http://nginx/api/session.php', {
                headers: {
                    // Skickar med cookien till PHP så den hittar rätt session
                    cookie: `PHPSESSID=${sessionID}`
                }
            });
            const user = await response.json();
            event.locals.user = user; // Sparar användaren i locals
        } catch (err) {
            event.locals.user = null;
        }
    } else {
        event.locals.user = null;
    }

    return await resolve(event);
}