<script setup>
import Icon from '@/Components/Atoms/Icon.vue';

const model = defineModel({
    type: [String, Number],
    default: '',
});

defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    // [{ value, label }]
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Pilih salah satu',
    },
    error: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div>
        <label :for="id" class="block font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">{{ label }}</label>
        <div class="relative mt-1">
            <select
                :id="id"
                v-model="model"
                :required="required"
                :aria-invalid="error ? 'true' : undefined"
                :aria-describedby="error ? `${id}-error` : undefined"
                :class="[
                    'w-full appearance-none rounded-none border-0 border-b-2 bg-transparent bg-none px-1 py-2.5 pr-8 font-legible text-lg text-ink transition-colors focus:bg-stabilo/30 focus:outline-none focus:ring-0 motion-reduce:transition-none',
                    error ? 'border-pen focus:border-pen' : 'border-ink-soft/70 focus:border-ink',
                ]"
            >
                <option value="" disabled>{{ placeholder }}</option>
                <option v-for="option in options" :key="option.value" :value="option.value">{{ option.label }}</option>
            </select>
            <Icon name="chevron-down" class="pointer-events-none absolute right-1 top-1/2 size-5 -translate-y-1/2 text-ink-soft" />
        </div>
        <p v-if="error" :id="`${id}-error`" class="mt-2 font-hand text-base font-semibold leading-snug text-pen">{{ error }}</p>
    </div>
</template>
