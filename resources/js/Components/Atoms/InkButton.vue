<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

// Renders an Inertia Link when `href` is given, otherwise a native button (e.g. form submit)
const props = defineProps({
    href: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: 'submit',
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md'].includes(value),
    },
});

const sizeClasses = computed(() =>
    props.size === 'sm'
        ? 'px-5 py-2 text-sm shadow-[0_3px_0_#0E1A4F]'
        : 'px-7 py-3.5 text-base shadow-[0_4px_0_#0E1A4F]'
);
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href ?? undefined"
        :type="href ? undefined : type"
        :class="[
            'inline-flex items-center justify-center gap-2 rounded-full bg-ink font-legible font-bold text-paper transition-transform hover:-translate-y-0.5 active:translate-y-0.5 active:shadow-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen focus-visible:ring-offset-2 focus-visible:ring-offset-paper disabled:pointer-events-none disabled:opacity-60 motion-reduce:transition-none',
            sizeClasses,
        ]"
    >
        <slot />
    </component>
</template>
