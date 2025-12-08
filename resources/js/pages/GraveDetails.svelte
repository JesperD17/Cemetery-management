<script lang=js>
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { LoaderCircle } from 'lucide-svelte';
    export let id;

    var graveDetails = {};

    async function fetchGraveDetails() {
        if (!id) {
            graveDetails = { error: 'No ID provided' };
            return;
        }

        try {
            const response = await fetch(`/graveById?id=${encodeURIComponent(id)}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            graveDetails = data;
        } catch (error) {
            graveDetails = { error: 'Failed to fetch grave details' };
        }
    }

    fetchGraveDetails();
</script>

<AppLayout>
    {#if graveDetails.error}
        <div class="error-message">{graveDetails.error}</div>
    {:else if Object.keys(graveDetails).length === 0}
    <div class="bg-modal-primary center-flex">
        <div style="width: 10%; height: 10%; margin: auto; position: relative;">
            <LoaderCircle class="spinner" />
        </div>
    </div>
    {:else}
        <div class="grave-details">
            <h1>Grafdetails</h1>
            <p><strong>Grafnummer:</strong> {graveDetails.grave_number}</p>
            <p><strong>Status:</strong> {graveDetails.status_id}</p>
            <p><strong>Beschrijving:</strong> {graveDetails.description}</p>
            <p><strong>Startdatum:</strong> {graveDetails.start_date}</p>
            <p><strong>Einddatum:</strong> {graveDetails.end_date}</p>
            {#if graveDetails.image_hash_url}
                <img src={graveDetails.image_hash_url} alt="Afbeelding van het graf" />
            {/if}
        </div>
    {/if}
</AppLayout>