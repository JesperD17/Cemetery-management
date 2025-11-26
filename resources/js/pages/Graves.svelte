<script>
    import { onMount } from "svelte";

    let graven = [];
    let error = "";
    let loading = true;

    onMount(async () => {
        try {
            const res = await fetch("/api/graven", { credentials: "same-origin" });
            if (!res.ok) throw new Error("Kon gegevens niet ophalen");
            graven = await res.json();
        } catch (err) {
            console.error(err);
            error = "Er is iets misgegaan bij het ophalen van de gegevens.";
        } finally {
            loading = false;
        }
    });
</script>

<div class="graves-container">
    <h1>Mijn Graven</h1>

    {#if loading}
        <p>Gegevens laden...</p>
    {:else if error}
        <div class="alert error">{error}</div>
    {:else if graven.length === 0}
        <p>Geen graven gevonden.</p>
    {:else}
        <div class="graves-grid">
            {#each graven as graf}
                <div class="grave-card">
                    <div class="grave-info">
                        <h2>Graf {graf.grave_number}</h2>
                        <p><strong>Begraafplaats:</strong> {graf.cemetery.name}</p>
                        <p><strong>Status:</strong> {graf.grave_status.name}</p>
                        <p><strong>Beschrijving:</strong> {graf.description || "Geen beschrijving"}</p>
                        <p><strong>Start:</strong> {graf.start_date}</p>
                        <p><strong>Eind:</strong> {graf.end_date}</p>
                        <p><strong>Locatie:</strong> 📍 {graf.latitude}, {graf.longitude}</p>
                    </div>
                </div>
            {/each}
        </div>
    {/if}
</div>

