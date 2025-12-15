<script lang="ts">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { Link, page } from '@inertiajs/svelte';
    import { TableOfContents, BookPlus, UserRoundPlus, UsersRound, Warehouse } from 'lucide-svelte';

    interface Props {
        user?: any;
    }

    let { user: propUser }: Props = $props();
    const derivedUser = $derived($page?.props?.auth?.user || null);
    const userRole = $derived($page?.props?.auth?.user?.role?.name || null);
</script>

<svelte:head>
    <title>Home</title>
</svelte:head>

<AppLayout>
    <!-- <div>
        Home pagina welkom {user ? user.name : 'gast'}
    </div> -->
    <div class="tile-grid">
        {#if (propUser ?? derivedUser)}
            <a href={route('begraafplaatsen')} class="tile">
                <TableOfContents size={60} />
                <p class="tile-text">
                    Begraafplaatsen
                </p>
            </a>
            {#if (userRole === 'beheerder' || userRole === 'super admin')}
                <a href={route('accounts')} class="tile">
                    <UsersRound size={60} />
                    <p class="tile-text">
                        Accounts
                    </p>
                </a>
                <a href={route('nieuw-graf')} class="tile">
                    <BookPlus size={60} />
                    <p class="tile-text">
                        Nieuw graf
                    </p>
                </a>
            {/if}
            {#if (userRole === 'beheerder' || userRole === 'admin' || userRole === 'super admin')}
                <a href={route('nieuwe-gebruiker')} class="tile">
                    <UserRoundPlus size={60} />
                    <p class="tile-text">
                        Nieuwe gebruiker
                    </p>
                </a>
            {/if}
            {#if (userRole === 'beheerder' || userRole === 'super admin')}
                <a href={route('nieuwe-overledene')} class="tile">
                    <Warehouse size={60} />
                    <p class="tile-text">
                        Overledene toevoegen
                    </p>
                </a>
            {/if}
            
        {/if}
    </div>
</AppLayout>