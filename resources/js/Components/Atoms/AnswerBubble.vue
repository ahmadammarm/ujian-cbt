<script setup>
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
        <span
            aria-hidden="true"
            class="absolute inset-0.5 rounded-full border-[1.5px] border-pen/60 transition-colors peer-hover:border-pen peer-focus-visible:ring-2 peer-focus-visible:ring-ink peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-paper"
        ></span>
        <span aria-hidden="true" class="relative font-form text-[11px] font-semibold text-pen/80">{{ value }}</span>
        <span
            v-if="checked"
            aria-hidden="true"
            class="absolute inset-1 rounded-[48%_52%_45%_55%/52%_46%_54%_48%] bg-graphite shadow-[inset_0_0_0_1.5px_rgba(0,0,0,0.25)] motion-safe:animate-pencil"
            :style="{ animationDelay: `${delay}ms` }"
        ></span>
    </label>
</template>
