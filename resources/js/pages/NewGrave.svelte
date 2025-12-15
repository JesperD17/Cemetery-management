<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import { Button } from '@/components/ui/button';
    import { Label } from '@/components/ui/label';
    import { useForm, page } from '@inertiajs/svelte';
    import InputError from "@/components/InputError.svelte";
    import CemeteryChoice from '@/layouts/custom/components/CemeteryChoice.svelte';
    import Asterisk from "@/layouts/custom/components/Asterisk.svelte";
    import DuoInput from "@/layouts/custom/components/DuoInput.svelte";
    import SingleInput from "@/layouts/custom/components/SingleInput.svelte";
    import LoadingDiv from "@/layouts/custom/components/LoadingDiv.svelte";

    let form = useForm({
        cemetery_id: "",
        latitude: "",
        longitude: "",
        image_hash_url: "",
        grave_number: "",
        status_id: "",
        description: "",
        start_date: "",
        end_date: "",
        errors: {},
    });
    
    const submit = (e) => {
        e.preventDefault();
        
        $form.post(route('nieuw-graf'), {
            forceFormData: true,
            onFinish: () => $form.reset(),
        });
    };
</script>

<svelte:head>
    <title>DNBP - Administratie</title>
</svelte:head>

<AppLayout>
    <div class="form-alignment">
        <form class="padding-all bg-primary border-radius" on:submit={submit}>
            <div class="h1 padding-btm center-flex">Nieuw graf aanmaken</div>
            
            <CemeteryChoice bind:form />

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
                bind:form
            />

            <SingleInput
                type="file"
                name="image_hash_url"
                visible_name="Afbeelding"
                placeholder="Vul de afbeelding URL in"
                requiredBool={true}
                bind:form
            />

            <SingleInput
                type="text"
                name="grave_number"
                visible_name="Grafnummer"
                placeholder="bijv: 1"
                requiredBool={true}
                bind:form
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
                bind:form
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
            
            <div>
                <Button class="full-width relative" type="submit" tabindex={5} disabled={$form.processing} >
                    <LoadingDiv {form} />
                    Graf aanmaken
                </Button>
            </div>
        </form>
    </div>
</AppLayout>