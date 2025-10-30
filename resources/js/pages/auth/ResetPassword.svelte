<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { LoaderCircle } from 'lucide-svelte';

    interface Props {
        token: string;
        email: string;
    }

    let { token, email }: Props = $props();

    const form = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    });

    const submit = (e: Event) => {
        e.preventDefault();
        $form.post(route('password.store'), {
            onFinish: () => {
                $form.reset('password', 'password_confirmation');
            },
        });
    };
</script>

<svelte:head>
    <title>Wachtwoord resetten</title>
</svelte:head>

<form onsubmit={submit}>
    <div class="grid gap-6">
        <div class="grid gap-2">
            <Label for="email">Email</Label>
            <Input id="email" type="email" name="email" autocomplete="email" bind:value={$form.email} class="mt-1 block w-full" readonly />
            <InputError message={$form.errors.email} class="mt-2" />
        </div>

        <div class="grid gap-2">
            <Label for="password">Wachtwoord</Label>
            <Input
                id="password"
                type="password"
                name="password"
                autocomplete="new-password"
                bind:value={$form.password}
                class="mt-1 block w-full"
                autofocus
                placeholder="Wachtwoord"
            />
            <InputError message={$form.errors.password} />
        </div>

        <div class="grid gap-2">
            <Label for="password_confirmation">Bevestig Wachtwoord</Label>
            <Input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                autocomplete="new-password"
                bind:value={$form.password_confirmation}
                class="mt-1 block w-full"
                placeholder="Bevestig wachtwoord"
            />
            <InputError message={$form.errors.password_confirmation} />
        </div>

        <Button class="full-width relative" type="submit" disabled={$form.processing}>
            {#if $form.processing}
                <LoaderCircle class="spinner" />
            {/if}
            Wachtwoord resetten
        </Button>
    </div>
</form>