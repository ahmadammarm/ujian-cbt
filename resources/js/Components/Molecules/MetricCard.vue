<script setup>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Atoms/Icon.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    sublabel: {
        type: String,
        default: '',
    },
    href: {
        type: String,
        default: null,
    },
    linkText: {
        type: String,
        default: '',
    },
    footerText: {
        type: String,
        default: '',
    },
    // Kept for backwards compatibility; the study-desk theme uses one palette for every space
    theme: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <div class="flex flex-col justify-between gap-5 rounded-md border border-rule bg-paper p-5 sm:p-6">
        <div class="flex items-start justify-between gap-3">
            <p class="font-form text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-soft">{{ title }}</p>
            <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-rule/50 text-ink">
                <slot name="icon">
                    <Icon name="chart" class="size-5" />
                </slot>
            </span>
        </div>

        <div>
            <p class="font-legible text-4xl font-bold tracking-tight text-ink">{{ value }}</p>
            <p v-if="sublabel" class="mt-1 text-sm text-ink-soft">{{ sublabel }}</p>
        </div>

        <div v-if="(href && linkText) || footerText || $slots.footer" class="border-t border-dashed border-rule pt-4">
            <slot name="footer">
                <Link
                    v-if="href && linkText"
                    :href="href"
                    class="inline-flex items-center gap-1 rounded-sm text-sm font-bold text-ink underline decoration-pen/50 decoration-2 underline-offset-4 hover:decoration-pen focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                >
                    {{ linkText }}
                    <Icon name="chevron-right" class="size-4" />
                </Link>
                <span v-else-if="footerText" class="text-sm text-ink-soft">{{ footerText }}</span>
            </slot>
        </div>
    </div>
</template>
