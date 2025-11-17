<script>
    import { Link } from '@inertiajs/svelte';

    let { status } = $props();
</script>

<div class="forbidden">
  <h1>{status}</h1>
  <p class="message">Sorry! Je hebt geen toegang tot deze pagina.</p>
  <p class="link-text">
    Klik <Link href="/" class="inline-link">hier</Link> om terug te gaan naar de homepagina.
  </p>
</div>
