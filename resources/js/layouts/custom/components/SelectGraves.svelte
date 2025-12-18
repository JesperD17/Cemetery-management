<script lang="js">
    import { fetchFromAPI, saveNewData } from "@/layouts/custom/components/Functions";
    import SearchableSelect from "@/layouts/custom/components/SearchableSelect.svelte";
    import NewGraveModal from "@/layouts/custom/components/NewGraveModal.svelte";
    import NewCemeteryModal from "@/layouts/custom/components/NewCemeteryModal.svelte";
    import { useForm, page } from "@inertiajs/svelte";

    export let selectedGraveId = '';
    export let isGraveListLoading = false;
    export let requiredBool = false;
    export let value = '';

    let gravesSelect = false;
    let graves = null;

    let graveForm = useForm({
        cemetery_id: '',
        type: '',
        sort: '',
        latitude: '',
        longitude: '',
        image_hash_url: '',
        grave_number: '',
        status_id: '',
        description: '',
        start_date: '',
        end_date: '',
    });

    let cemeteryForm = useForm({
        name: '',
        grave_types: '',
        grave_sorts: '',
        city: '',
        address: '',
        zip_code: '',
        image_hash_url: '',
        description: '',
        errors: {},
    });

    let cemeteries = fetchFromAPI('/api/cemeteries');
    let createGraveModal;
    let createCemeteryModal;
    let selectedCemeteryId = null;

    function onCreateGraveOpen() {
        $graveForm.cemetery_id = '';
        $graveForm.type = '';
        $graveForm.sort = '';
        $graveForm.latitude = '';
        $graveForm.longitude = '';
        $graveForm.image_hash_url = '';
        $graveForm.grave_number = '';
        $graveForm.status_id = '';
        $graveForm.description = '';
        $graveForm.start_date = '';
        $graveForm.end_date = '';
        $graveForm.errors = {};
    }

    function onCreateCemeteryOpen() {
        $cemeteryForm.name = ' ';
        $cemeteryForm.grave_types = '';
        $cemeteryForm.grave_sorts = '';
        $cemeteryForm.city = '';
        $cemeteryForm.address = '';
        $cemeteryForm.zip_code = '';
        $cemeteryForm.image_hash_url = '';
        $cemeteryForm.description = '';
        $cemeteryForm.errors = {};
        const fileInput = document.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.value = '';
        }
    }

    function saveNewGrave(e) {
        const refreshGraves = async () => {
            if (selectedCemeteryId) {
                const p = fetchFromAPI(`/api/gravesByCemetery/${selectedCemeteryId}`);
                graves = p;
                isGraveListLoading = true;
                p.finally(() => (isGraveListLoading = false));
            }
        };
        saveNewData('/api/grave', $graveForm, refreshGraves, () => createGraveModal.close(), e);
    }

    function saveNewCemetery(e) {
        const refreshCemeteries = async () => {
            cemeteries = fetchFromAPI('/api/cemeteries');
        };
        const closeModal = () => {
            if (createCemeteryModal) {
                createCemeteryModal.close();
            }
        };
        saveNewData('/api/new-cemetery', $cemeteryForm, refreshCemeteries, closeModal, e);
    }

    cemeteries = fetchFromAPI('/api/cemeteries');

    const showGraves = (option) => {
        if (option.id) {
            selectedCemeteryId = option.id;
            const p = fetchFromAPI(`/api/gravesByCemetery/${option.id}`);
            graves = p;
            gravesSelect = true;
            isGraveListLoading = true;
            p.finally(() => (isGraveListLoading = false));
        } else {
            selectedCemeteryId = null;
            graves = null;
            gravesSelect = false;
            selectedGraveId = '';
        }
    };

    $: if (value && !selectedCemeteryId) {
        // Preselect cemetery and load graves when parent provides a value
        showGraves({ id: value });
    }
</script>

{#await cemeteries}
    <div class="padding-btm">Laden...</div>
{:then cemeteries}
    <div class="flex-s-gap align-end padding-btm">
        <SearchableSelect
            options={cemeteries}
            visible_name="Begraafplaats"
            placeholder="Kies een begraafplaats"
            onSelect={showGraves}
            requiredBool={requiredBool}
            bind:value={value}
        />
        <button type="button" class="base" on:click={() => createCemeteryModal.open()}>+</button>
    </div>
    {#if $page?.props?.flash?.success3}
        <div class="padding-btm succes-message">{$page.props.flash.success3}</div>
    {/if}
{:catch error}
    <div class="padding-btm">Er is een fout opgetreden bij het laden van begraafplaatsen.</div>
{/await}

{#if gravesSelect}
    {#await graves}
        <div class="padding-btm">Laden...</div>
    {:then graves}
        <div class="flex-s-gap align-end padding-btm">
            <SearchableSelect bind:value={selectedGraveId} visible_name="Graf" options={graves} placeholder="Kies een graf" requiredBool={true} />
            <button type="button" class="base" on:click={() => createGraveModal.open()}>+</button>
        </div>
        {#if $page?.props?.flash?.success2}
            <div class="padding-btm succes-message">{$page.props.flash.success2}</div>
        {/if}
    {:catch error}
        <div class="padding-btm">Er is een fout opgetreden bij het laden van graven.</div>
    {/await}
{/if}

<NewGraveModal 
    bind:this={createGraveModal} 
    {cemeteries} 
    bind:selectedCemeteryId 
    bind:form={graveForm} 
    {saveNewGrave} 
    {onCreateGraveOpen} 
    {page} 
/>

<NewCemeteryModal 
    bind:this={createCemeteryModal} 
    bind:form={cemeteryForm} 
    {saveNewCemetery} 
    {onCreateCemeteryOpen} 
    {page} 
/>
