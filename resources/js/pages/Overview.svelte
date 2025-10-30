<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';

    export let name;
    
</script>

<svelte:head>
    Overzicht
</svelte:head>

<AppLayout class="section">
    overzicht pagina voor {name}
</AppLayout>
