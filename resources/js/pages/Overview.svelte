<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Loader } from 'lucide-svelte';
    export let id;

    var location = 'laden...';
    var cards = [];
    var cemeteryDetails = {};

    async function fetchCemeteryDetails() {
        if (!id) {
            location = 'error';
            return;
        }

        try {
            const response = await fetch(`/cemeteryById?id=${encodeURIComponent(id)}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            cemeteryDetails = data;
            
        } catch (error) {
            location = 'error';
        }
    }

    async function fetchGraves() {
        if (!id) {
            location = 'error';
            return;
        }

        try {
            const response = await fetch(`/graves?cemeteryID=${encodeURIComponent(id)}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            cards = data;
        } catch (error) {
            cards = 'error';
        }
    }

    const locationPromise = (async () => {
        try {
            await fetchCemeteryDetails();
            await fetchGraves();
        } catch (err) {
            throw err;
        }
    })();
</script>

<svelte:head>Overzicht</svelte:head>

<AppLayout>
    {#await locationPromise}
        <div class="section">graven laden...</div>
        <div class="overlay-w-h">
            <Loader class="icon spin" />
        </div>
    {:then location}
        {#if cards.length > 0 && location !== 'laden...'}
            <div class="h1 bold">
                Locatie {cemeteryDetails.name}
            </div>
            <div class="section">
                <div class="flex-m-gap">
                    {#each cards as card}
                        <div class="row-flex full-width card-grave border-radius border-primary">
                            <img src="/images/dummy.png" alt="dummy img" class="border-radius-t cover full-height" />
                            <div class="col-flex justify-center">
                                <div class="padding-all col-flex">
                                    <div class="bold line-clamp">{card.first_name} {card.infix} {card.last_name}</div>
                                    <div>Grafnummer {card.grave_number}</div>
                                    {#if card.latitude && card.longitude}
                                        <a href={`https://maps.google.com/?q=${card.latitude},${card.longitude}`} target="_blank">
                                            Google maps locatie
                                        </a>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    {/each}
                </div>
            </div>
        {:else}
            <div class="section errormsg">Geen graven gevonden voor deze locatie.</div>
        {/if}
    {:catch}
        <div class="section errormsg">Er is een fout opgetreden bij het ophalen van je locatie of graven.</div>
    {/await}
</AppLayout>
