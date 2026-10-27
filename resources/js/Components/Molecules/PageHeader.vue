<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    eyebrow: {
        type: String,
        default: '',
    },
    description: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <header class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <p v-if="eyebrow" class="font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">{{ eyebrow }}</p>
            <h1 class="mt-1 font-hand text-3xl font-extrabold leading-tight text-ink sm:text-4xl">{{ title }}</h1>
            <p v-if="description" class="mt-2 max-w-2xl text-[15px] leading-7 text-ink-soft">{{ description }}</p>
        </div>
        <div v-if="$slots.actions" class="flex shrink-0 flex-wrap items-center gap-3">
            <slot name="actions" />
        </div>
    </header>
</template>
