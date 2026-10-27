<script setup>
import { computed } from 'vue';

// A grade written in red pen and circled, the way a teacher marks a paper
const props = defineProps({
    score: {
        type: [Number, String],
        default: null,
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
});

const display = computed(() => {
    if (props.score === null || props.score === undefined || props.score === '') return '–';
    return Math.round(Number(props.score));
});

const sizeClasses = computed(() => ({
    sm: { box: 'size-11', text: 'text-base' },
    md: { box: 'size-20', text: 'text-3xl' },
    lg: { box: 'size-36 sm:size-40', text: 'text-6xl' },
}[props.size]));
</script>

<template>
    <span :class="['relative inline-flex shrink-0 items-center justify-center', sizeClasses.box]">
        <svg class="absolute inset-0 size-full -rotate-6 text-pen" viewBox="0 0 80 80" fill="none" aria-hidden="true">
            <path
                d="M41 6C60 5 75 19 74 40C73 61 58 75 38 74C18 73 5 59 6 39C7 21 21 8 44 9"
                stroke="currentColor"
                stroke-width="2.5"
                stroke-linecap="round"
                vector-effect="non-scaling-stroke"
            />
        </svg>
        <span class="sr-only">Nilai</span>
        <span :class="['relative font-hand font-extrabold leading-none text-pen', sizeClasses.text]">{{ display }}</span>
    </span>
</template>
