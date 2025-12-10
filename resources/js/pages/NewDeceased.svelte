<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import DuoInput from "@/layouts/custom/components/DuoInput.svelte";
    import SingleInput from "@/layouts/custom/components/SingleInput.svelte";
    import InputError from "@/components/InputError.svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import { fetchFromAPI, saveNewData } from "@/layouts/custom/components/Functions";
    import SearchableSelect from "@/layouts/custom/components/SearchableSelect.svelte";
    import NewGraveModal from "@/layouts/custom/components/NewGraveModal.svelte";
    import NewCemeteryModal from "@/layouts/custom/components/NewCemeteryModal.svelte";

    let gravesSelect = false;
    let graves = null;
    let cemeteries = fetchFromAPI('/api/cemeteries');
    let createGraveModal;
    let createCemeteryModal;
    let selectedCemeteryId = null;

    let form = useForm({
        first_name: '',
        infix: '',
        last_name: '',
        date_of_birth: '',
        date_of_death: '',
        description: '',
    });

    let formPair = useForm({
        grave_id: '',
        deceased_id: '',
    });

    let graveForm = useForm({
        cemetery_id: '',
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
        name: " ",
        municipality_id: '',
        city: '',
        address: '',
        zipcode: '',
        image_hash_url: '',
        description: '',
    });

    function onCreateGraveOpen() {
        $graveForm.cemetery_id = '';
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
        $cemeteryForm.name = " ";
        $cemeteryForm.municipality_id = '';
        $cemeteryForm.city = '';
        $cemeteryForm.address = '';
        $cemeteryForm.zipcode = '';
        $cemeteryForm.image_hash_url = '';
        $cemeteryForm.description = '';
        $cemeteryForm.errors = {};
        // Reset the input value for the file input
        const fileInput = document.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.value = '';
        }
    }

    function saveNewGrave(e) {
        const refreshGraves = async () => {
            if (selectedCemeteryId) {
                graves = fetchFromAPI(`/api/gravesByCemetery/${selectedCemeteryId}`);
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

    const submit = (e) => {
        e.preventDefault();
        $form.post(`/api/new-deceased?grave_id=${$formPair.grave_id}`, {
            forceFormData: true,
            onSuccess: () => $form.reset(),
        });
    };

    cemeteries = fetchFromAPI('/api/cemeteries');
    
    const showGraves = (option) => {
        if (option.id) {
            selectedCemeteryId = option.id;
            graves = fetchFromAPI(`/api/gravesByCemetery/${option.id}`);
            gravesSelect = true;
        } else {
            selectedCemeteryId = null;
            graves = null;
            gravesSelect = false;
        }
    };
</script>

<svelte:head>
    <title>Nieuwe Overledene</title>
</svelte:head>

<AppLayout>
    <div class="form-alignment">
        <form class="padding-all bg-primary border-radius" on:submit={submit}>
            <div class="h1 padding-btm center-flex">Nieuwe overledene aanmaken</div>
            <DuoInput
                type="text"
                type2="text"
                name="first_name"
                name2="infix"
                visible_name="Naam Overledene"
                visible_name2="Tussenvoegsel"
                placeholder="Vul de naam in"
                placeholder2="Vul het tussenvoegsel in"
                requiredBool={true}
                requiredBool2={false}
                bind:form
            />

            <SingleInput
                type="text"
                name="last_name"
                visible_name="Achternaam"
                placeholder="Vul de achternaam in"
                requiredBool={true}
                bind:form
            />

            <DuoInput
                type="date"
                type2="date"
                name="date_of_birth"
                name2="date_of_death"
                visible_name="Geboortedatum"
                visible_name2="Overlijdensdatum"
                placeholder="Vul de geboortedatum in"
                placeholder2="Vul de overlijdensdatum in"
                requiredBool={true}
                requiredBool2={true}
                bind:form
            />

            <SingleInput
                type="textarea"
                name="description"
                visible_name="Beschrijving"
                placeholder="Vul een beschrijving in"
                requiredBool={false}
                bind:form
            />

            {#await cemeteries}
                <div class="padding-btm">Laden...</div>
            {:then cemeteries}
                <div class="flex-s-gap align-center padding-btm">
                    <SearchableSelect
                        options={cemeteries}
                        placeholder="Kies een begraafplaats"
                        onSelect={showGraves}
                        requiredBool={true}
                    />
                    <button type="button" class="base" on:click={() => createCemeteryModal.open()}>+</button>
                </div>
            {:catch error}
                <div class="padding-btm">Er is een fout opgetreden bij het laden van begraafplaatsen.</div>
            {/await}

            {#if gravesSelect}
                {#await graves}
                    <div class="padding-btm">Laden...</div>
                {:then graves}
                    <div class="flex-s-gap align-center padding-btm">
                        <SearchableSelect
                            bind:value={$formPair.grave_id}
                            options={graves}
                            placeholder="Kies een graf"
                            requiredBool={true}
                        />
                        <button type="button" class="base" on:click={() => createGraveModal.open()}>+</button>
                    </div>
                {:catch error}
                    <div class="padding-btm">Er is een fout opgetreden bij het laden van graven.</div>
                {/await}
            {/if}

            {#if $page.props?.flash?.success1}
                <div class="padding-btm succes-message">{$page.props.flash.success1}</div>
            {:else if $page.props?.flash?.success2}
                <div class="padding-btm succes-message">{$page.props.flash.success2}</div>
            {:else if $page.props?.flash?.success3}
                <div class="padding-btm succes-message">{$page.props.flash.success3}</div>
            {/if}
            {#if $page.props?.flash?.error}
                <div class="padding-btm">
                    <InputError message={$page.props.flash.error} />
                </div>
            {/if}

            <div class="full-width flex-m-gap">
                <!-- makes the button unselectable while divs are loading -->
                {#if gravesSelect && !graves}
                    <button class="base full-width" type="submit" disabled>Overledene opslaan</button>
                {:else}
                    <button class="base full-width" type="submit">Overledene opslaan</button>
                {/if}
            </div>
        </form>
    </div>
</AppLayout>

<NewGraveModal 
    bind:this={createGraveModal} 
    {cemeteries}
    bind:selectedCemeteryId={selectedCemeteryId} 
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