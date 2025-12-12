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
</script>

<div class="padding-btm col-flex">
    <Label for={name}>{visible_name}</Label>
    <div class="flex-s-gap align-center">
        {#if type === 'textarea'}
            <textarea
                id={name}
                name={name}
                rows="4"
                class="full-width padding-s border-radius base desc"
                placeholder={placeholder}
                required={requiredBool}
                tabindex={1}
                bind:value={$form[name]}
            ></textarea>
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