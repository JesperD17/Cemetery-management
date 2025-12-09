<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { Bell } from 'lucide-svelte'; 
  
    interface Props {
      user?: any;
    }
  
    let { user: propUser }: Props = $props();
    const derivedUser = $derived($page?.props?.auth?.user || null);
    const userRole = $derived($page?.props?.auth?.user?.role?.name || null);
  
    const meldingen = writable<any[]>([]);
  
    onMount(async () => {
      try {
        const res = await fetch('/api/meldingen', { credentials: 'same-origin' });
        if (res.ok) {
          const data = await res.json();
          meldingen.set(data);
        }
      } catch (err) {
        console.warn('Kon meldingen niet ophalen:', err);
      }
    });
  </script>
  
  <div class="padding-all row-flex align-center justify-between border-primary-btm bg-primary">
    <div>
      <div class="h2">DNBP</div>
    </div>
  
    <div class="flex-m-gap align-center">
      {#if propUser ?? derivedUser}
        <div class="notification-wrapper">
          <div class="notification-icon" on:click={() => (window.location.href = '/meldingen')}>
            <Bell size="24" />
            {#if $meldingen.length > 0}
              <span class="badge">
                {$meldingen.length > 10 ? '10+' : $meldingen.length}
              </span>
            {/if}
          </div>
  
          <div class="dropdown">
            {#if $meldingen.length > 0}
              {#each $meldingen as melding}
                <div class="dropdown-item {melding.type}">
                  <strong>{melding.title}</strong>
                  <p>{melding.message}</p>
                </div>
              {/each}
            {:else}
              <div class="dropdown-item empty">Geen meldingen</div>
            {/if}
          </div>
        </div>
      {/if}
  
      <Link href={route('home')}>Home</Link>
  
      {#if propUser ?? derivedUser}
        {#if userRole !== 'rechthebbende'}
          <Link href={route('profiel')}>Profiel</Link>
        {/if}
        <Link class="btn primary" href={route('logout')} method="post" as="button">Uitloggen</Link>
      {:else}
        <Link href={route('login')}>Inloggen</Link>
      {/if}
    </div>
  </div>
  
