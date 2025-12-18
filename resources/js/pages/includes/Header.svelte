<script lang="ts">
  import { Link, page } from '@inertiajs/svelte';
  import NotificationsDropdown from '@/layouts/custom/components/NotificationsDropdown.svelte';

  interface Props {
    user?: any;
  }

  let { user: propUser }: Props = $props();
  const derivedUser = $derived($page?.props?.auth?.user || null);
</script>

<div class="padding-all row-flex align-center justify-between border-primary-btm bg-primary">
  <div class="h2">DNBP</div>

  <div class="flex-m-gap align-center">
    {#if propUser ?? derivedUser}
      <NotificationsDropdown />
    {/if}
    <Link href={route('home')}>Home</Link>

    {#if propUser ?? derivedUser}      
      <Link href={route('profiel')}>Profiel</Link>

      <Link
        class="btn primary"
        href={route('logout')}
        method="post"
        as="button"
      >
        Uitloggen
      </Link>
    {:else}
      <Link href={route('login')}>Inloggen</Link>
    {/if}
  </div>
</div>
