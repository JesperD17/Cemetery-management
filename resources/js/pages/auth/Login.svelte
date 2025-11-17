<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import { Checkbox } from '@/components/ui/checkbox';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AuthBase from '@/layouts/AuthLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { LoaderCircle, Lock, Mail } from 'lucide-svelte';

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    let { status, canResetPassword } = $props();

    const submit = (e) => {
        e.preventDefault();
        $form.post(route('login'), {
            onFinish: () => $form.reset('password'),
        });
    };

    let isMobile = window.innerWidth < 700;
</script>

<svelte:head>
    <title>Inloggen</title>
</svelte:head>

{#if status}
    <div>
        {status}
    </div>
{/if}

<div class="form-alignment">
    <div class="row-flex border-primary border-radius">
        {#if !isMobile}
            <img src="images/dummy.png" alt="dummy img" class="border-radius-l img-login cover">
        {/if}

        <div class="{isMobile ? '' : 'border-primary-l'}">
            <form onsubmit={submit} 
            class="padding-all bg-primary border-radius{isMobile ? '' : '-r'}">
                <div class="h1 padding-btm center-flex">Inloggen</div>
                <div class="padding-btm col-flex">
                    <Label for="email" class="baseText">Email</Label>
                    <div class="flex-s-gap align-center">
                        <Mail />
                        <Input
                            id="email"
                            type="email"
                            required
                            autofocus
                            tabindex={1}
                            autocomplete="email"
                            bind:value={$form.email}
                            placeholder="email@example.com"
                            class="baseText"
                        />
                    </div>
                    <InputError message={$form.errors.email} />
                </div>

                <div class="padding-btm col-flex">
                    <Label for="wachtwoord" class="baseText">Wachtwoord</Label>

                    <div class="flex-s-gap align-center">
                        <Lock />
                        <Input
                            id="password"
                            type="password"
                            required
                            tabindex={2}
                            autocomplete="current-password"
                            bind:value={$form.password}
                            placeholder="Password"
                        />
                    </div>
                    <InputError message={$form.errors.password} />
                </div>

                <!-- <div>
                    <Label for="remember">
                        <Checkbox id="remember" bind:checked={$form.remember} tabindex={3} class="baseText" />
                        <span>Onthoud mij</span>
                    </Label>
                </div> -->

                <div class="relative emptyGap-{isMobile ? 's' : 'm'} center-flex padding-btm">
                </div>
                
                
                <Button type="submit" tabindex={4} disabled={$form.processing} class="full-width relative">
                    {#if $form.processing}
                        <LoaderCircle class="spinner" />
                    {/if}
                    Inloggen
                </Button>

                <div class="row-flex gap"> 
                    {#if canResetPassword}
                        <TextLink href={route('password.request')} tabindex={5} class="baseText">Wachtwoord vergeten?</TextLink>
                    {/if}
                    <TextLink href={route('register')} tabindex={5} class="baseText text-end">Nog geen account?</TextLink>
                </div>
            </form>
        </div>
    </div>
</div>