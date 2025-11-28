<script lang="ts">
    import AppLogoIcon from '@/components/AppLogoIcon.svelte';
    import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
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
        <Link href={route('home')}>
            <div>
                <AppLogoIcon />
            </div>
        </Link>

        <div class>
            <Card>
                <CardHeader>
                    <CardTitle>{title}</CardTitle>
                    <CardDescription>
                        {description}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    {@render children?.()}
                </CardContent>
            </Card>
        </div>
    </div>
</div>
