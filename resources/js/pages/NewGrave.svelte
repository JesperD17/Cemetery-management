<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { useForm, page } from '@inertiajs/svelte';
    import InputError from "@/components/InputError.svelte";
    import { LoaderCircle } from 'lucide-svelte';
    import CemeteryChoice from '@/layouts/custom/components/CemeteryChoice.svelte';
    import Asterisk from "@/layouts/custom/components/Asterisk.svelte";

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
    });
    
    const submit = (e) => {
        e.preventDefault();
        console.log($form);
        
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

            <div class="flex-m-gap">
                <div class="padding-btm col-flex">
                    <Label for="latitude">Latitude</Label>
                    <div class="flex-s-gap align-center">
                        <Input type="text" name="latitude" id="latitude" placeholder="Latitude" required bind:value={$form.latitude} />
                        <Asterisk />
                    </div>
                    <InputError message={$form.errors.latitude} />
                </div>

                <div class="padding-btm col-flex">
                    <Label for="latitude">Longitude</Label>
                    <div class="flex-s-gap align-center">
                        <Input type="text" name="longitude" id="longitude" placeholder="Longitude" required bind:value={$form.longitude} />
                        <Asterisk />
                    </div>
                    <InputError message={$form.errors.longitude} />
                </div>
            </div>

            <div class="padding-btm col-flex">
                <Label for="latitude">Afbeelding</Label>
                <div class="flex-s-gap align-center">
                    <input type="file" id="image_hash_url" name="image_hash_url" required bind:value={$form.image_hash_url} />
                    <Asterisk />
                </div>
                <InputError message={$form.errors.image_hash_url} />
            </div>

            <div class="padding-btm col-flex">
                <Label for="latitude">Grafnummer</Label>
                <div class="flex-s-gap align-center">
                    <Input type="number" name="grave_number" id="grave_number" placeholder="bijv: 1" required bind:value={$form.grave_number} />
                    <Asterisk />
                </div>
                <InputError message={$form.errors.grave_number} />
            </div>
        
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
        
            <div class="padding-btm col-flex">
                <Label for="latitude">Beschrijving</Label>
                <div class="flex-s-gap align-center desc">
                    <textarea class="full-width padding-s border-radius base desc" name="description" id="description" placeholder="Lorem ipsum dolor sit amet." required bind:value={$form.description}></textarea>
                    <Asterisk />
                </div>
                <InputError message={$form.errors.description} />
            </div>

            <div class="flex-m-gap">
                <div class="padding-btm col-flex full-width">
                    <Label for="latitude">Startdatum</Label>
                    <div class="flex-s-gap align-center">
                        <input class="full-width padding-s bg-secondary border-radius base" type="date" name="start_date" id="start_date" placeholder="Start Date" required bind:value={$form.start_date} />
                        <Asterisk />
                    </div>
                    <InputError message={$form.errors.start_date} />
                </div>

                <div class="padding-btm col-flex full-width">
                    <Label for="latitude">Einddatum</Label>
                    <div class="flex-s-gap align-center">
                        <input class="full-width padding-s bg-secondary border-radius base" type="date" name="end_date" id="end_date" placeholder="End Date" required bind:value={$form.end_date} />
                        <Asterisk />
                    </div>
                    <InputError message={$form.errors.end_date} />
                </div>
            </div>

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
                    {#if $form.processing}
                        <LoaderCircle class="spinner" />
                    {/if}
                    Graf aanmaken
                </Button>
            </div>
        </form>
    </div>
</AppLayout>