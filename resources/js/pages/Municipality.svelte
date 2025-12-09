<script lang="js">
    import Input from '@/Components/ui/input/input.svelte';
    import Label from '@/Components/ui/label/label.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import SingleInput from "@/layouts/custom/components/SingleInput.svelte";
    import ModalLayout from '@/layouts/custom/components/ModalLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { saveNewData } from '@/layouts/custom/components/Functions';

    var municipalities = 'laden...';
    
    let selected = null;
    let editModal;
    let createModal;

    let form = useForm({
        name: '',
        description: '',
    });

    let form2 = useForm({
        name: '',
        description: '',
    });

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

    function onEditOpen(e) {
        const payload = e.detail;
        
        selected = payload;
        $form.name = payload?.name ?? '';
        $form.description = payload?.description ?? '';
        $form.errors = {};
    }

    function onCreateOpen() {
        $form2.name = '';
        $form2.description = '';
        $form2.errors = {};
    }

    function onModalClose() {
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
            const payload = { ...$form };
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
            editModal.close();
        } catch (err) {
            console.error(err);
            alert('Bijwerken mislukt');
        }
    }

    // async function saveNewMunicipality(e) {
    //     e.preventDefault();
    //     try {
    //         const payload = { ...$form2 };
    //         const csrfToken = getXsrfFromCookie();
            
    //         const res = await fetch(`/municipalities`, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 Accept: 'application/json',
    //                 'X-Requested-With': 'XMLHttpRequest',
    //                 'X-XSRF-TOKEN': csrfToken,
    //             },
    //             credentials: 'include',
    //             body: JSON.stringify(payload),
    //         });
    //         if (!res.ok) throw new Error('Creation failed');
    //         await fetchMunicipalities();
    //         createModal.close();
    //     } catch (err) {
    //         console.error(err);
    //         alert('Aanmaken mislukt');
    //     }
    // }

    saveNewData(form2, '/municipalities', fetchMunicipalities, createModal);

    async function saveNewMunicipality(e) {
        e.preventDefault();
        $form2.post('/municipalities', {
            onSuccess: () => {
                fetchMunicipalities();
                createModal.close();
            },
            onError: (errors) => {
                console.error(errors);
                alert('Aanmaken mislukt');
            },
        });
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
            <button class="base" on:click={() => createModal.open()}>Nieuwe gemeente</button>
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
                                        <button class="base" id={municipality.id} on:click={() => editModal.open(municipality)}>Bewerk</button>
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

<ModalLayout bind:this={editModal} title="Gemeente bewerken" on:open={onEditOpen} on:close={onModalClose}>
    <form on:submit={saveMunicipality}>
        <div class="flex-m-gap col-flex">
            <div class="flex-m-gap col-flex">
                <SingleInput
                    type="text"
                    name="name"
                    visible_name="Naam"
                    placeholder="Vul de naam van de gemeente in"
                    requiredBool={true}
                    bind:form
                />
                <SingleInput
                    type="textarea"
                    name="description"
                    visible_name="Beschrijving"
                    placeholder="Vul een beschrijving van de gemeente in"
                    requiredBool={false}
                    bind:form
                />
            </div>
            <div class="full-width flex-m-gap">
                <button class="base full-width" type="button" on:click={() => editModal.close()}>Annuleer</button>
                <button class="base full-width" type="submit">Opslaan</button>
            </div>
        </div>
    </form>
</ModalLayout>


<ModalLayout bind:this={createModal} title="Gemeente aanmaken" on:open={onCreateOpen} on:close={onModalClose}>
    <form on:submit={saveNewMunicipality}>
        <div class="flex-m-gap col-flex">
            <SingleInput
                type="text"
                name="name"
                visible_name="Naam"
                placeholder="Vul de naam van de gemeente in"
                requiredBool={true}
                bind:form={form2}
            />
            <SingleInput
                type="textarea"
                name="description"
                visible_name="Beschrijving"
                placeholder="Vul een beschrijving van de gemeente in"
                requiredBool={false}
                bind:form={form2}
            />
            <div class="full-width flex-m-gap">
                <button class="base full-width" type="button" on:click={() => createModal.close()}>Annuleer</button>
                <button class="base full-width" type="submit">Opslaan</button>
            </div>
        </div>
    </form>
</ModalLayout>
    
