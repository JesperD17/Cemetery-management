<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import Input from '@/Components/ui/input/input.svelte';
    import Label from '@/Components/ui/label/label.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import Choice from '@/layouts/custom/components/RoleChoice.svelte';

    var municipalities = 'laden...';
    let showModal = false;
    let selected = null;

    let form = {
        name: '',
        description: '',
    };

    let search = '';
    $: filteredMunicipalities = Array.isArray(municipalities)
        ? (search.trim() === ''
            ? municipalities
            : municipalities.filter(m => {
                const name = `${m.name ?? ''}`.toLowerCase();
                return name.includes(search.trim().toLowerCase());
            }))
        : municipalities;

    async function fetchMunicipalities() {
        try {
            const response = await fetch(`/municipalities`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            municipalities = data;
        } catch (error) {
            municipalities = 'error';
        }
    }

    function openEdit(municipality) {
        selected = municipality;
        form = {
            name: municipality.name ?? '',
            description: municipality.description ?? '',
        };
        showModal = true;
    }

    function closeModal() {
        showModal = false;
        selected = null;
    }

    function getXsrfFromCookie() {
        const c = document.cookie.split('; ').find((r) => r.startsWith('XSRF-TOKEN='));
        return c ? decodeURIComponent(c.split('=')[1]) : null;
    }

    async function saveMunicipality(e) {
        e.preventDefault();
        if (!selected) return;
        try {
            const payload = { ...form };
            const csrfToken = getXsrfFromCookie();

            const res = await fetch(`/municipalities/${selected.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-XSRF-TOKEN': csrfToken,
                },
                credentials: 'include',
                body: JSON.stringify(payload),
            });
            if (!res.ok) throw new Error('Update failed');
            await fetchMunicipalities();
            closeModal();
        } catch (err) {
            console.error(err);
            alert('Bijwerken mislukt');
        }        
    }

    const municipalitiesPromise = (async () => {
        try {
            await fetchMunicipalities();
        } catch (err) {
            throw err;
        }
    })();
</script>

<svelte:head>
    <title>Municipalities</title>
</svelte:head>

<AppLayout>
    <div class="padding-all">
        <h1 class="h2 margin-bottom start-text">Municipalities</h1>

        {#await municipalitiesPromise}
            <p>Laden...</p>
        {:then}
            {#if Array.isArray(municipalities)}
                <div class="padding-btm">
                    <Label for="search">Zoeken op naam</Label>
                    <div class="flex-s-gap align-center">
                        <Input
                            id="search"
                            type="search"
                            bind:value={search}
                            autocomplete="off"
                        />
                    </div>
                </div>

                <table class="table full-width">
                    <thead>
                        <tr class="start-text">
                            <th>Naam</th>
                            <th>Beschrijving</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#each filteredMunicipalities as municipality}
                            <tr class="start-text">
                                <td>{municipality.name}</td>
                                <td>{municipality.description ?? 'Leeg'}</td>
                                <!-- edit data popup -->
                                <td class="border-unset">
                                    <button class="base" id={municipality.id} onclick={() => openEdit(municipality)}>Bewerk</button>
                                </td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            {:else}
                <p>{municipalities}</p>
            {/if}
        {/await}
    </div>
</AppLayout>

{#if showModal}
    <div class="bg-modal-primary">
        <div open={showModal} onClose={closeModal} class="modal-primary">
            <h2 class="h2 margin-bottom">Municipality bewerken</h2>
            <form onsubmit={saveMunicipality}>
                <div class="flex-m-gap col-flex">
                    <div class="flex-m-gap">
                        <div class="col-flex">
                            <Label for="name">Naam</Label>
                            <div class="flex-s-gap align-center">
                                <Input
                                    id="name"
                                    type="text"
                                    required
                                    autofocus
                                    tabindex={1}
                                    autocomplete="name"
                                    bind:value={form.name}
                                    placeholder="Volledige"
                                />
                            </div>
                            <InputError message={form.errors?.name} />
                        </div>
                        <div class="col-flex">
                            <Label for="description">Beschrijving</Label>
                            <div class="flex-s-gap align-center">
                                <Input id="description" type="text" tabindex={1} autocomplete="name" bind:value={form.description} placeholder="Volledige" />
                            </div>
                            <InputError message={form.errors?.description} />
                        </div>
                    </div>
                    <div class="full-width flex-m-gap">
                        <button class="base full-width" type="button" onclick={closeModal}>Annuleer</button>
                        <button class="base full-width" type="submit">Opslaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
{/if}
