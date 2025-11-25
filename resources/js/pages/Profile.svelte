<script lang="js">
    import { useForm } from "@inertiajs/svelte";

    let form = useForm({
        first_name: "",
        infix: "",
        last_name: "",
        address: "",
        postal_code: "",
        email: "",
        phone: "",
        avatar: null,
    });

    function submit() {
        form.post("/profiel", {
            forceFormData: true,
            onSuccess: () => form.reset(),
        });
    }
</script>

<div class="create-container">
    <h1>Profiel aanmaken</h1>

    <form on:submit|preventDefault={submit} class="form">
        <div class="row-3">
            <label>
                Voornaam
                <input type="text" bind:value={form.first_name} required />
            </label>

            <label>
                Tussenvoegsel
                <input type="text" bind:value={form.infix} placeholder="(optioneel)" />
            </label>

            <label>
                Achternaam
                <input type="text" bind:value={form.last_name} required />
            </label>
        </div>

        <!-- ADRES + POSTCODE -->
        <div class="row-2">
            <label>
                Adres
                <input type="text" bind:value={form.address} required />
            </label>

            <label>
                Postcode
                <input type="text" bind:value={form.postal_code} required />
            </label>
        </div>

        <label>
            Email
            <input type="email" bind:value={form.email} required />
        </label>

        <label>
            Telefoonnummer
            <input type="text" bind:value={form.phone} />
        </label>
        <button type="submit" disabled={form.processing}>
            Aanmaken
        </button>

    </form>
</div>

