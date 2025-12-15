export async function fetchFromAPI(url) {
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

export async function saveNewData(url, formData, fetchFunction, closeModal, e) {
    e.preventDefault();
    
    formData.post(url, {
        onSuccess: async () => {
            await fetchFunction();
            if (closeModal && typeof closeModal === 'function') {
                closeModal();
            }
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}