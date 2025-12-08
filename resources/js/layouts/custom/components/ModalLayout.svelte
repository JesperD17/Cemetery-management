<script>
	import { createEventDispatcher, onMount, onDestroy } from 'svelte';

	export let visible = false;
	export let title = '';

	const dispatch = createEventDispatcher();
	let context = null;

	export function open(payload = null) {
		context = payload;
		visible = true;
		dispatch('open', payload);
	}

	export function close() {
		context = null;
		visible = false;
		dispatch('close');
	}

	function onKey(e) {
		if (e.key === 'Escape') close();
	}

	onMount(() => window.addEventListener('keydown', onKey));
	onDestroy(() => window.removeEventListener('keydown', onKey));

	function backgroundClick(e) {
		if (e.target.classList && e.target.classList.contains('bg-modal-primary')) close();
	}

	function overlayKey(e) {
		if (e.key === 'Enter' || e.key === ' ') {
			e.preventDefault();
			close();
		}
	}
</script>

{#if visible}
	<div class="bg-modal-primary" on:click={backgroundClick} on:keydown={overlayKey} role="button" tabindex="0">
		<div class="modal-primary" role="dialog" aria-modal="true" aria-label={title}>
			{#if title}
				<h2 class="h2 margin-bottom">{title}</h2>
			{/if}
			<slot {context} />
		</div>
	</div>
{/if}

