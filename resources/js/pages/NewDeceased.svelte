<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import DuoInput from "@/layouts/custom/components/DuoInput.svelte";
    import SingleInput from "@/layouts/custom/components/SingleInput.svelte";
    import InputError from "@/components/InputError.svelte";
    import { useForm, page } from "@inertiajs/svelte";

    let form = useForm({
        first_name: '',
        infix: '',
        last_name: '',
        date_of_birth: '',
        date_of_death: '',
        description: '',
    });

    const submit = (e) => {
        e.preventDefault();
        console.log($form);

        $form.post(route('api.new-deceased'), {
            forceFormData: true,
            onSuccess: () => $form.reset(),
        });
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

            {#if $page.props?.flash?.success}
                <div class="padding-btm succes-message">{$page.props.flash.success}</div>
            {/if}
            {#if $page.props?.flash?.error}
                <div class="padding-btm">
                    <InputError message={$page.props.flash.error} />
                </div>
            {/if}

            <div class="full-width flex-m-gap">
                <button class="base full-width" type="submit">Overledene opslaan</button>
            </div>
        </form>
    </div>
</AppLayout>