<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import DuoInput from "@/layouts/custom/components/DuoInput.svelte";
    import SingleInput from "@/layouts/custom/components/SingleInput.svelte";
    import InputError from "@/components/InputError.svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import { fetchFromAPI, saveNewData } from "@/layouts/custom/components/Functions";
    import Asterisk from "@/layouts/custom/components/Asterisk.svelte";
    import { Input } from "@/Components/ui/input";
    import SearchableSelect from "@/layouts/custom/components/SearchableSelect.svelte";
    import ModalLayout from "@/layouts/custom/components/ModalLayout.svelte";
    import CemeteryChoice from "@/layouts/custom/components/CemeteryChoice.svelte";
    import Label from "@/Components/ui/label/label.svelte";

    let gravesSelect = false;
    let graves = null;
    let cemeteries = fetchFromAPI('/api/cemeteries');
    let createGraveModal;
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

    function saveNewGrave(e) {
        const refreshGraves = async () => {
            if (selectedCemeteryId) {
                graves = fetchFromAPI(`/api/gravesByCemetery/${selectedCemeteryId}`);
            }
        };
        saveNewData('/api/grave', $graveForm, refreshGraves, () => createGraveModal.close(), e);
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
                <SearchableSelect
                    options={cemeteries}
                    placeholder="Kies een begraafplaats"
                    onSelect={showGraves}
                    requiredBool={true}
                    additionalClasses="padding-btm"
                />
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

<ModalLayout bind:this={createGraveModal} title="Nieuw graf aanmaken" on:open={onCreateGraveOpen}>
    <form on:submit={saveNewGrave}>
        <div class="flex-m-gap col-flex">            
            <!-- <CemeteryChoice bind:form={graveForm} /> -->

            <!-- cemeteries is json -->
            <div class="flex-m-gap">
                {#await cemeteries}
                    Laden...
                {:then cemeteriesData}
                    {#if selectedCemeteryId}
                        {#each cemeteriesData as cemetery}
                            {#if cemetery.id == selectedCemeteryId}
                                <div class="bold">{cemetery.name} - {cemetery.city}</div>
                                <input type="hidden" name="cemetery_id_hidden" bind:value={graveForm.cemetery_id} />
                            {/if}
                        {/each}
                    {/if}
                {:catch error}
                    Fout bij laden begraafplaatsen.
                {/await}
            </div>

            <DuoInput
                type="text"
                type2="text"
                name="latitude"
                name2="longitude"
                visible_name="Latitude"
                visible_name2="Longitude"
                placeholder="bijv: 52.3676"
                placeholder2="bijv: 4.9041"
                requiredBool={true}
                requiredBool2={true}
                bind:form={graveForm}
            />

            <SingleInput
                type="file"
                name="image_hash_url"
                visible_name="Afbeelding"
                placeholder="Vul de afbeelding URL in"
                requiredBool={true}
                bind:form={graveForm}
            />

            <SingleInput
                type="text"
                name="grave_number"
                visible_name="Grafnummer"
                placeholder="bijv: 1"
                requiredBool={true}
                bind:form={graveForm}
            />

            <div class="padding-btm col-flex">
                <Label for="latitude">Status</Label>
                <div class="flex-s-gap align-center">
                    <select class="full-width padding-s bg-secondary border-radius base" name="status_id" id="status_id" required bind:value={$graveForm.status_id}>
                        <option value="" disabled selected>Kies een status</option>
                        <option value="1">Beschikbaar</option>
                        <option value="2">Bezet</option>
                        <option value="3">Gereserveerd</option>
                    </select>
                    <Asterisk />
                </div>
                <InputError message={$graveForm.errors.status_id} />
            </div>

            <SingleInput
                type="textarea"
                name="description"
                visible_name="Beschrijving"
                placeholder="Vul een beschrijving in"
                requiredBool={false}
                bind:form={graveForm}
            />

            <DuoInput
                type="date"
                type2="date"
                name="start_date"
                name2="end_date"
                visible_name="Startdatum"
                visible_name2="Einddatum"
                placeholder="Vul de startdatum in"
                placeholder2="Vul de einddatum in"
                requiredBool={true}
                requiredBool2={true}
                bind:form={graveForm}
            />

            <!-- {#if $page.props?.flash?.success}
                <div class="padding-btm succes-message">{$page.props.flash.success}</div>
            {/if} -->
            {#if $page.props?.flash?.error}
                <div class="padding-btm">
                    <InputError message={$page.props.flash.error} />
                </div>
            {/if}

            <div class="full-width flex-m-gap">
                <button class="base full-width" type="button" on:click={() => createGraveModal.close()}>Annuleer</button>
                <button class="base full-width" type="submit" on:click={() => $graveForm.cemetery_id = selectedCemeteryId}>Opslaan</button>
            </div>
        </div>
    </form>
</ModalLayout>