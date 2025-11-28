<script lang="ts">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { LoaderCircle, Lock } from 'lucide-svelte';

    const form = useForm({
        password: '',
    });

    const submit = (e: Event) => {
        e.preventDefault();

        $form.post(route('password.confirm'), {
            onFinish: () => {
                $form.reset();
            },
        });
    };
</script>

<svelte:head>
    <title>Wachtwoord bevestigen</title>
</svelte:head>

<div class="form-alignment">
    <div class="row-flex border-primary border-radius">
        <form onsubmit={submit}>
            <div class="h1 padding-btm center-flex">Wachtwoord Bevestigen</div>
            <div class="padding-btm col-flex">
                <Label for="password">Wachtwoord</Label>
                <div class="flex-s-gap align-center">
                    <Lock />
                    <Input
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        bind:value={$form.password}
                        required
                        autocomplete="current-password"
                        autofocus
                    />
                </div>
                <InputError message={$form.errors.password} />
            </div>

            <div class="flex items-center">
                <Button class="full-width relative" disabled={$form.processing}>
                    {#if $form.processing}
                        <LoaderCircle class="spinner" />
                    {/if}
                    Confirm Password
                </Button>
            </div>
        </form>
    </div>
</div>