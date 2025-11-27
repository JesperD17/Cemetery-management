<script lang="js">
    import { onMount } from "svelte";
    import { useForm } from "@inertiajs/svelte";
    import AppLayout from "@/layouts/AppLayout.svelte";

    let editing = false;
    let loading = true;
    let successMessage = "";
    let errorMessage = "";

    let form = useForm({
        first_name: "",
        infix: "",
        last_name: "",
        address: "",
        zip_code: "",
        email: "",
        phone_number: "",
    });

    onMount(async () => {
        try {
            const res = await fetch("/user", { credentials: "same-origin" });
            if (!res.ok) throw new Error("Kon gebruiker niet ophalen");
            const data = await res.json();

            Object.assign(form, {
                first_name: data.first_name || "",
                infix: data.infix || "",
                last_name: data.last_name || "",
                address: data.address || "",
                zip_code: data.zip_code || "",
                email: data.email || "",
                phone_number: data.phone_number || "",
            });
        } catch (error) {
            console.error("Fout bij ophalen gebruiker:", error);
            errorMessage = "Kon profielgegevens niet ophalen.";
        } finally {
            loading = false;
        }
    });

    function getXsrfFromCookie() {
        const c = document.cookie.split("; ").find((r) => r.startsWith("XSRF-TOKEN="));
        return c ? decodeURIComponent(c.split("=")[1]) : null;
    }
    async function saveNewUserData(e) {
        e.preventDefault();
        successMessage = "";
        errorMessage = "";

        try {
            const csrfToken = getXsrfFromCookie();

            const res = await fetch("/profiel", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-XSRF-TOKEN": csrfToken,
                },
                credentials: "same-origin",
                body: JSON.stringify({ ...form }),
            });

            const text = await res.text();
            const data = text ? JSON.parse(text) : {};

            if (!res.ok) {
                errorMessage = data?.error || "Er is iets misgegaan.";
                return;
            }

            successMessage = data?.message || "Profiel succesvol opgeslagen!";
            editing = false;
        } catch (err) {
            console.error(err);
            errorMessage = "Er is een fout opgetreden bij opslaan.";
        }

        setTimeout(() => {
            successMessage = "";
            errorMessage = "";
        }, 4000);
    }
</script>

<AppLayout>
    <div class="create-container">
        <h1>Profiel</h1>

        {#if loading}
            <div class="loading">⏳ Gegevens laden...</div>
        {:else}
            {#if successMessage}
                <div class="alert success fade">{successMessage}</div>
            {/if}

            {#if errorMessage}
                <div class="alert error fade">{errorMessage}</div>
            {/if}

            <form on:submit|preventDefault={saveNewUserData} class="form">
                <div class="row-3">
                    <label>
                        Voornaam
                        <input type="text" bind:value={form.first_name} disabled={!editing} />
                    </label>

                    <label>
                        Tussenvoegsel
                        <input type="text" bind:value={form.infix} disabled={!editing} placeholder="(optioneel)" />
                    </label>

                    <label>
                        Achternaam
                        <input type="text" bind:value={form.last_name} disabled={!editing} />
                    </label>
                </div>

                <div class="row-2">
                    <label>
                        Adres
                        <input type="text" bind:value={form.address} disabled={!editing} />
                    </label>

                    <label>
                        Postcode
                        <input type="text" bind:value={form.zip_code} disabled={!editing} />
                    </label>
                </div>

                <label>
                    Email
                    <input type="email" bind:value={form.email} disabled={!editing} />
                </label>

                <label>
                    Telefoonnummer
                    <input type="text" bind:value={form.phone_number} disabled={!editing} />
                </label>

                {#if editing}
                    <div class="button-row">
                        <button type="submit">Opslaan</button>
                        <button type="button" on:click={() => (editing = false)} class="cancel">
                            Annuleren
                        </button>
                    </div>
                {:else}
                    <button type="button" class="edit-btn" on:click={() => (editing = true)}>
                        Bewerken
                    </button>
                {/if}
            </form>
        {/if}
    </div>
</AppLayout>
