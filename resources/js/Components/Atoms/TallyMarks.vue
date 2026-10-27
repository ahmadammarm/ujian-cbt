<script setup>
import { computed } from 'vue';

// Hand-drawn tally strokes; the parent supplies the accessible text
const props = defineProps({
    count: {
        type: Number,
        required: true,
    },
    highlightLast: {
        type: Boolean,
        default: false,
    },
    tone: {
        type: String,
        default: 'graphite',
        validator: (value) => ['graphite', 'pen', 'ink'].includes(value),
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md'].includes(value),
    },
});

const toneClass = computed(() => ({ graphite: 'bg-graphite', pen: 'bg-pen', ink: 'bg-ink' }[props.tone]));
const strokeClass = computed(() => (props.size === 'sm' ? 'h-4 w-[2px]' : 'h-8 w-[3px]'));
</script>

<template>
    <span aria-hidden="true" :class="['inline-flex items-center', size === 'sm' ? 'gap-1' : 'gap-1.5']">
        <span
            v-for="stroke in count"
            :key="stroke"
            :class="[
                'rounded-full',
                strokeClass,
                stroke % 2 ? 'rotate-3' : '-rotate-2',
                highlightLast && stroke === count ? 'bg-pen' : toneClass,
            ]"
        ></span>
    </span>
</template>
