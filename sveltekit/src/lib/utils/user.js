import { writable } from "svelte/store";

let user = writable(null);

export function setUser(userData) { 
    user.set(userData);
}

export function clearUser() {
    user.set(null);
}

export { user };
    