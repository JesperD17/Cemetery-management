<script lang="js">
    import Input from '@/Components/ui/input/input.svelte';
    import Label from '@/Components/ui/label/label.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import Choice from '@/layouts/custom/components/RoleChoice.svelte';
    import ModalLayout from '@/layouts/custom/components/ModalLayout.svelte';
    import { useForm } from '@inertiajs/svelte';
    import SingleInput from '@/layouts/custom/components/SingleInput.svelte';
    import DuoInput from '@/layouts/custom/components/DuoInput.svelte';

    var accounts = 'laden...';
    let selected = null;
    let editModal;

    let form = useForm({
        first_name: '',
        infix: '',
        last_name: '',
        phone_number: '',
        address: '',
        zip_code: '',
        email: '',
        role_id: null,
        errors: {},
    });

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
        editModal.open(account);
    }

    function onEditOpen(e) {
        const payload = e.detail;
        selected = payload;
        $form.first_name = payload?.first_name ?? '';
        $form.infix = payload?.infix ?? '';
        $form.last_name = payload?.last_name ?? '';
        $form.phone_number = payload?.phone_number ?? '';
        $form.address = payload?.address ?? '';
        $form.zip_code = payload?.zip_code ?? '';
        $form.email = payload?.email ?? '';
        $form.role_id = payload.role ? payload.role.id : null;
        $form.errors = {};
    }

    function onModalClose() {
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
            const payload = { ...$form };
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
            editModal.close();
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

                <div class="table full-width">
                    <table>
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
                                        <button class="base content-width" id={account.id} on:click={() => openEdit(account)}>Bewerk</button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
            {:else}
                <p>{accounts}</p>
            {/if}
        {/await}
    </div>
</AppLayout>

<ModalLayout bind:this={editModal} title="Account bewerken" on:open={onEditOpen} on:close={onModalClose}>
    <form on:submit={saveAccount}>
        <div class="col-flex">
            <DuoInput
                type="text"
                type2="text"
                name="first_name"
                name2="infix"
                visible_name="Voornaam"
                visible_name2="Tussenvoegsel"
                placeholder="Ruben"
                placeholder2="Van"
                requiredBool={true}
                requiredBool2={false}
                bind:form
            />

            <SingleInput
                type="text"
                name="last_name"
                visible_name="Achternaam"
                placeholder="Veen"
                requiredBool={true}
                bind:form
            />

            <SingleInput
                type="text"
                name="phone_number"
                visible_name="Telefoonnummer"
                placeholder="0612345678"
                requiredBool={false}
                bind:form
            />

            <DuoInput
                type="text"
                type2="text"
                name="address"
                name2="zip_code"
                visible_name="Adres"
                visible_name2="Postcode"
                placeholder="Straat en huisnummer"
                placeholder2="0123 AB"
                requiredBool={false}
                requiredBool2={false}
                bind:form
            />

            <SingleInput
                type="email"
                name="email"
                visible_name="Email"
                placeholder="voorbeeld@domein.com"
                requiredBool={true}
                bind:form
            />

            <Choice bind:form />

            <div class="full-width flex-m-gap">
                <button class="base full-width" type="button" on:click={() => editModal.close()}>Annuleer</button>
                <button class="base full-width" type="submit">Opslaan</button>
            </div>
        </div>
    </form>
</ModalLayout>
