<script lang="ts">
    import AppContent from '@/components/AppContent.svelte';
    import AppShell from '@/components/AppShell.svelte';
    import AppSidebar from '@/components/AppSidebar.svelte';
    import AppSidebarHeader from '@/components/AppSidebarHeader.svelte';
    import Header from '@/pages/includes/Header.svelte';
    import type { BreadcrumbItemType } from '@/types';
    import type { Snippet } from 'svelte';
    import { page } from '@inertiajs/svelte';

    interface Props {
        breadcrumbs?: BreadcrumbItemType[];
        children?: Snippet;
    }

    let { breadcrumbs = [], children }: Props = $props();

    let user = $derived($page.props.auth.user);
</script>

<AppShell variant="sidebar">
    <!-- <AppSidebar /> -->
    <Header {user} />
    <AppContent variant="sidebar">
        <!-- <AppSidebarHeader {breadcrumbs} /> -->
            <div class="page-width">
                {@render children?.()}
            </div>
    </AppContent>
</AppShell>
