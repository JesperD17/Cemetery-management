<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { useForm, page } from '@inertiajs/svelte';
    import { LoaderCircle, Mail, User, Lock, ScanLine, FolderPen, Phone, LandPlot, Milestone } from 'lucide-svelte';
    import Choice from '@/layouts/custom/components/RoleChoice.svelte';
    import LoadingDiv from '@/layouts/custom/components/LoadingDiv.svelte';

    let form = useForm({
        first_name: '',
        infix: '',
        last_name: '',
        phone_number: '',
        address: '',
        zip_code: '',
        email: '',
        password: '',
        password_confirmation: '',
        role_id: '',
    });

    const submit = (e) => {
        e.preventDefault();
        $form.post(route('nieuwe-gebruiker'), {
            onFinish: () => $form.reset('password', 'password_confirmation'),
        });
    };

    var roles = 'laden...';

    async function fetchRoles() {
        try {
            const response = await fetch(`/roles`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();            
            roles = data;
        } catch (error) {
            roles = 'error';
        }
    }

    const rolesPromise = (async () => {
        try {
            await fetchRoles();
        } catch (err) {
            throw err;
        }
    })();
</script>

<svelte:head>
    <title>Nieuwe gebruiker</title>
</svelte:head>

<AppLayout>
    <div class="form-alignment">
        <form class="padding-all bg-primary border-radius" onsubmit={submit}>
            <div class="h1 padding-btm center-flex">Nieuwe account aanmaken</div>
            <div class="flex-m-gap">
                <div class="padding-btm col-flex">
                    <Label for="first_name">Voornaam</Label>
                    <div class="flex-s-gap align-center">
                        <User />
                        <Input
                            id="first_name"
                            type="text"
                            required
                            autofocus
                            tabindex={1}
                            autocomplete="name"
                            bind:value={$form.first_name}
                            placeholder="Ruben"
                        />
                    </div>
                    <InputError message={$form.errors.first_name} />
                </div>
    
                <div class="padding-btm col-flex">
                    <Label for="infix">Tussenvoegsel</Label>
                    <div class="flex-s-gap align-center">
                        <ScanLine />
                        <Input 
                            id="infix" 
                            type="text" 
                            autofocus 
                            tabindex={1} 
                            autocomplete="name" 
                            bind:value={$form.infix} 
                            placeholder="Van" 
                        />
                    </div>
                    <InputError message={$form.errors.infix} />
                </div>
            </div>

            <div class="padding-btm col-flex">
                <Label for="last_name">Achternaam</Label>
                <div class="flex-s-gap align-center">
                    <FolderPen />
                    <Input
                        id="last_name"
                        type="text"
                        required
                        autofocus
                        tabindex={1}
                        autocomplete="name"
                        bind:value={$form.last_name}
                        placeholder="Veen"
                    />
                </div>
                <InputError message={$form.errors.last_name} />
            </div>

            <div class="padding-btm col-flex">
                <Label for="phone_number">Telefoonnummer</Label>
                <div class="flex-s-gap align-center">
                    <Phone />
                    <Input
                        id="phone_number"
                        type="text"
                        autofocus
                        tabindex={1}
                        autocomplete="name"
                        bind:value={$form.phone_number}
                        placeholder="0612345678"
                    />
                </div>
                <InputError message={$form.errors.phone_number} />
            </div>

            <div class="flex-m-gap">
                <div class="padding-btm col-flex">
                    <Label for="address">Adres</Label>
                    <div class="flex-s-gap align-center">
                        <LandPlot />
                        <Input
                            id="address" 
                            type="text" 
                            autofocus 
                            tabindex={1} 
                            autocomplete="name" 
                            bind:value={$form.address} 
                            placeholder="Dorpsstraat 15" />
                    </div>
                    <InputError message={$form.errors.address} />
                </div>
                <div class="padding-btm col-flex">
                    <Label for="zip_code">Postcode</Label>
                    <div class="flex-s-gap align-center">
                        <Milestone />
                        <Input 
                            id="zip_code" 
                            type="text" 
                            autofocus 
                            tabindex={1} 
                            autocomplete="name" 
                            bind:value={$form.zip_code} 
                            placeholder="1234 AB" />
                    </div>
                    <InputError message={$form.errors.zip_code} />
                </div>
            </div>

            <div class="padding-btm col-flex">
                <Label for="email">Email adres</Label>
                <div class="flex-s-gap align-center">
                    <Mail />
                    <Input
                        id="email"
                        type="email"
                        required
                        tabindex={2}
                        autocomplete="email"
                        bind:value={$form.email}
                        placeholder="email@example.com"
                    />
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

            <Choice bind:form />

            {#if $page.props?.flash?.success}
                <div class="padding-btm succes-message">{$page.props.flash.success}</div>
            {/if}

            <div>
                <Button class="full-width relative" type="submit" tabindex={5} disabled={$form.processing}>
                    <LoadingDiv {form} />
                    Account aanmaken
                </Button>
            </div>
        </form>
    </div>
</AppLayout>
