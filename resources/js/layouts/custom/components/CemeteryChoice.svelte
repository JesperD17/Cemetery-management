<script lang="js">
    import Label from '@/Components/ui/label/label.svelte';
    import Asterisk from '@/layouts/custom/components/Asterisk.svelte';
    import SearchableSelect from './SearchableSelect.svelte';

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
                <SearchableSelect
                    bind:value={$form.cemetery_id}
                    form={form}
                    visible_name="Begraafplaats kiezen"
                    options={cemeteries}
                    placeholder="Kies een begraafplaats"
                    requiredBool={true}
                />
            </div>
        {/if}
    {:catch error}
        <div>Fout bij het laden de begraafplaatsen: {error.message}</div>
    {/await}
</div>
