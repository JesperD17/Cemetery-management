<script lang="js">
    import { LoaderCircle } from "lucide-svelte";

    export let form;
</script>

{#if $form.processing}
    <div class="spinner-bg">
        <LoaderCircle class="spinner" />
    </div>
{/if}