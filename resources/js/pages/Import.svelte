<script lang="ts">
    import Button from "@/Components/ui/button/button.svelte";
    import Input from "@/Components/ui/input/input.svelte";
    import AppLayout from "@/layouts/AppLayout.svelte";
    import { useForm } from "@inertiajs/svelte";

    const form = useForm({
        file: null as File | null,
    });

    let { status } = $props();

    function handleFileChange(event: Event) {
        const target = event.target as HTMLInputElement;
        if (target.files && target.files.length > 0) {
            $form.file = target.files[0];
        } else {
            $form.file = null;
        }
    }

    const submit = (e: Event) => {
        e.preventDefault();
        console.log($form.file, 'test');
        $form.post(route('import'), {
            forceFormData: true,
        });
    };
</script>

<svelte:head>
    <title>DNBP - Administratie</title>
</svelte:head>

<AppLayout>
    <form onsubmit={submit}>

        <Input 
            type="file" 
            placeholder="file" 
            accept=".csv, .xls, .xlsx" 
            onchange={handleFileChange}
        />

        <Button type="submit" >import</Button>
    </form>
</AppLayout>