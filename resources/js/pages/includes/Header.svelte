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

  const notifications = writable<any[]>([]);

  onMount(async () => {
    try {
      const res = await fetch('/api/notifications', { credentials: 'same-origin' });
      if (res.ok) {
        const data = await res.json();
        notifications.set(data);
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
          {#if $notifications.length > 0}
            <span class="badge">
              {$notifications.length > 10 ? '10+' : $notifications.length}
            </span>
          {/if}
        </div>

        <div class="dropdown">
          {#if $notifications.length > 0}
            {#each $notifications as melding}
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

<style>
.notification-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  overflow: visible;
  z-index: 1000;
}

/* 🔔 Bel */
.notification-icon {
  cursor: pointer;
  position: relative;
  transition: transform 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-icon:hover {
  transform: scale(1.1);
}

/* 🔴 Badge */
.badge {
  position: absolute;
  top: -5px;
  right: -8px;
  background: red;
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 0.75rem;
  font-weight: bold;
}

/* 📩 Dropdown */
.dropdown {
  position: absolute;
  top: 38px;
  right: 0;
  width: 280px;
  background: white;
  color: black;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  z-index: 9999;
  padding: 0.5rem;

  opacity: 0;
  pointer-events: none;
  transform: translateY(-8px);
  transition: opacity 0.2s ease, transform 0.2s ease;
}

/* 👇 Hover activeert dropdown */
.notification-wrapper:hover > .dropdown {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}

/* 💬 Items */
.dropdown-item {
  padding: 0.6rem;
  border-bottom: 1px solid #eee;
  cursor: pointer;
}

.dropdown-item:last-child {
  border-bottom: none;
}

.dropdown-item:hover {
  background: #f9f9f9;
}

.dropdown-item strong {
  display: block;
  margin-bottom: 2px;
}

.dropdown-item p {
  margin: 0;
  font-size: 0.85rem;
}

/* ⚠️ Types */
.dropdown-item.warning {
  border-left: 4px solid orange;
  padding-left: 0.5rem;
}

.dropdown-item.expired {
  border-left: 4px solid red;
  padding-left: 0.5rem;
}

/* 🕳️ Empty */
.dropdown-item.empty {
  text-align: center;
  color: #777;
}
</style>
