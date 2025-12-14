<script lang="ts">
    import { onMount } from 'svelte';

    let notifications: any[] = [];
    let loading = true;
    let error = '';
  
    onMount(async () => {
      try {
        const res = await fetch('/api/notifications', { credentials: 'same-origin' });
        if (!res.ok) throw new Error('Could not fetch notifications');
  
        notifications = await res.json();
      } catch (err) {
        console.error(err);
        error = 'Something went wrong while fetching notifications.';
      } finally {
        loading = false;
      }
    });
  </script>
  
  <div class="notification">
    <div class="notifications-container">
      <h1>Meldingen</h1>
  
      {#if loading}
        <p>Loading...</p>
      {:else if error}
        <div class="alert error">{error}</div>
      {:else if notifications.length === 0}
        <div class="alert success">No active notifications</div>
      {:else}
        <div class="notifications-list">
          {#each notifications as notification}
            <div class="notification-card {notification.message.includes('expired') ? 'expired' : 'warning'}">
              <h2>{notification.title}</h2>
              <p>{notification.message}</p>
            </div>
          {/each}
        </div>
      {/if}
    </div>
  </div>