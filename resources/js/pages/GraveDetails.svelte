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
            const response = await fetch(`/api/graveById?id=${encodeURIComponent(id)}`, {
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
            <div class="h1 bold margin-bottom">Grafdetails</div>
                <div class="flex-m-gap justify-between align-center">
                    <div>
                        <div class="flex-m-gap">
                        <div class="bold">Grafnummer:</div>{graveDetails.grave_number}
                    </div>
                    <div class="flex-m-gap">
                        <div class="bold">Status:</div>{graveDetails.status_id}
                    </div>
                    <div class="flex-m-gap">
                        <div class="bold">Beschrijving:</div> {graveDetails.description}
                    </div>
                    <div class="flex-m-gap">
                        <div class="bold">Startdatum:</div> {graveDetails.start_date}
                    </div>
                    <div class="flex-m-gap">
                        <div class="bold">Einddatum:</div> {graveDetails.end_date}
                    </div>
                </div>
                {#if graveDetails.image_hash_url}
                <img class="image" src={graveDetails.image_hash_url} alt="Afbeelding van het graf" />
                {/if}
            </div>
        </div>
    {/if}
</AppLayout>