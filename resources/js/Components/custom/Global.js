import { writable } from "svelte/store";

// example fetch to check user role
export let userRole = writable('Loading...');

async function fetchUserRole() {
    try {
        const response = await fetch('/checkRole', {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'include',
        });

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }
        const data = await response.json();
        userRole.set(data.role_name);
    } catch (error) {
        console.error(error);
        userRole = set('Error fetching user role');
    }
    return userRole;
}
fetchUserRole()
