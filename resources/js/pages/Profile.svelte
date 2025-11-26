<script lang="js">
    import { onMount } from "svelte";
    import { useForm } from "@inertiajs/svelte";

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
            const res = await fetch("/user", {
                credentials: "same-origin"
            });

            if (!res.ok) throw new Error("Kon gebruiker niet ophalen");

            const data = await res.json();

            form.first_name = data.first_name || "";
            form.infix = data.infix || "";
            form.last_name = data.last_name || "";
            form.address = data.address || "";
            form.zip_code = data.zip_code || "";
            form.email = data.email || "";
            form.phone_number = data.phone_number || "";
        } catch (error) {
            console.error("Fout bij ophalen gebruiker:", error);
        }
    });

    function getXsrfFromCookie() {
        const c = document.cookie
            .split("; ")
            .find((r) => r.startsWith("XSRF-TOKEN="));

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

            let data = {};
            try {
                const text = await res.text();
                if (text) data = JSON.parse(text);
            } catch {
                console.warn("Geen geldige JSON terug");
            }

            if (!res.ok) {
                errorMessage = data?.error || "Er is iets misgegaan.";
                return;
            }

            successMessage = data?.message || "Profiel opgeslagen!";
        } catch (err) {
            console.error(err);
            errorMessage = "Er is een fout opgetreden bij opslaan.";
        }
    }
</script>

<div class="create-container">
    <h1>Profiel bewerken</h1>

    {#if successMessage}
        <p class="success">{successMessage}</p>
    {/if}

    {#if errorMessage}
        <p class="error">{errorMessage}</p>
    {/if}

    <form on:submit|preventDefault={saveNewUserData} class="form">
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

        <div class="row-2">
            <label>
                Adres
                <input type="text" bind:value={form.address} required />
            </label>

            <label>
                Postcode
                <input type="text" bind:value={form.zip_code} required />
            </label>
        </div>

        <label>
            Email
            <input type="email" bind:value={form.email} required />
        </label>

        <label>
            Telefoonnummer
            <input type="text" bind:value={form.phone_number} />
        </label>

        <button type="submit">
            Opslaan
        </button>
    </form>
</div>

