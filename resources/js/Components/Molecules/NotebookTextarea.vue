<script setup>
import { computed } from 'vue';

const model = defineModel({
    type: String,
    default: '',
});

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    rows: {
        type: Number,
        default: 4,
    },
    maxlength: {
        type: Number,
        default: null,
    },
    placeholder: {
        type: String,
        default: null,
    },
    hint: {
        type: String,
        default: '',
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

const describedBy = computed(() => {
    if (props.error) return `${props.id}-error`;
    if (props.hint || props.maxlength) return `${props.id}-hint`;
    return undefined;
});
</script>

<template>
    <div>
        <label :for="id" class="block font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">{{ label }}</label>
        <!-- Lined paper: 32px rules match the 2rem line height -->
        <textarea
            :id="id"
            v-model="model"
            :rows="rows"
            :maxlength="maxlength"
            :placeholder="placeholder"
            :required="required"
            :aria-invalid="error ? 'true' : undefined"
            :aria-describedby="describedBy"
            :class="[
                'mt-2 block w-full resize-y rounded-md border bg-paper bg-notebook-lines bg-local px-3 pt-0 font-legible text-lg leading-8 text-ink transition-colors placeholder:text-ink-soft/50 focus:outline-none focus:ring-2 focus:ring-pen/30 motion-reduce:transition-none',
                error ? 'border-pen' : 'border-rule focus:border-ink',
            ]"
        ></textarea>
        <p v-if="error" :id="`${id}-error`" class="mt-2 font-hand text-base font-semibold leading-snug text-pen">{{ error }}</p>
        <p v-else-if="hint || maxlength" :id="`${id}-hint`" class="mt-2 flex justify-between gap-4 text-sm text-ink-soft">
            <span>{{ hint }}</span>
            <span v-if="maxlength" class="font-form text-xs tabular-nums">{{ model?.length || 0 }}/{{ maxlength }}</span>
        </p>
    </div>
</template>
