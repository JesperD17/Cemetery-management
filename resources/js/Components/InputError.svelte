<script lang="js">
    let { message, class: className } = $props();

    console.log(message, className)
</script>

{#if message}
    <p class="baseText errorMsg {className}">
        {message}
    </p>
{/if}
