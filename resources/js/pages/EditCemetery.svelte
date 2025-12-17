<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import ModalLayout from '@/layouts/custom/components/ModalLayout.svelte';
    import SingleInput from '@/layouts/custom/components/SingleInput.svelte';
    import DuoInput from '@/layouts/custom/components/DuoInput.svelte';
    import { Link } from '@inertiajs/svelte';
    import { Loader } from 'lucide-svelte';

    export let id;

    let cemeteryData = null;
    let selected = null;
    let editModal;

    let form = useForm({
        name: '',
        city: '',
        address: '',
        zip_code: '',
        description: '',
        errors: {},
    });

    async function fetchCemeteryById(queryId = id) {
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
        editModal.open(data);
    }

    function onEditOpen(e) {
        const payload = e.detail;
        selected = payload;
        $form.name = payload?.name ?? '';
        $form.city = payload?.city ?? '';
        $form.address = payload?.address ?? '';
        $form.zip_code = payload?.zip_code ?? '';
        $form.description = payload?.description ?? '';
        $form.errors = {};
    }

    function onModalClose() {
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
            const payload = { ...$form };
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
            editModal.close();
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
                        <div>Type graven:</div>
                        <div>
                            {cemeteryData.grave_types ? cemeteryData.grave_types : 'Niet opgegeven'}
                        </div>
                    </div>
                    <div class="row-flex gap justify-between">
                        <Link class="btn primary" href="/begraafplaatsen/overzicht/{cemeteryData.id}" as="button">Ga naar overzicht</Link>
                        <button class="base" on:click={() => openEdit(cemeteryData)} as="button">Gegevens bewerken</button>
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

<ModalLayout bind:this={editModal} title="Gegevens bewerken" on:open={onEditOpen} on:close={onModalClose}>
    <form on:submit={saveCemetery}>
        <div class="col-flex">
            <SingleInput
                type="text"
                name="name"
                visible_name="Naam"
                placeholder="Verplicht"
                requiredBool={true}
                bind:form
            />

            <SingleInput
                type="text"
                name="city"
                visible_name="Plaats"
                placeholder="Verplicht"
                requiredBool={true}
                bind:form
            />

            <DuoInput
                type="text"
                type2="text"
                name="address"
                name2="zip_code"
                visible_name="Adres"
                visible_name2="Postcode"
                placeholder="Straat en huisnummer"
                placeholder2="0123 AB"
                requiredBool={false}
                requiredBool2={false}
                bind:form
            />

            <SingleInput
                type="textarea"
                name="description"
                visible_name="Beschrijving"
                placeholder="Optioneel"
                requiredBool={false}
                bind:form
            />

            <div class="full-width flex-m-gap">
                <button class="base full-width" type="button" on:click={() => editModal.close()}>Annuleer</button>
                <button class="base full-width" type="submit">Opslaan</button>
            </div>
        </div>
    </form>
</ModalLayout>
