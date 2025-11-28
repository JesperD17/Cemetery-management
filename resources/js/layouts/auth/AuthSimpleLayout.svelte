<script lang="ts">
    import AppLogoIcon from '@/components/AppLogoIcon.svelte';
    import { Link } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';

    interface Props {
        title: string;
        description: string;
        children?: Snippet;
    }

    let { title, description, children }: Props = $props();
</script>

<div>
    <div>
        <div>
            <div>
                <Link href={route('home')}>
                    <div>
                        <!-- <AppLogoIcon /> -->
                    </div>
                    <span>{title}</span>
                </Link>
                <div>
                    <h1>{title}</h1>
                    <p>{description}</p>
                </div>
            </div>
            {@render children?.()}
        </div>
    </div>
</div>
