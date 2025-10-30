export default async function fetchUserRole(): Promise<string | null> {
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
        return data.role_name;
    } catch (error) {
        return null;
    }
}