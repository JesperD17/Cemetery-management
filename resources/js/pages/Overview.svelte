<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';

    export let name;
    
</script>

<svelte:head>
    Overzicht
</svelte:head>

<AppLayout class="section">
    <div class="h1 padding-btm">
        Locatie {name}
    </div>
    
</AppLayout>
