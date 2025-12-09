export async function fetchFromAPI(url) {
    console.log('test');
    
    try {
        const response = await fetch(url, {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'include',
        });
        const data = await response.json();
        return data;
    } catch (error) {
        return 'error';
    }
}