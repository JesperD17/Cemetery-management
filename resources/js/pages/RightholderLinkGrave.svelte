<script lang="js">
    import AppLayout from "@/layouts/AppLayout.svelte";
    import { fetchFromAPI } from "@/layouts/custom/components/Functions";
    import LoadingDiv from "@/layouts/custom/components/LoadingDiv.svelte";
    import SearchableSelect from "@/layouts/custom/components/SearchableSelect.svelte";

    let rightHolders = fetchFromAPI('/api/rightholders');
    let graves = fetchFromAPI('/api/graves');
    
</script>


<AppLayout>
    <div class="h1">Rechthebbende koppelen aan graf</div>
    <div class="section">
        <div class="flex-m-gap column-flex align-center">
            {#await rightHolders}
                <div class="">
                    Laden rechthebbenden...
                </div>
                <LoadingDiv />
            {:then rightHoldersData}
                {#await graves}
                    Laden graven...
                    <LoadingDiv />
                {:then gravesData}
                    <SearchableSelect
                        visible_name="Rechthebbende kiezen"
                        name="rightholder_id"
                        options={rightHoldersData}
                    />
                {:catch error}
                    Fout bij laden graven.
                {/await}
            {:catch error}
                Fout bij laden rechthebbenden.
            {/await}
        </div>
    </div>
</AppLayout>