<script setup>
import { computed } from 'vue';

const props = defineProps({
    active: {
        type: Boolean,
        default: true,
    },
    variant: {
        type: String,
        default: null, // 'success', 'danger', 'info', 'warning'
    },
});

const badgeClass = computed(() => {
    if (props.variant === 'danger' || (!props.variant && !props.active)) {
        return 'bg-pen/10 text-pen';
    }
    if (props.variant === 'warning') {
        return 'bg-stabilo/70 text-graphite';
    }
    if (props.variant === 'info') {
        return 'bg-rule/60 text-ink';
    }
    return 'bg-ink/10 text-ink';
});
</script>

<template>
    <span :class="['inline-flex items-center rounded-full px-3 py-1 font-form text-[10px] font-semibold uppercase tracking-[0.14em]', badgeClass]">
        <slot />
    </span>
</template>
