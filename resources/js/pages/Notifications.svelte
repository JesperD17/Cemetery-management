<script lang="ts">
  import AppLayout from '@/layouts/AppLayout.svelte';
import { onMount } from 'svelte';

  let notifications: any[] = [];
  let loading = true;
  let error = '';

  onMount(async () => {
    try {
      const res = await fetch('/api/notifications', { credentials: 'same-origin' });
      if (!res.ok) throw new Error('Kon meldingen niet ophalen');

      notifications = await res.json();
    } catch (err) {
      console.error(err);
      error = 'Er is iets misgegaan bij het ophalen van de meldingen.';
    } finally {
      loading = false;
    }
  });
</script>

<svelte:head>
  <title>DNBP - Meldingen</title>
</svelte:head>
<AppLayout>
  <div class="notification">
    <div class="notifications-container">
      <h1>Meldingen</h1>

      {#if loading}
        <p>Meldingen worden geladen...</p>
      {:else if error}
        <div class="alert error">{error}</div>
      {:else if notifications.length === 0}
        <div class="alert success">Er zijn geen actieve meldingen</div>
      {:else}
        <div class="notifications-list">
          {#each notifications as notification}
            <div
              class="notification-card {notification.message.includes('verlopen') ? 'expired' : 'warning'}"
            >
              <h2>{notification.title}</h2>
              <p>{notification.message}</p>
            </div>
          {/each}
        </div>
      {/if}
    </div>
  </div>
</AppLayout>
