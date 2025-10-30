<script lang="ts">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link, page } from '@inertiajs/svelte';

    let user = $derived($page.props.auth.user);
</script>

<svelte:head>
    <title>Home</title>
</svelte:head>

<AppLayout>
    <div>
        Home pagina welkom {user ? user.name : 'gast'}
    </div>
</AppLayout>