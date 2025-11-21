<script lang="js">
    import Label from "@/Components/ui/label/label.svelte";

    export let form;

    var roles = 'laden...';

    async function fetchRoles() {
        try {
            const response = await fetch(`/roles`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();            
            roles = data;
        } catch (error) {
            roles = 'error';
        }
    }

    const rolesPromise = (async () => {
        try {
            await fetchRoles();
        } catch (err) {
            throw err;
        }
    })();
</script>

<div class="padding-btm full-width">
    {#await rolesPromise}
        <div>Laden...</div>
    {:then}
        {#if roles.length > 0}
            <div class="col-flex padding-btm">
                <Label for="role_id">Rol</Label>
                <div class="flex-s-gap align-center">
                    <select
                        id="role_id"
                        class="full-width padding-s bg-secondary border-radius base"
                        bind:value={form.role_id}
                        tabindex={6}
                    >
                        <option value="" disabled selected>Kies een rol</option>
                        {#each roles as role}
                            <option value={role.id}>{role.name}</option>
                        {/each}
                    </select>
                </div>
            </div>
        {/if}
    {:catch error}
        <div>Fout bij het laden van rollen: {error.message}</div>
    {/await}
</div>