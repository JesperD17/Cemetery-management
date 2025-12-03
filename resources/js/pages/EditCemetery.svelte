<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import Input from '@/Components/ui/input/input.svelte';
    import Label from '@/Components/ui/label/label.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link } from '@inertiajs/svelte';
    import { Loader } from 'lucide-svelte';

    export let id;

    let cemeteryData = null;
    let showModal = false;
    let selected = null;
    let form = {
        name: '',
        city: '',
        address: '',
        zip_code: '',
        description: '',
    };

    async function fetchCemeteryById(queryId = id) {
        console.log(queryId);

        try {
            const response = await fetch(`/cemeteryById?id=${encodeURIComponent(queryId)}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();

            cemeteryData = data;
        } catch (error) {
            cemeteryData = 'error';
        }
    }

    const cemeteryPromise = (async () => {
        try {
            await fetchCemeteryById(id);
        } catch (err) {
            throw err;
        }
    })();

    function openEdit(data) {
        selected = data;
        form = {
            name: data.name,
            city: data.city,
            address: data.address,
            zip_code: data.zip_code,
            description: data.description,
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

    async function saveCemetery(e) {
        e.preventDefault();
        if (!selected) return;
        try {
            const payload = { ...form };
            const csrfToken = getXsrfFromCookie();

            const res = await fetch(`/updateCemetery/${selected.id}`, {
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
            await fetchCemeteryById(id);
            closeModal();
        } catch (err) {
            alert('Bijwerken mislukt');
        }
    }
</script>

<AppLayout>
    {#await cemeteryPromise}
        <div class="section">
            <div>Loading cemetery data...</div>
        </div>
        <div class="overlay-w-h">
            <Loader class="icon spin" />
        </div>
    {:then}
        {#if cemeteryData === 'error'}
        <div class="section">
            <div class="errorMsg">Error fetching cemetery data.</div>
        </div>
        {:else if cemeteryData}
            <div class="h1 bold">
                {cemeteryData.name} Bewerken
            </div>
            <div class="section">
                <div class="col-flex gap">
                    <div class="row-flex gap justify-between">
                        <div>Naam:</div>
                        <div>
                            {cemeteryData.name}
                        </div>
                    </div>
                    <div class="row-flex gap justify-between">
                        <div>Locatie:</div>
                        <div>
                            {cemeteryData.city}
                        </div>
                    </div>
                    <div class="row-flex gap justify-between">
                        <div>Beschrijving:</div>
                        <div class="overflow-scroll-description">
                            {cemeteryData.description ? cemeteryData.description : 'Lege beschrijving'}
                        </div>
                    </div>
                    <div class="row-flex gap justify-between">
                        <div>Adres:</div>
                        <div>
                            {cemeteryData.address}
                            {cemeteryData.zip_code}
                        </div>
                    </div>
                    <div class="row-flex gap justify-between">
                        <Link class="btn primary" href="/begraafplaatsen/overzicht/{cemeteryData.id}" as="button">Ga naar overzicht</Link>
                        <button class="base" onclick={() => openEdit(cemeteryData)} as="button">Gegevens bewerken</button>
                    </div>
                </div>
            </div>
        {:else}
            <div class="section">
                <div>No cemetery data found.</div>
            </div>
        {/if}
    {:catch error}
        <div class="section">
            <div class="errorMsg">Error: {error.message}</div>
        </div>
    {/await}
</AppLayout>

{#if showModal}
    <div class="bg-modal-primary">
        <div open={showModal} onClose={closeModal} class="modal-primary">
            <h2 class="h2 margin-bottom">Gegevens bewerken</h2>
            <form onsubmit={saveCemetery}>
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
                                placeholder="Verplicht"
                            />
                        </div>
                        <InputError message={form.errors?.name} />
                    </div>
                    <div class="col-flex">
                        <Label for="city">Plaats</Label>
                        <div class="flex-s-gap align-center">
                            <Input id="city" type="text" tabindex={1} autocomplete="name" bind:value={form.city} placeholder="Verplicht" />
                        </div>
                        <InputError message={form.errors?.city} />
                    </div>
                    <div class="flex-m-gap">
                        <div class="col-flex">
                            <Label for="address">Adres</Label>
                            <div class="flex-s-gap align-center">
                                <Input
                                    id="address"
                                    type="text"
                                    required
                                    tabindex={1}
                                    autocomplete="name"
                                    bind:value={form.address}
                                    placeholder="Verplicht"
                                />
                            </div>
                            <InputError message={form.errors?.address} />
                        </div>
                        <div class="col-flex">
                            <Label for="zip_code">Postcode</Label>
                            <div class="flex-s-gap align-center">
                                <Input
                                    id="zip_code"
                                    type="text"
                                    tabindex={1}
                                    required
                                    autocomplete="name"
                                    bind:value={form.zip_code}
                                    placeholder="Verplicht"
                                />
                            </div>
                            <InputError message={form.errors?.zip_code} />
                        </div>
                    </div>
                    <div class="col-flex padding-btm">
                        <Label for="description">Beschrijving</Label>
                        <div class="flex-s-gap align-center">
                            <!-- <Input id="description" type="text" tabindex={1} autocomplete="name" bind:value={form.description} /> -->
                            <textarea
                                id="description"
                                rows="7" 
                                cols="50" 
                                class="input full-width"
                                tabindex={1}
                                bind:value={form.description}
                                placeholder="Optioneel"
                            ></textarea>
                        </div>
                        <InputError message={form.errors?.description} />
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
