<script lang="ts">
    import { onMount } from 'svelte';
    import { writable } from 'svelte/store';
    import { Link } from '@inertiajs/svelte';
    import { Bell } from 'lucide-svelte';
  
    export let fetchUrl: string = '/api/notifications';
    const notifications = writable<any[]>([]);
  
    onMount(async () => {
      try {
        const res = await fetch(fetchUrl, { credentials: 'same-origin' });
        if (res.ok) notifications.set(await res.json());
      } catch {
        console.warn('Could not fetch notifications');
      }
    });
  </script>
  
  <div class="notification">
    <div class="notification-wrapper">
      <Link href={route('meldingen')} class="notification-icon">
        <Bell size="24" />
        {#if $notifications.length > 0}
          <span class="badge">{$notifications.length > 9 ? '9+' : $notifications.length}</span>
        {/if}
      </Link>
  
      <div class="notification-preview">
        {#if $notifications.length > 0}
          {#each $notifications as notification}
            <div class="notification-item {notification.type}">
              <strong>{notification.title}</strong>
              <p>{notification.message}</p>
            </div>
          {/each}
        {:else}
          <div class="notification-item empty">Geen meldingen</div>
        {/if}
      </div>
    </div>
  </div>
  