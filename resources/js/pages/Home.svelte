<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';

    let user = $derived($page.props.auth.user);
</script>

<svelte:head>
    <title>Locatie ...</title>
    <!-- <link rel="preconnect" href="https://rsms.me/" /> -->
    <!-- <link rel="stylesheet" href="https://rsms.me/inter/inter.css" /> -->
</svelte:head>

<div>
    {#if user}
        <Link href={route('overview')}>
            Dashboard
        </Link>
    {:else}
        <Link href={route('login')}>
            Log in
        </Link>
        <Link href={route('register')}>
            Register
        </Link>
    {/if}
</div>
