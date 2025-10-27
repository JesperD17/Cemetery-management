<script lang="js">
    import Button from "@/Components/ui/button/button.svelte";
    import { Link } from "@inertiajs/svelte";
    import { Loader } from "lucide-svelte";

    var location = "laden...";
    var cards = [];

    navigator.geolocation.getCurrentPosition(fetchCity);

    async function fetchCity(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        try {
            const response = await fetch(`/getCityName?lat=${latitude}&lon=${longitude}`);
            const data = await response.json();
            location = data?.address?.municipality || data?.address?.city || "onbekend";
        } catch (error) {
            console.error('Error fetching location:', error);
            location = "onbekend"
        }
        fetchLocations()
    }

    async function fetchLocations() {
        if (location === "onbekend" || location === "laden...") return;
        
        try {
            const response = await fetch(`/getCementeries?city=${location}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();

            console.log("Locations:", data);
            cards = data;
        } catch (error) {
            console.error('Error fetching locations:', error);
            cards = "error";
        }
    }
</script>

<svelte:head>
    Begraafplaatsen
</svelte:head>

<div>
    {#if location === "laden..."}
        <div class="h1 bold">
            laden...
        </div>


        <div>
            begraafplaatsen laden...
        </div>

        <div class="overlay-w-h">
            <Loader class="icon spin" />
        </div>
    {:else if location === "onbekend" || cards === "error"}
        <div class="h1 bold">
            Locatie onbekend
        </div>

        <div class="section">
            Er is een fout opgetreden bij het ophalen van je locatie of begraafplaatsen.
        </div>
    {:else}
        <div class="h1 bold">
            Kies je locatie in {location}
        </div>

        <div class="section">
            {#if cards.length > 0 && location !== "laden..."}
            {console.log(cards)}
            <div class="flex-m-gap wrap">
                    {#each cards as card}
                        <div class="col-flex card-loc border-radius justify-between border-primary">
                            <img src="images/dummy.png" alt="dummy img" class="border-radius-t cover">
                            <div class="col-flex">
                                <div class="padding-all col-flex">
                                    <div class="center-text bold line-clamp">{card.name}</div>
                                    <div class="center-text">Locatie {card.municipality}</div>
                                </div>
                                <Button class="margin-noTop" href={`/begraafplaatsen/overzicht/${encodeURIComponent(card.name)}`}>Selecteer</Button>
                            </div>
                        </div>
                    {/each}
                </div>
            {:else}
                <div class="mt-4">
                    Geen begraafplaatsen gevonden in {location}.
                </div>
            {/if}
        </div>
    {/if}
</div>
