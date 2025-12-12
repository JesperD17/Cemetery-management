<script lang="js">
    import { onMount } from "svelte";

    let meldingen = [];
    let loading = true;
    let error = "";

    onMount(async () => {
        try {
            const res = await fetch("/api/notifications", { credentials: "same-origin" });
            if (!res.ok) throw new Error("Kon meldingen niet ophalen");

            meldingen = await res.json();
        } catch (err) {
            console.error(err);
            error = "Er is iets misgegaan bij het ophalen van meldingen.";
        } finally {
            loading = false;
        }
    });
</script>

<div class="notifications-container">
    <h1>Meldingen</h1>

    {#if loading}
        <p>Bezig met laden...</p>
    {:else if error}
        <div class="alert error">{error}</div>
    {:else if meldingen.length === 0}
        <div class="alert success">Geen actieve meldingen</div>
    {:else}
        <div class="notifications-list">
            {#each meldingen as melding}
                <div class="notifications-card {melding.message.includes('verlopen') ? 'expired' : 'warning'}">
                    <h2>{melding.title}</h2>
                    <p>{melding.message}</p>
                </div>
            {/each}
        </div>
    {/if}
</div>
