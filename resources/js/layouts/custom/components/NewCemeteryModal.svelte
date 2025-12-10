<script lang="js">
    import Label from "@/Components/ui/label/label.svelte";
    import DuoInput from "./DuoInput.svelte";
    import ModalLayout from "./ModalLayout.svelte";
    import SingleInput from "./SingleInput.svelte";
    import Asterisk from "./Asterisk.svelte";
    import InputError from "@/components/InputError.svelte";

    export let form;
    export let saveNewCemetery;
    export let onCreateCemeteryOpen;
    export let page;

    let modalRef;

    export function open() {
        modalRef.open();
    }

    export function close() {
        modalRef.close();
    }
</script>

<ModalLayout bind:this={modalRef} title="Nieuwe begraafplaats aanmaken" on:open={onCreateCemeteryOpen}>
    <form on:submit={saveNewCemetery}>
        <SingleInput
            type="text"
            name="name"
            visible_name="Naam Begraafplaats"
            placeholder="Vul de naam in"
            requiredBool={true}
            bind:form
        />

        <SingleInput
            type="text"
            name="municipality_id"
            visible_name="Gemeente"
            placeholder="Vul de gemeente in"
            requiredBool={true}
            bind:form
        />

        <SingleInput
            type="text"
            name="city"
            visible_name="Plaats"
            placeholder="Vul de plaats in"
            requiredBool={true}
            bind:form
        />

        <DuoInput
            type="text"
            type2="text"
            name="address"
            name2="zipcode"
            visible_name="Adres"
            visible_name2="Postcode"
            placeholder="Vul het adres in"
            placeholder2="Vul de postcode in"
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

        <SingleInput
            type="file"
            name="image"
            visible_name="Afbeelding"
            placeholder="Upload een afbeelding"
            requiredBool={false}
            bind:form
        />

        {#if $page.props?.flash?.error}
            <div class="padding-btm">
                <InputError message={$page.props.flash.error} />
            </div>
        {/if}

        <div class="full-width flex-m-gap">
            <button class="base full-width" type="button" on:click={() => close()}>Annuleer</button>
            <button class="base full-width" type="submit">Opslaan</button>
        </div>
    </form>
</ModalLayout>