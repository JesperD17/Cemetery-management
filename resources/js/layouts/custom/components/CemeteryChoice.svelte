<script lang="js">
    import Label from '@/Components/ui/label/label.svelte';
    import Asterisk from '@/layouts/custom/components/Asterisk.svelte';

    export let form;

    var cemeteries = 'laden...';

    async function fetchCemeteries() {
        try {
            const response = await fetch(`/api/cemeteries`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            cemeteries = data;
        } catch (error) {
            cemeteries = 'error';
        }
    }

    const cemeteriesPromise = (async () => {
        try {
            await fetchCemeteries();
        } catch (err) {
            throw err;
        }
    })();
</script>

<div class="padding-btm full-width">
    {#await cemeteriesPromise}
        <div>Laden...</div>
    {:then}
        {#if cemeteries.length > 0}
            <div class="col-flex">
                <Label for="role_id">Begraafplaats</Label>
                <div class="flex-s-gap align-center">
                    <select
                        id="cemetery_id"
                        name="cemetery_id"
                        class="full-width padding-s bg-secondary border-radius base"
                        required
                        bind:value={$form.cemetery_id}
                        tabindex={6}
                    >
                        <option value="" disabled>-- Kies een begraafplaats --</option>
                        {#each cemeteries as cemetery}
                            <option value={cemetery.id} id={cemetery.id}>{cemetery.name}</option>
                        {/each}
                    </select>
                    <Asterisk />
                </div>
            </div>
        {/if}
    {:catch error}
        <div>Fout bij het laden de begraafplaatsen: {error.message}</div>
    {/await}
</div>
