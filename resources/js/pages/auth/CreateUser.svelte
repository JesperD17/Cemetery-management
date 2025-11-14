<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import AuthBase from '@/layouts/AuthLayout.svelte';
    import { useForm, page } from '@inertiajs/svelte';
    import { LoaderCircle, Mail, User, Lock } from 'lucide-svelte';

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        $form.post(route('nieuwe-gebruiker'), {
            onFinish: () => $form.reset('password', 'password_confirmation'),
        });
    };
</script>

<svelte:head>
    <title>Nieuwe gebruiker</title>
</svelte:head>

<AppLayout>
    <div class="form-alignment">
        <form class="padding-all bg-primary border-radius" onsubmit={submit}>
            <div class="h1 padding-btm center-flex">Nieuwe account aanmaken</div>
            <div class="padding-btm col-flex">
                <Label for="name">Naam</Label>
                <div class="flex-s-gap align-center">
                    <User />
                    <Input id="name" type="text" required autofocus tabindex={1} autocomplete="name" bind:value={$form.name} placeholder="Volledige" />
                </div>
                <InputError message={$form.errors.name} />
            </div>

            <div class="padding-btm col-flex">
                <Label for="email">Email adres</Label>
                <div class="flex-s-gap align-center">
                    <Mail />
                    <Input id="email" type="email" required tabindex={2} autocomplete="email" bind:value={$form.email} placeholder="email@example.com" />
                </div>
                <InputError message={$form.errors.email} />
            </div>

            <div class="padding-btm col-flex">
                <Label for="password">Wachtwoord</Label>
                <div class="flex-s-gap align-center">
                    <Lock />
                    <Input
                        id="password"
                        type="password"
                        required
                        tabindex={3}
                        autocomplete="new-password"
                        bind:value={$form.password}
                        placeholder="Wachtwoord"
                    />
                </div>
                <InputError message={$form.errors.password} />
            </div>

            <div class="padding-btm col-flex">
                <Label for="password_confirmation">Bevestig wachtwoord</Label>
                <div class="flex-s-gap align-center">
                    <Lock />
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        tabindex={4}
                        autocomplete="new-password"
                        bind:value={$form.password_confirmation}
                        placeholder="Bevestig wachtwoord"
                    />
                </div>
                <InputError message={$form.errors.password_confirmation} />
            </div>

            {#if $page.props?.flash?.success}
                <div class="padding-btm succes-message">{$page.props.flash.success}</div>
            {/if}

            <div>
                <Button class="full-width relative" type="submit" tabindex={5} disabled={$form.processing}>
                    {#if $form.processing}
                        <LoaderCircle class="spinner" />
                    {/if}
                    Account aanmaken
                </Button>
            </div>
        </form>
    </div>
</AppLayout>