<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Cari data...',
    },
    theme: {
        type: String,
        default: 'teacher', // 'teacher' (#D95300) or 'student' (#2B82FE)
    },
});

const emit = defineEmits(['update:modelValue']);

const focusRingClass = computed(() => {
    return props.theme === 'student'
        ? 'focus:ring-[#2B82FE] focus:border-[#2B82FE]'
        : 'focus:ring-[#D95300] focus:border-[#D95300]';
});

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};

const handleClear = () => {
    emit('update:modelValue', '');
};
</script>

<template>
    <div class="relative w-full">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <input
            type="text"
            :value="modelValue"
            @input="handleInput"
            :placeholder="placeholder"
            :class="[
                'w-full h-12 pl-11 pr-10 bg-white dark:bg-[#111116] border border-slate-200/80 dark:border-slate-800 rounded-2xl transition-all font-medium text-xs text-[#0A090B] dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-2',
                focusRingClass,
            ]"
        />

        <button
            v-if="modelValue"
            type="button"
            @click="handleClear"
            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</template>
