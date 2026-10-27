<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

// Secondary action paired with InkButton; same sizing so the two line up side by side
const props = defineProps({
    href: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: 'button',
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md'].includes(value),
    },
    variant: {
        type: String,
        default: 'ink',
        validator: (value) => ['ink', 'danger'].includes(value),
    },
});

const sizeClasses = computed(() => (props.size === 'sm' ? 'px-4 py-1.5 text-sm' : 'px-6 py-3 text-base'));

const variantClasses = computed(() =>
    props.variant === 'danger'
        ? 'border-pen text-pen hover:bg-pen/10'
        : 'border-ink text-ink hover:bg-rule/50'
);
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href ?? undefined"
        :type="href ? undefined : type"
        :class="[
            'inline-flex items-center justify-center gap-2 rounded-full border-2 bg-paper font-legible font-bold transition-colors active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen focus-visible:ring-offset-2 focus-visible:ring-offset-paper disabled:pointer-events-none disabled:opacity-50 motion-reduce:transition-none',
            sizeClasses,
            variantClasses,
        ]"
    >
        <slot />
    </component>
</template>
