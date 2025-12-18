<script lang="js">
    import { onMount, onDestroy } from 'svelte';
    import Asterisk from './Asterisk.svelte';
    import { Label } from '@/Components/ui/label';

    export let visible_name;
    export let form;
    export let value = '';
    export let options = [];
    export let placeholder = 'Selecteer een optie';
    export let disabledText = 'Kies een optie';
    export let onSelect = null;
    export let requiredBool = false;
    export let additionalClasses = '';
    export let url_name = null;
    export let url = null;
    
    let search = '';
    let showList = false;
    let wrapper;

    const normalize = (str = '') => str.toLowerCase();
    const fullName = (o) => [o?.first_name, o?.infix, o?.last_name].filter(Boolean).join(' ').trim();
    const displayText = (o) => o?.name ?? fullName(o) ?? '';
    const combined = (o) => normalize([o?.name, fullName(o)].filter(Boolean).join(' '));
    
    $: filtered =
    options?.filter((o) => {
        const needle = normalize(search.trim());
        if (!needle) return true;

        const haystack = combined(o);
        const tokens = needle.split(/\s+/).filter(Boolean);

        return tokens.every((token) => haystack.includes(token));
    }) ?? [];

    $: if (value && Array.isArray(options) && options.length) {
        const opt = options.find((o) => {
            const idMatch = o?.id !== undefined && String(o.id) === String(value);
            const nameMatch = o?.name !== undefined && String(o.name) === String(value);
            const fullNameMatch = fullName(o) && String(fullName(o)) === String(value);
            return idMatch || nameMatch || fullNameMatch;
        });
        if (opt) {
            const label = displayText(opt);
            if (search !== label) {
                search = label;
            }
        }
    }
        
    function choose(option) {
        value = option?.id ?? option?.name ?? fullName(option) ?? option?.first_name ?? option?.infix ?? option?.last_name ?? '';
        showList = false;
        search = displayText(option);
        dispatchEvent('change');
        if (onSelect) {
            onSelect(option);
        }
    }

    function dispatchEvent(name) {
        const event = new CustomEvent(name, {
            detail: value,
            bubbles: true,
        });
        if (wrapper) {
            wrapper.dispatchEvent(event);
        }
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

<div class="col-flex full-width">
    <div class="flex-s-gap align-end relative full-width {additionalClasses}">
        <div class="col-flex full-width">
            <Label for={visible_name}>{visible_name}</Label>
            <div class="full-width padding-s bg-primary border-radius base" bind:this={wrapper}>
                <input
                    type="text"
                    class="webkit-width flex-s-gap border-radius base border-primary"
                    placeholder={placeholder}
                    on:focus={() => (showList = true)}
                    bind:value={search}
                    required={requiredBool}
                />
    
                {#if showList}
                    <div class="col-flex padding-t-b border-radius bg-custom border-primary dropdown">
                        <div class="padding-L-R">{disabledText}</div>
    
                        {#each filtered as opt}
                            <div class="padding-L-R item" on:click={() => choose(opt)}>
                                {opt?.name ?? opt?.first_name}
                                {#if opt?.infix}
                                    {opt.infix}
                                {/if}
                                {#if opt?.last_name}
                                    {opt.last_name}
                                {/if}
                            </div>
                        {/each}
    
                        {#if filtered.length === 0}
                            <div class="no-results padding-L-R padding-s">Geen resultaten</div>
                        {/if}
                    </div>
                {/if}
            </div>
        </div>
        {#if requiredBool}
            <Asterisk />
        {/if}
    </div>
    {#if url && url_name}
        <a class="link" href={url}>{url_name} aanmaken?</a>
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
        background: #ededed;
    }

    .dropdown {
        position: absolute;
        width: 100%;
        z-index: 1;
        max-height: 200px;
        overflow-y: auto;
    }

    .no-results {
        font-style: italic;
        color: var(--color-text-secondary);
    }
</style>
