<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { LoaderCircle, Mail } from 'lucide-svelte';

    interface Props {
        status?: string;
    }

    const form = useForm({
        email: '',
    });

    const submit = (e: Event) => {
        e.preventDefault();
        $form.post(route('password.email'));
    };

    let { status }: Props = $props();

    let isMobile = window.innerWidth < 700;
</script>

<svelte:head>
    <title>Wachtwoord vergeten</title>
</svelte:head>

{#if status}
    <div class="mb-4 text-center text-sm font-medium text-green-600">
        {status}
    </div>
{/if}

<div class="form-alignment">
    <div class="row-flex border-primary border-radius">
        <form onsubmit={submit}
        class="padding-all bg-primary border-radius">
        <div class="h1 padding-btm center-flex">Wachtwoord vergeten</div>
            <div>
                <div class="baseText padding-btm">
                    Vul je email adres in en wij sturen je een link<br> om je wachtwoord te resetten.
                </div>
            </div>

            <div class="padding-btm col-flex">
                <Label class="baseText" for="email">Email</Label>
                <div class="flex-s-gap align-center">
                    <Mail />
                    <Input id="email" type="email" name="email" autocomplete="off" bind:value={$form.email} autofocus placeholder="email@example.com" />
                </div>
                <InputError message={$form.errors.email} />
            </div>

            <div class="emptyGap-{isMobile ? 'ss' : 's'} center-flex"></div>

            <div class="col-flex gap">
                <Button class="full-width relative" type="submit" disabled={$form.processing}>
                    {#if $form.processing}
                        <LoaderCircle class="spinner" />
                    {/if}
                    Wachtwoord resetten
                </Button>
                <div class="row-flex gap justify-end">
                    <TextLink href={route('login')}>Inloggen</TextLink>
                    <!-- <TextLink href={route('register')}>Registreren</TextLink> -->
                </div>
            </div>
        </form>

    </div>
</div>