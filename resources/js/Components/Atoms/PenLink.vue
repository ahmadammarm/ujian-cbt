<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="rounded-sm font-legible font-bold text-ink underline decoration-pen/50 decoration-2 underline-offset-4 hover:decoration-pen focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
    >
        <slot />
    </Link>
</template>
