<script lang="js">
    import Label from "@/Components/ui/label/label.svelte";
    import DuoInput from "./DuoInput.svelte";
    import ModalLayout from "./ModalLayout.svelte";
    import SingleInput from "./SingleInput.svelte";
    import Asterisk from "./Asterisk.svelte";
    import InputError from "@/components/InputError.svelte";
    import LoadingDiv from "./LoadingDiv.svelte";
    import { fetchFromAPI } from "./Functions";
    import SearchableSelect from "./SearchableSelect.svelte";

    export let selectedCemeteryId;
    export let cemeteries;
    export let form;
    export let saveNewGrave;
    export let onCreateGraveOpen;
    export let page;

    let modalRef;
    let types_sorts;
    
    $: if (selectedCemeteryId) {
        types_sorts = fetchFromAPI(`/api/grave-types-sorts/${selectedCemeteryId}`);
    }

    export function open() {
        modalRef.open();
    }

    export function close() {
        modalRef.close();
    }
</script>

<ModalLayout bind:this={modalRef} title="Nieuw graf aanmaken" on:open={onCreateGraveOpen}>
    <form on:submit={saveNewGrave}>
        <!-- <CemeteryChoice bind:form={graveForm} /> -->
        <div class="flex-m-gap">
            {#await cemeteries}
                Laden...
            {:then cemeteriesData}
                {#if selectedCemeteryId}
                    {#each cemeteriesData as cemetery}
                        {#if cemetery.id == selectedCemeteryId}
                            <div class="bold padding-btm">{cemetery.name} - {cemetery.city}</div>
                            <input type="hidden" name="cemetery_id_hidden" bind:value={form.cemetery_id} />
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
            bind:form={form}
        />

        <SingleInput
            type="file"
            name="image_hash_url"
            fileHashField="image_hash_url"
            fileHashPrefix="cemetery"
            accept="image/*"
            visible_name="Afbeelding"
            placeholder="Upload een afbeelding"
            requiredBool={true}
            bind:form={form}
        />

        <SingleInput
            type="text"
            name="grave_number"
            visible_name="Grafnummer"
            placeholder="bijv: 1"
            requiredBool={true}
            bind:form={form}
        />

        <div class="padding-btm col-flex">
            <Label for="latitude">Status</Label>
            <div class="flex-s-gap align-center">
                <select class="full-width padding-s bg-secondary border-radius base" name="status_id" id="status_id" required bind:value={$form.status_id}>
                    <option value="" disabled selected>Kies een status</option>
                    <option value="1">Beschikbaar</option>
                    <option value="2">Bezet</option>
                    <option value="3">Gereserveerd</option>
                </select>
                <Asterisk />
            </div>
            <InputError message={$form.errors.status_id} />
        </div>

        <SingleInput
            type="textarea"
            name="description"
            visible_name="Beschrijving"
            placeholder="Vul een beschrijving in"
            requiredBool={false}
            bind:form={form}
        />
        
        <!-- Searchable selects for grave type and grave sort -->
        {#if types_sorts}
            {#await types_sorts}
                <div class="padding-btm">
                    Laden...
                </div>
            {:then types_sortsData}
                {#if types_sortsData?.types && types_sortsData?.sorts}
                <div class="flex-s-gap padding-btm">
                    <SearchableSelect
                        bind:value={$form.type}
                        visible_name="Graf Type"
                        options={types_sortsData.types}
                        placeholder="Kies een graf type"
                        requiredBool={true}
                    />
                    <SearchableSelect
                        bind:value={$form.sort}
                        visible_name="Graf Soort"
                        options={types_sortsData.sorts}
                        placeholder="Kies een graf soort"
                        requiredBool={true}
                    />
                </div>
                {:else}
                    <div class="padding-btm">
                        Geen graf types en soorten beschikbaar voor deze begraafplaats.
                    </div>
                {/if}
            {:catch error}
                <div class="padding-btm">
                    Fout bij laden graf types en soorten: {error.message || 'Onbekende fout'}
                </div>
            {/await}
        {/if}

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
            bind:form={form}
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
            <button class="base full-width" disabled={$form.processing} type="button" on:click={() => close()}>Annuleer</button>
            <button class="base full-width relative" disabled={$form.processing} type="submit" on:click={() => $form.cemetery_id = selectedCemeteryId}>
                <LoadingDiv {form} />
                Opslaan
            </button>
        </div>
    </form>
</ModalLayout>