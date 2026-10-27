<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav v-if="links.length > 3" aria-label="Halaman">
        <ul class="flex flex-wrap items-center gap-1.5">
            <li v-for="(link, key) in links" :key="key">
                <span
                    v-if="link.url === null"
                    class="inline-flex h-9 min-w-9 select-none items-center justify-center rounded-md px-3 font-legible text-sm text-ink-soft/50"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :href="link.url"
                    :aria-current="link.active ? 'page' : undefined"
                    :class="[
                        'inline-flex h-9 min-w-9 items-center justify-center rounded-md border px-3 font-legible text-sm transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen motion-reduce:transition-none',
                        link.active
                            ? 'border-ink bg-ink font-bold text-paper'
                            : 'border-rule bg-paper text-ink hover:border-ink-soft',
                    ]"
                    v-html="link.label"
                />
            </li>
        </ul>
    </nav>
</template>
