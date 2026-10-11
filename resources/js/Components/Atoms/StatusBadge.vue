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
        return 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20';
    }
    if (props.variant === 'warning') {
        return 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20';
    }
    if (props.variant === 'info') {
        return 'bg-[#2B82FE]/10 text-[#2B82FE] border border-[#2B82FE]/20';
    }
    // Default success / active
    return 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20';
});
</script>

<template>
    <span
        :class="[
            'inline-flex items-center px-3.5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-colors',
            badgeClass,
        ]"
    >
        <slot />
    </span>
</template>
