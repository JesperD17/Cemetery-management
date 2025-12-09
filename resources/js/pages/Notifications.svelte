<script lang="js">
    import { onMount } from "svelte";

    let meldingen = [];
    let loading = true;
    let error = "";

    onMount(async () => {
        try {
            const res = await fetch("/api/meldingen", { credentials: "same-origin" });
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

<div class="meldingen-container">
    <h1>Meldingen</h1>

    {#if loading}
        <p>Bezig met laden...</p>
    {:else if error}
        <div class="alert error">{error}</div>
    {:else if meldingen.length === 0}
        <div class="alert success">Geen actieve meldingen</div>
    {:else}
        <div class="meldingen-list">
            {#each meldingen as melding}
                <div class="melding-card {melding.message.includes('verlopen') ? 'expired' : 'warning'}">
                    <h2>{melding.title}</h2>
                    <p>{melding.message}</p>
                </div>
            {/each}
        </div>
    {/if}
</div>

<style>
.meldingen-container {
    max-width: 800px;
    margin: 40px auto;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 2rem;
}

h1 {
    text-align: center;
    margin-bottom: 2rem;
}

.meldingen-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.melding-card {
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

.melding-card.warning {
    background: #fff4e5;
    border-left: 4px solid #ffb300;
}

.melding-card.expired {
    background: #ffe5e5;
    border-left: 4px solid #e60000;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
}

.alert.error {
    background: #f8d7da;
    color: #721c24;
}

.alert.success {
    background: #d4edda;
    color: #155724;
}
</style>
