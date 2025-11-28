<script lang="ts">
    import AppLogoIcon from '@/components/AppLogoIcon.svelte';
    import { Link, page } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';

    const name = $page.props.name;
    const quote = $page.props.quote;

    interface Props {
        title: string;
        description: string;
        children?: Snippet;
    }

    let { title, description, children }: Props = $props();
</script>

<div>
    <div>
        <div></div>
        <Link href={route('home')}>
            <AppLogoIcon class="mr-2 size-8 fill-current text-white" />
            {name}
        </Link>
        {#if quote}
            <div>
                <blockquote>
                    <p>&ldquo;{quote.message}&rdquo;</p>
                    <footer>{quote.author}</footer>
                </blockquote>
            </div>
        {/if}
    </div>
    <div>
        <div>
            <div>
                {#if title}
                    <h1>{title}</h1>
                {/if}
                {#if description}
                    <p>{description}</p>
                {/if}
            </div>
            {@render children?.()}
        </div>
    </div>
</div>
