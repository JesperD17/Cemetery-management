<script lang="ts">
    import TextLink from '@/components/TextLink.svelte';
    import { Button } from '@/components/ui/button';
    import AuthLayout from '@/layouts/AuthLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { LoaderCircle } from 'lucide-svelte';

    interface Props {
        status?: string;
    }
    let { status }: Props = $props();

    const form = useForm({});

    const submit = (e: Event) => {
        e.preventDefault();
        $form.post(route('verification.send'));
    };
</script>

<svelte:head>
    <title>Verificatie E-mail</title>
</svelte:head>

{#if status === 'verification-link-sent'}
    <div class="mb-4 text-center text-sm font-medium text-green-600">
        Een nieuwe verificatielink is naar uw e-mailadres verzonden.
    </div>
{/if}

<form onsubmit={submit} class="space-y-6 text-center">
    <Button class="full-width relative" disabled={$form.processing} variant="secondary">
        {#if $form.processing}
            <LoaderCircle class="spinner" />
        {/if}
        Opnieuw verificatie e-mail verzenden
    </Button>

    <TextLink href={route('logout')} method="post" as="button" class="mx-auto block text-sm">Uitloggen</TextLink>
</form>