<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import Input from '@/Components/ui/input/input.svelte';
    import Label from '@/Components/ui/label/label.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import Choice from '@/layouts/custom/components/RoleChoice.svelte';

    var municipalities = 'laden...';
    let showModal = false;
    let showModal2 = false;
    let selected = null;

    let form = {
        name: '',
        description: '',
    };

    let form2 = {
        name: '',
        description: '',
    };

    let search = '';
    $: filteredMunicipalities = Array.isArray(municipalities)
        ? search.trim() === ''
            ? municipalities
            : municipalities.filter((m) => {
                  const name = `${m.name ?? ''}`.toLowerCase();
                  return name.includes(search.trim().toLowerCase());
              })
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

    function openEdit2() {
        showModal2 = true;
    }

    function closeModal() {
        showModal = false;
        selected = null;
    }

    function closeModal2() {
        showModal2 = false;
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

    async function saveNewMunicipality(e) {
        e.preventDefault();
        try {
            const payload = { ...form2 };
            const csrfToken = getXsrfFromCookie();

            const res = await fetch(`/municipalities`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-XSRF-TOKEN': csrfToken,
                },
                credentials: 'include',
                body: JSON.stringify(payload),
            });
            if (!res.ok) throw new Error('Creation failed');
            await fetchMunicipalities();
            closeModal2();
        } catch (err) {
            console.error(err);
            alert('Aanmaken mislukt');
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
    <title>Gemeentes</title>
</svelte:head>

<AppLayout>
    <div class="padding-all">
        <h1 class="h2 margin-bottom start-text row-flex justify-between align-center">
            Gemeentes beheren
            <button class="base" onclick={openEdit2}>Nieuwe gemeente</button>
        </h1>

        {#await municipalitiesPromise}
            <p>Laden...</p>
        {:then}
            {#if Array.isArray(municipalities)}
                <div class="padding-btm">
                    <Label for="search">Zoeken op naam</Label>
                    <div class="flex-s-gap align-center">
                        <Input id="search" type="search" bind:value={search} autocomplete="off" />
                    </div>
                </div>

                <div class="table full-width">
                    <table>
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
                                    <td class="border-unset">
                                        <button class="base" id={municipality.id} onclick={() => openEdit(municipality)}>Bewerk</button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
            {:else}
                <p>{municipalities}</p>
            {/if}
        {/await}
    </div>
</AppLayout>

{#if showModal}
    <div class="bg-modal-primary">
        <div open={showModal} onClose={closeModal} class="modal-primary">
            <h2 class="h2 margin-bottom">Gemeente bewerken</h2>
            <form onsubmit={saveMunicipality}>
                <div class="flex-m-gap col-flex">
                    <div class="flex-m-gap col-flex">
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
                                <textarea 
                                    rows="7" 
                                    cols="50" 
                                    bind:value={form.description} 
                                    placeholder="Optioneel">
                                </textarea>
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
{:else if showModal2}
    <div class="bg-modal-primary">
        <div open={showModal2} onClose={closeModal2} class="modal-primary">
            <h2 class="h2 margin-bottom">Gemeente aanmaken</h2>
            <form onsubmit={saveNewMunicipality}>
                <div class="flex-m-gap col-flex">
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
                                bind:value={form2.name}
                                placeholder="Verplicht"
                            />
                        </div>
                        <InputError message={form2.errors?.name} />
                    </div>
                    <div class="col-flex desc">
                        <Label for="description">Beschrijving</Label>
                        <div class="flex-s-gap align-center">
                            <textarea 
                                rows="7" 
                                cols="50" 
                                bind:value={form2.description} 
                                placeholder="Optioneel">
                            </textarea>
                        </div>
                        <InputError message={form2.errors?.description} />
                    </div>
                    <div class="full-width flex-m-gap">
                        <button class="base full-width" type="button" onclick={closeModal2}>Annuleer</button>
                        <button class="base full-width" type="submit">Opslaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
{/if}
