<script lang="js">
    import InputError from '@/components/InputError.svelte';
    import Input from '@/Components/ui/input/input.svelte';
    import Label from '@/Components/ui/label/label.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import Choice from '@/layouts/custom/components/RoleChoice.svelte';

    var accounts = 'laden...';
    let showModal = false;
    let selected = null;

    let form = {
        first_name: '',
        infix: '',
        last_name: '',
        phone_number: '',
        address: '',
        zip_code: '',
        email: '',
        role_id: null,
    };

    let search = '';
    $: filteredAccounts = Array.isArray(accounts)
        ? (search.trim() === ''
            ? accounts
            : accounts.filter(a => {
                const name = `${a.first_name ?? ''} ${a.infix ?? ''} ${a.last_name ?? ''}`.toLowerCase();
                return name.includes(search.trim().toLowerCase());
            }))
        : accounts;

    async function fetchAccounts() {
        try {
            const response = await fetch(`/getAccounts`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include',
            });
            const data = await response.json();
            accounts = data;
        } catch (error) {
            accounts = 'error';
        }
    }

    function openEdit(account) {
        selected = account;
        form = {
            first_name: account.first_name ?? '',
            infix: account.infix ?? '',
            last_name: account.last_name ?? '',
            phone_number: account.phone_number ?? '',
            address: account.address ?? '',
            zip_code: account.zip_code ?? '',
            email: account.email ?? '',
            role_id: account.role ? account.role.id : null,
        };
        showModal = true;
    }

    function closeModal() {
        showModal = false;
        selected = null;
    }

    function getXsrfFromCookie() {
        const c = document.cookie.split('; ').find((r) => r.startsWith('XSRF-TOKEN='));
        return c ? decodeURIComponent(c.split('=')[1]) : null;
    }

    async function saveAccount(e) {
        e.preventDefault();
        if (!selected) return;
        try {
            const payload = { ...form };
            const csrfToken = getXsrfFromCookie();

            const res = await fetch(`/updateAccount/${selected.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-XSRF-TOKEN': csrfToken,
                },
                credentials: 'include',
                body: JSON.stringify(payload),
            });
            if (!res.ok) throw new Error('Update failed');
            await fetchAccounts();
            closeModal();
        } catch (err) {
            console.error(err);
            alert('Bijwerken mislukt');
        }
    }

    const accountsPromise = (async () => {
        try {
            await fetchAccounts();
        } catch (err) {
            throw err;
        }
    })();
</script>

<svelte:head>
    <title>Accounts</title>
</svelte:head>

<AppLayout>
    <div class="padding-all">
        <h1 class="h2 margin-bottom start-text">Accounts</h1>

        {#await accountsPromise}
            <p>Laden...</p>
        {:then}
            {#if Array.isArray(accounts)}
                <div class="padding-btm">
                    <Label for="search">Zoeken op naam</Label>
                    <div class="flex-s-gap align-center">
                        <Input
                            id="search"
                            type="search"
                            placeholder="Zoek op voornaam, tussenvoegsel of achternaam..."
                            bind:value={search}
                            autocomplete="off"
                        />
                    </div>
                </div>

                <table class="table full-width">
                    <thead>
                        <tr class="start-text">
                            <th>Naam</th>
                            <th>Telefoonnummer</th>
                            <th>Adres</th>
                            <th>Email</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#each filteredAccounts as account}
                            <tr class="start-text">
                                <td>{account.first_name} {account.infix} {account.last_name}</td>
                                <td>{account.phone_number ? account.phone_number : 'Leeg'}</td>
                                <td>{account.address} {account.zip_code ? account.zip_code : 'Leeg'}</td>
                                <td>{account.email}</td>
                                <td>{account.role.name}</td>
                                <!-- edit data popup -->
                                <td class="border-unset">
                                    <button class="base" id={account.id} onclick={() => openEdit(account)}>Bewerk</button>
                                </td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            {:else}
                <p>{accounts}</p>
            {/if}
        {/await}
    </div>
</AppLayout>

{#if showModal}
    <div class="bg-modal-primary">
        <div open={showModal} onClose={closeModal} class="modal-primary">
            <h2 class="h2 margin-bottom">Account bewerken</h2>
            <form onsubmit={saveAccount}>
                <div class="flex-m-gap col-flex">
                    <div class="flex-m-gap">
                        <div class="col-flex">
                            <Label for="first_name">Voornaam</Label>
                            <div class="flex-s-gap align-center">
                                <Input
                                    id="first_name"
                                    type="text"
                                    required
                                    autofocus
                                    tabindex={1}
                                    autocomplete="name"
                                    bind:value={form.first_name}
                                    placeholder="Volledige"
                                />
                            </div>
                            <InputError message={form.errors?.first_name} />
                        </div>
                        <div class="col-flex">
                            <Label for="infix">Tussenvoegsel</Label>
                            <div class="flex-s-gap align-center">
                                <Input id="infix" type="text" tabindex={1} autocomplete="name" bind:value={form.infix} placeholder="Volledige" />
                            </div>
                            <InputError message={form.errors?.infix} />
                        </div>
                    </div>
                    <div class="col-flex">
                        <Label for="last_name">Achternaam</Label>
                        <div class="flex-s-gap align-center">
                            <Input
                                id="last_name"
                                type="text"
                                required
                                tabindex={1}
                                autocomplete="name"
                                bind:value={form.last_name}
                                placeholder="Volledige"
                            />
                        </div>
                        <InputError message={form.errors?.last_name} />
                    </div>
                    <div class="col-flex">
                        <Label for="phone_number">Telefoonnummer</Label>
                        <div class="flex-s-gap align-center">
                            <Input
                                id="phone_number"
                                type="text"
                                tabindex={1}
                                autocomplete="name"
                                bind:value={form.phone_number}
                                placeholder="Volledige"
                            />
                        </div>
                        <InputError message={form.errors?.phone_number} />
                    </div>
                    <div class="flex-m-gap">
                        <div class="col-flex">
                            <Label for="address">Adres</Label>
                            <div class="flex-s-gap align-center">
                                <Input id="address" type="text" tabindex={1} autocomplete="name" bind:value={form.address} placeholder="Volledige" />
                            </div>
                            <InputError message={form.errors?.address} />
                        </div>
                        <div class="col-flex">
                            <Label for="zip_code">Postcode</Label>
                            <div class="flex-s-gap align-center">
                                <Input
                                    id="zip_code"
                                    type="text"
                                    tabindex={1}
                                    autocomplete="postal-code"
                                    bind:value={form.zip_code}
                                    placeholder="Volledige"
                                />
                            </div>
                            <InputError message={form.errors?.zip_code} />
                        </div>
                    </div>
                    <div class="padding-btm col-flex">
                        <Label for="email">Email</Label>
                        <div class="flex-s-gap align-center">
                            <Input
                                id="email"
                                type="email"
                                required
                                tabindex={1}
                                autocomplete="email"
                                bind:value={form.email}
                                placeholder="Volledige"
                            />
                        </div>
                        <InputError message={form.errors?.email} />
                    </div>
                    <Choice bind:form />
                    <div class="full-width flex-m-gap">
                        <button class="base full-width" type="button" onclick={closeModal}>Annuleer</button>
                        <button class="base full-width" type="submit">Opslaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
{/if}
