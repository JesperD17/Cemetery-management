<script lang="js">
    import { useForm } from "@inertiajs/svelte";

    let form = useForm({
        name: "",
        location: "",
        municipality: "",
        address: "",
        zipcode: "",
        description: "",
        type: "algemeen",
        capacity: "",
        image: null,
    });

    const submit = () => {
        form.post("/begraafplaatsen", {
            forceFormData: true,
            onSuccess: () => form.reset()
        });
    };
</script>

<div class="create-container">
    <h1>Begraafplaats aanmaken</h1>

    <form on:submit|preventDefault={submit} class="form">

        <label>
            Naam
            <input type="text" bind:value={form.name} required />
        </label>
        <div class="row-2">
            <label>
                Adres
                <input type="text" bind:value={form.address} required />
            </label>

            <label>
                Postcode
                <input type="text" bind:value={form.zipcode} required />
            </label>
        </div>

        <label>
            Plaats
            <input type="text" bind:value={form.location} required />
        </label>

        <label>
            Gemeente
            <input type="text" bind:value={form.municipality} required />
        </label>

        <label>
            Beschrijving
            <textarea bind:value={form.description}></textarea>
        </label>

        <label>
            Afbeelding
            <input 
                type="file" 
                accept="image/*"
                on:change={(e) => form.image = e.target.files[0]}
            />
        </label>

        <button type="submit" disabled={form.processing}>
            Aanmaken
        </button>

    </form>
</div>

