<script setup>
import Icon from '@/Components/Atoms/Icon.vue';

defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Cari…',
    },
    label: {
        type: String,
        default: 'Cari',
    },
});

const emit = defineEmits(['update:modelValue']);

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};

const handleClear = () => {
    emit('update:modelValue', '');
};
</script>

<template>
    <div class="relative w-full">
        <Icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-ink-soft" />
        <input
            type="search"
            :value="modelValue"
            :placeholder="placeholder"
            :aria-label="label"
            class="h-11 w-full rounded-md border border-rule bg-paper pl-10 pr-10 font-legible text-[15px] text-ink transition-colors placeholder:text-ink-soft/60 focus:border-ink focus:bg-stabilo/15 focus:outline-none focus:ring-0 motion-reduce:transition-none [&::-webkit-search-cancel-button]:hidden"
            @input="handleInput"
        />
        <button
            v-if="modelValue"
            type="button"
            class="absolute right-2 top-1/2 flex size-7 -translate-y-1/2 items-center justify-center rounded text-ink-soft hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
            aria-label="Hapus pencarian"
            @click="handleClear"
        >
            <Icon name="close" class="size-4" />
        </button>
    </div>
</template>
