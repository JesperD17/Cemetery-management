<script lang="js">
    import { Label } from '@/components/ui/label';
    import { Input } from '@/components/ui/input';
    import InputError from "@/components/InputError.svelte";
    import Asterisk from "./Asterisk.svelte";

    export let form;
    export let type;
    export let name;
    export let visible_name;
    export let placeholder;
    export let requiredBool;

    let labels = [];
    let labelInput = '';
    let inputElement;
    
    $: inputWidth = labelInput.length > 0 ? Math.max(40, labelInput.length * 8 + 10) : 40;

    $: if (type === 'labels' && $form[name]) {
        if (Array.isArray($form[name])) {
            labels = $form[name];
        } else if (typeof $form[name] === 'string') {
            labels = $form[name].split(',').map(l => l.trim()).filter(l => l);
        }
    }

    function handleLabelInput(event) {
        const value = event.target.value;
        
        if (value.includes(',')) {
            const newLabels = value.split(',').map(l => l.trim()).filter(l => l);
            labels = [...labels, ...newLabels];
            labelInput = '';
            $form[name] = labels.join(',');
            event.target.value = '';
        }
    }

    function handleLabelKeydown(event) {
        if (event.key === 'Enter' && labelInput.trim()) {
            event.preventDefault();
            labels = [...labels, labelInput.trim()];
            $form[name] = labels.join(',');
            labelInput = '';
        } else if (event.key === 'Backspace' && !labelInput && labels.length > 0) {
            labels = labels.slice(0, -1);
            $form[name] = labels.join(',');
        }
    }

    function removeLabel(index) {
        labels = labels.filter((_, i) => i !== index);
        $form[name] = labels.join(',');
    }
</script>

<div class="padding-btm col-flex">
    <Label for={name}>{visible_name}</Label>
    <div class="flex-s-gap align-center">
        {#if type === 'textarea'}
            <textarea
                id={name}
                name={name}
                rows="4"
                class="full-width padding-s border-radius base desc border-primary"
                placeholder={placeholder}
                required={requiredBool}
                tabindex={1}
                bind:value={$form[name]}
            ></textarea>

        {:else if type === 'labels'}
        <div class="col-flex full-width">
            <div class="custom-select-base border-radius bg-secondary" on:click={() => inputElement?.focus()}>
                <div class="flex align-center wrap full-width">
                    {#each labels as label, i}
                        <span class="label-chip">
                            {label}
                            <button type="button" class="label-remove" on:click={() => removeLabel(i)}>
                                ×
                            </button>
                        </span>
                    {/each}
                    <input
                        type="text"
                        class="label-input"
                        style="width: {inputWidth}px"
                        bind:this={inputElement}
                        bind:value={labelInput}
                        on:input={handleLabelInput}
                        on:keydown={handleLabelKeydown}
                        tabindex={1}
                        required={requiredBool && labels.length === 0}
                    />
                </div>
            </div>
            <div class="example-input">
                {labels.length === 0 ? placeholder : ''}
            </div>
        </div>

        {:else}
            <Input
                class="full-width padding-s bg-secondary border-radius base" 
                id={name}
                type={type}
                required={requiredBool}
                placeholder={placeholder}
                tabindex={1}
                bind:value={$form[name]}
            />
        {/if}
        {#if requiredBool}
            <Asterisk />
        {/if}
    </div>
    <InputError message={$form.errors?.[name]} />
</div>

<style>
    .label-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background-color: var(--primary);
        color: var(--primary-foreground);
        border-radius: 0.375rem;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .label-remove {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        margin-left: 0.25rem;
        font-size: 1.25rem;
        line-height: 1;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .label-remove:hover {
        opacity: 1;
    }

    .label-input {
        border: none;
        outline: none;
        background: transparent;
        font-size: inherit;
        flex: 0 0 auto;
        min-width: 40px;
        max-width: 100%;
        transition: width 0.1s ease;
    }

    .label-input::placeholder {
        opacity: 0.5;
    }

    .example-input {
        font-size: 0.875rem;
        color: #444242;
    }
</style>