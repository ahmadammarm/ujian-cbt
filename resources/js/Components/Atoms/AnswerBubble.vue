<script setup>
import BubbleMark from '@/Components/Atoms/BubbleMark.vue';

defineProps({
    name: {
        type: String,
        required: true,
    },
    value: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    checked: {
        type: Boolean,
        default: false,
    },
    delay: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits(['select']);
</script>

<template>
    <label class="relative inline-flex size-7 shrink-0 cursor-pointer items-center justify-center">
        <input
            type="radio"
            class="peer sr-only"
            :name="name"
            :value="value"
            :checked="checked"
            :aria-label="label"
            @change="emit('select', value)"
        />
        <BubbleMark
            :label="value"
            :filled="checked"
            :delay="delay"
            class="peer-hover:border-pen peer-focus-visible:ring-2 peer-focus-visible:ring-ink peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-paper"
        />
    </label>
</template>
