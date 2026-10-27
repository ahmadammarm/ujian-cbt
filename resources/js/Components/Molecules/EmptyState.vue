<script setup>
import Icon from '@/Components/Atoms/Icon.vue';

defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: 'inbox',
    },
});
</script>

<template>
    <div class="flex flex-col items-center rounded-md border-2 border-dashed border-rule bg-paper px-6 py-14 text-center">
        <span class="flex size-12 items-center justify-center rounded-md bg-rule/50 text-ink">
            <Icon :name="icon" class="size-6" />
        </span>
        <p class="mt-4 font-hand text-2xl font-bold text-ink">{{ title }}</p>
        <p v-if="description" class="mt-2 max-w-md text-[15px] leading-7 text-ink-soft">{{ description }}</p>
        <div v-if="$slots.default" class="mt-6">
            <slot />
        </div>
    </div>
</template>
