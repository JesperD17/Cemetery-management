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

export async function saveNewData(url, formData, fetchFunction = () => Promise.resolve(), closeModal, e) {
    if (e?.preventDefault) {
        e.preventDefault();
    }
    const form = formData?.post ? formData : null;

    if (!form) {
        console.error('saveNewData expects an Inertia useForm instance with a post() method. Received:', formData);
        return;
    }

    console.log('Submitting to:', url, 'with data:', formData, fetchFunction);

    form.post(url, {
        onSuccess: async () => {
            await fetchFunction();
            if (closeModal && typeof closeModal === 'function') {
                closeModal();
            }
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}