<script setup>
import { computed } from 'vue';

// Visual-only LJK answer bubble: printed red ring, filled with 2B pencil when answered
const props = defineProps({
    label: {
        type: String,
        default: '',
    },
    filled: {
        type: Boolean,
        default: false,
    },
    active: {
        type: Boolean,
        default: false,
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
    delay: {
        type: Number,
        default: 0,
    },
});

const sizeClasses = computed(() => ({
    sm: 'size-5 text-[9px]',
    md: 'size-6 text-[11px]',
    lg: 'size-8 text-xs',
}[props.size]));
</script>

<template>
    <span
        aria-hidden="true"
        :class="[
            'relative inline-flex shrink-0 items-center justify-center rounded-full border-[1.5px] font-form font-semibold transition-colors',
            sizeClasses,
            active ? 'border-ink text-ink ring-2 ring-ink/25' : 'border-pen/60 text-pen/80',
        ]"
    >
        {{ label }}
        <span
            v-if="filled"
            class="absolute inset-[2px] rounded-[48%_52%_45%_55%/52%_46%_54%_48%] bg-graphite shadow-[inset_0_0_0_1.5px_rgba(0,0,0,0.25)] motion-safe:animate-pencil"
            :style="{ animationDelay: `${delay}ms` }"
        ></span>
    </span>
</template>
