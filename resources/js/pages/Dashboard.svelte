<script lang="js">
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { userRole } from '@/Components/custom/Global';

    const breadcrumbs = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
    ];
    
</script>

<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<!-- Todo - remove applayout, use logout button before deletion -->
<AppLayout {breadcrumbs}>
    <div>
        {$userRole}
    </div>
</AppLayout>
