<script lang="js">
    import { Label } from '@/components/ui/label';
    import { Input } from '@/components/ui/input';
    import InputError from "@/components/InputError.svelte";
    import Asterisk from "./Asterisk.svelte";

    export let form;
    export let type;
    export let type2;
    export let name;
    export let name2;
    export let visible_name;
    export let visible_name2;
    export let placeholder;
    export let placeholder2;
    export let requiredBool;
    export let requiredBool2;

    
</script>

<div class="flex-m-gap">
    <div class="padding-btm col-flex full-width">
        <Label for="{name}">{visible_name}</Label>
        <div class="flex-s-gap align-center">
            <Input 
                class="full-width padding-s bg-secondary border-radius base" 
                type={type}
                name={name} 
                id={name} 
                placeholder={placeholder} 
                required={requiredBool} 
                bind:value={$form[name]} 
                
            />
            {#if requiredBool}
                <Asterisk />
            {/if}
        </div>
        <InputError message={$form.errors?.[name]} />
    </div>

    <div class="padding-btm col-flex full-width">
        <Label for="{name2}">{visible_name2}</Label>
        <div class="flex-s-gap align-center">
            <Input 
                class="full-width padding-s bg-secondary border-radius base" 
                type={type2}
                name={name2} 
                id={name2} 
                placeholder={placeholder2} 
                required={requiredBool2} 
                bind:value={$form[name2]}
                
            />
            {#if requiredBool2}
                <Asterisk />
            {/if}
        </div>
        <InputError message={$form.errors?.[name2]} />
    </div>
</div>