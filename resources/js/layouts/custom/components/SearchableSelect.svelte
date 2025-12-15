<script lang="js">
    import { onMount, onDestroy } from 'svelte';
    import Asterisk from './Asterisk.svelte';

    export let value = "";
    export let options = [];
    export let placeholder = "Selecteer een optie";
    export let disabledText = "Kies een optie";
    export let onSelect = null;
    export let requiredBool = false;
    export let additionalClasses = "";

    let search = "";
    let showList = false;
    let wrapper;

    $: filtered = options?.filter(o =>
        o?.name?.toLowerCase().includes(search.toLowerCase())
    ) ?? [];

    function choose(option) {
        value = option.id;
        showList = false;
        search = option.name;
        dispatchEvent("change");
        if (onSelect) {
            onSelect(option);
        }
    }

    function dispatchEvent(name) {
        const event = new CustomEvent(name, {
            detail: value,
            bubbles: true,
        });
        wrapper.dispatchEvent(event);
    }

    function handleClickOutside(event) {
        if (wrapper && !wrapper.contains(event.target)) {
            showList = false;
        }
    }

    onMount(() => {
        document.addEventListener('click', handleClickOutside);
    });

    onDestroy(() => {
        document.removeEventListener('click', handleClickOutside);
    });
</script>

<div class="flex-s-gap align-center relative full-width {additionalClasses}">
    <div class="full-width padding-s bg-primary border-radius base" bind:this={wrapper}>
        <input
            type="text"
            class="webkit-width flex-s-gap border-radius base"
            placeholder={placeholder}
            on:focus={() => showList = true}
            bind:value={search}
            required={requiredBool}
        />

        {#if showList}
            <div class="col-flex padding-t-b border-radius bg-custom border-primary dropdown">
                <div class="padding-L-R">{disabledText}</div>

                {#each filtered as opt}
                    <div
                        class="padding-L-R item"
                        on:click={() => choose(opt)}
                    >
                        {opt.name}
                    </div>
                {/each}

                {#if filtered.length === 0}
                    <div class="no-results padding-L-R padding-s">Geen resultaten</div>
                {/if}
            </div>
        {/if}
    </div>
    {#if requiredBool}
        <Asterisk />
    {/if}
</div>

<style>
    .item:hover {
        background-color: lightblue;
        cursor: pointer;
    }

    .padding-t-b {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .bg-custom {
        background: #EDEDED;
    }

    .dropdown {
        position: absolute;
        width: 100%;
        z-index: 1;
    }

    .no-results {
        font-style: italic;
        color: var(--color-text-secondary);
    }
</style>