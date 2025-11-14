<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';

    interface Props {
        user?: any;
    }

    let { user: propUser }: Props = $props();
    const derivedUser = $derived($page?.props?.auth?.user || null);
    const userRole = $derived($page?.props?.auth?.user?.role?.name || null);
</script>

<div class="padding-all row-flex align-center justify-between border-primary-btm bg-primary">
    <div>
        <div class="h2">DNBP</div>
    </div>
    <div class="flex-m-gap align-center">
        <Link href={route('home')}>
            Home
        </Link>
        {#if (propUser ?? derivedUser)}
            <Link href={route('begraafplaatsen')}>
                begraafplaatsen
            </Link>
            {#if (userRole === 'admin')}
                <!-- <Link href={route('import')}>
                    Excel import
                </Link> -->
                <Link href={route('admin')}>
                    Admin
                </Link>
                {#if (userRole === 'admin' || userRole === 'super admin' || userRole === 'beheerder')}
                    <Link href={route('nieuwe-gebruiker')}>
                        Nieuwe gebruiker
                    </Link>
                {/if}
            {/if}
            <Link class="btn primary" href={route('logout')} method="post" as="button">
                Uitloggen
            </Link>
        {:else}
            <Link href={route('login')}>
                Inloggen
            </Link>
        {/if}
    </div>
</div>