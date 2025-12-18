<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { fetchFromAPI, saveNewData } from '@/layouts/custom/components/Functions';
    import LoadingDiv from '@/layouts/custom/components/LoadingDiv.svelte';
    import SearchableSelect from '@/layouts/custom/components/SearchableSelect.svelte';
    import SelectGraves from '@/layouts/custom/components/SelectGraves.svelte';
    import InputError from '@/components/InputError.svelte';
    import { page, useForm } from '@inertiajs/svelte';

    let selectedGraveId = '';
    let isGraveListLoading = false;

    let form = useForm({
        rightholder_id: '',
        grave_id: '',
    });

    let rightHolders = fetchFromAPI('/api/rightholders');
    let graves = fetchFromAPI('/api/graves');
    
    let grave_id= new URL($page.url, window.location.origin).searchParams.get('graf_id') || '';
    let prefillCemeteryId = '';
    
    if (grave_id) {
        let grave_info = fetchFromAPI(`/api/graveById?id=${grave_id}`);
        grave_info.then((info) => {
            prefillCemeteryId = info?.cemetery_id ?? '';
            selectedGraveId = grave_id;
        });
    }

    $: $form.grave_id = Number(selectedGraveId);

    const submit = (e) => {
        console.log($form);
        saveNewData('/api/linkRightholderToGrave', $form, () => Promise.resolve(), null, e);
    };
</script>

<AppLayout>
    <div class="h1">Rechthebbende koppelen aan een graf</div>
    <div class="section">
        <form on:submit={submit}>
            {#await rightHolders}
                <div class="">Laden rechthebbenden...</div>
                <LoadingDiv />
            {:then rightHoldersData}
                {#await graves}
                    Laden graven...
                    <LoadingDiv />
                {:then gravesData}
                    <div class="flex-m-gap column-flex align-base">
                        <SearchableSelect
                            visible_name="Rechthebbende kiezen"
                            name="rightholder_id"
                            bind:value={$form.rightholder_id}
                            placeholder="Kies een rechthebbende"
                            options={rightHoldersData}
                            requiredBool={true}
                            url_name="Nieuwe rechthebbende"
                            url="nieuwe-gebruiker"
                        />

                        <div class="full-width">
                            <SelectGraves 
                                bind:selectedGraveId 
                                bind:isGraveListLoading 
                                bind:value={prefillCemeteryId} 
                                requiredBool={true} 
                            />
                        </div>
                    </div>
                    <div class="emptyGap-ss"></div>
                    
                    {#if $page.props?.flash?.success1}
                    <div class="padding-btm succes-message">{$page.props.flash.success1}</div>
                    {:else if !$page.props?.flash?.success1 && !$page.props?.flash?.success2 && !$page.props?.flash?.success3 && $page.props?.flash?.success}
                        <div class="padding-btm succes-message">De rechthebbende is succesvol gekoppeld aan het graf.</div>
                    {/if}
                    {#if $page.props?.flash?.error}
                        <div class="padding-btm">
                            <InputError message={$page.props.flash.error} />
                        </div>
                    {/if}
                    <div>
                        <button class="base" type="submit" disabled={isGraveListLoading || !selectedGraveId}>Koppelen</button>
                        <button class="base" type="reset">x</button>
                    </div>
                {:catch error}
                    Fout bij laden graven.
                {/await}
            {:catch error}
                Fout bij laden rechthebbenden.
            {/await}
        </form>
    </div>
</AppLayout>
