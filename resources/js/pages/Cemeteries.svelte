<script lang="js">
    import Button from "@/Components/ui/button/button.svelte";
    import AppLayout from "@/layouts/AppLayout.svelte";
    import { Link } from "@inertiajs/svelte";
    import { Loader, Pen } from "lucide-svelte";
    import { page } from "@inertiajs/svelte";

    var location = "laden...";
    var cards = [];
    const userRole = $derived($page?.props?.auth?.user?.role?.name || null);

    async function fetchCemeteries() {
        try {
            const response = await fetch(`/cemeteries`, {
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

    const cemeteriesPromise = (async () => {
        try {
            await fetchCemeteries();
        } catch (err) {
            throw err;
        }
    })();
    console.log(cemeteriesPromise);
    
</script>

<svelte:head>
    Begraafplaatsen
</svelte:head>

<AppLayout>
    {#await cemeteriesPromise}
        <div class="h1 bold">
            laden...
        </div>
        <div class="section">
            begraafplaatsen laden...
        </div>
        <div class="overlay-w-h">
            <Loader class="icon spin" />
        </div>
    {:then cemeteries}
        <div class="h1 bold">
            Kies je gekoppelde begraafplaats
        </div>
        <div class="section">
            {#if cards.length > 0 && cemeteries !== "laden..."}
            <div class="flex-m-gap wrap">
                    {#each cards as card}
                        <div class="col-flex card-loc border-radius justify-between border-primary">
                            <img src="/images/dummy.png" alt="dummy img" class="border-radius-t cover">
                            <div class="col-flex">
                                <div class="padding-all col-flex">
                                    <div class="center-text bold line-clamp">{card.name}</div>
                                    <div class="center-text">Locatie {card.city}</div>
                                </div>
                                <Button class="margin-noTop" href={`/begraafplaatsen/overzicht/${encodeURIComponent(card.id)}`}>Selecteer</Button>
                            </div>

                            {#if userRole === 'super admin' || userRole === 'admin'}
                            <div class="top-right black">
                                <Link href={`/begraafplaatsen/bewerk/${encodeURIComponent(card.id)}`}>
                                    <Pen />
                                </Link>
                            </div>
                            {/if}
                        </div>
                    {/each}
                </div>
            {:else}
                <div class="mt-4">
                    Geen begraafplaatsen gevonden in {location}.
                </div>
            {/if}
        </div>
    {:catch}
        <div class="h1 bold">
            Fout
        </div>
        <div class="section">
            Er is een fout opgetreden bij het ophalen van je locatie of begraafplaatsen.
        </div>
    {/await}
</AppLayout>
