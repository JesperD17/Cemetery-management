<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import DuoInput from "@/layouts/custom/components/DuoInput.svelte";
    import SingleInput from "@/layouts/custom/components/SingleInput.svelte";
    import InputError from "@/components/InputError.svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import { fetchFromAPI } from "@/layouts/custom/components/Functions";
    import Asterisk from "@/layouts/custom/components/Asterisk.svelte";
    import { Input } from "@/Components/ui/input";
    import SearchableSelect from "@/layouts/custom/components/SearchableSelect.svelte";

    let gravesSelect = false;
    let graves = null;
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

    const submit = (e) => {
        e.preventDefault();
        $form.post(`/api/new-deceased?grave_id=${$formPair.grave_id}`, {
            forceFormData: true,
            onSuccess: () => $form.reset(),
        });
    };

    let cemeteries = fetchFromAPI('/api/cemeteries');
    
    const showGraves = (option) => {
        if (option.id) {
            graves = fetchFromAPI(`/api/gravesByCemetery/${option.id}`);
            gravesSelect = true;
        } else {
            graves = null;
            gravesSelect = false;
        }
    }
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
                />
            {:catch error}
                <div class="padding-btm">Er is een fout opgetreden bij het laden van begraafplaatsen.</div>
            {/await}

            {#if gravesSelect}
                {#await graves}
                    <div class="padding-btm">Laden...</div>
                {:then graves}
                    <SearchableSelect
                        bind:value={$formPair.grave_id}
                        options={graves}
                        placeholder="Kies een graf"
                        requiredBool={true}
                    />
                {:catch error}
                    <div class="padding-btm">Er is een fout opgetreden bij het laden van graven.</div>
                {/await}
            {/if}

            {#if $page.props?.flash?.success}
                <div class="padding-btm succes-message">{$page.props.flash.success}</div>
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