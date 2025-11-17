<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Loader } from 'lucide-svelte';
    export let name;

    var location = "laden...";
    var cards = [];

    async function fetchCemeteryID() {
        try {
            const response = await fetch(`/getCemeteries`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            console.log('cemeteryID:', data);
            let cemeteryID = data.find(cemetery => cemetery.name === name).id || "unknown";
            
            return cemeteryID;
        } catch (error) {
            return "error";
        }
    }
    
    async function fetchGraves() {
        var locID = await fetchCemeteryID();
        console.log(locID);
        if (locID === "error" || locID === "unknown") {
            location = "error";
            return;
        }


        try {
            const response = await fetch(`/getGraves?cemeteryID=${locID}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            cards = data;
            
        } catch (error) {
            cards = "error";
        }
    }

    const locationPromise = (async () => {
        try {
            await fetchGraves();
        } catch (err) {
            throw err;
        }
    })();
</script>

<svelte:head>
    Overzicht
</svelte:head>

<AppLayout class="section">
    <div class="h1 bold">
        Locatie {name}
    </div>
    {#await locationPromise}
        <div class="section">
            graven laden...
        </div>
        <div class="overlay-w-h">
            <Loader class="icon spin" />
        </div>
    {:then location}
        <div class="section">
            {#if cards.length > 0 && location !== "laden..."}
                <div class="flex-m-gap">
                    {#each cards as card}
                        <div class="row-flex full-width card-grave border-radius border-primary">
                            <img src="/images/dummy.png" alt="dummy img" class="border-radius-t cover full-height">
                            <div class="col-flex">
                                <div class="padding-all col-flex">
                                    <div class="bold line-clamp">{card.first_name} {card.infix} {card.last_name}</div>
                                    <div>Grafnummer {card.number}</div>
                                    {#if card.latitude && card.longitude}
                                        <a href={`https://maps.google.com/?q=${card.latitude},${card.longitude}`} target="_blank">
                                            Google maps locatie
                                        </a>
                                    {/if}
                                    <div>Type: {card.type}</div>
                                </div>
                            </div>
                        </div>
                    {/each}
                </div>
            {:else}
                <div>
                    Geen graven gevonden voor deze locatie.
                </div>
            {/if}
        </div>
    {:catch}
        <div class="section">
            Er is een fout opgetreden bij het ophalen van je locatie of graven.
        </div>
    {/await}
</AppLayout>
