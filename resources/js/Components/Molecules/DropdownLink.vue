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
        class="block w-full px-4 py-2 text-start font-legible text-sm leading-5 text-ink transition-colors hover:bg-rule/40 focus:bg-rule/40 focus:outline-none motion-reduce:transition-none"
    >
        <slot />
    </Link>
</template>
