<script setup>
import { computed, onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
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
    type: {
        type: String,
        default: 'text',
    },
    error: {
        type: String,
        default: '',
    },
    hint: {
        type: String,
        default: '',
    },
    autocomplete: {
        type: String,
        default: null,
    },
    placeholder: {
        type: String,
        default: null,
    },
    required: {
        type: Boolean,
        default: false,
    },
    autofocus: {
        type: Boolean,
        default: false,
    },
});

const input = ref(null);
const isPasswordVisible = ref(false);

const isPassword = computed(() => props.type === 'password');
const inputType = computed(() => (isPassword.value && isPasswordVisible.value ? 'text' : props.type));
const describedBy = computed(() => {
    if (props.error) return `${props.id}-error`;
    if (props.hint) return `${props.id}-hint`;
    return undefined;
});

// Native autofocus does not fire on Inertia page visits
onMounted(() => {
    if (props.autofocus) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div>
        <label :for="id" class="block font-form text-[11px] font-semibold uppercase tracking-[0.16em] text-pen">
            {{ label }}
        </label>
        <div class="relative mt-1">
            <input
                :id="id"
                ref="input"
                v-model="model"
                :type="inputType"
                :autocomplete="autocomplete"
                :placeholder="placeholder"
                :required="required"
                :aria-invalid="error ? 'true' : undefined"
                :aria-describedby="describedBy"
                :class="[
                    'w-full rounded-none border-0 border-b-2 bg-transparent px-1 py-2.5 font-legible text-lg text-ink transition-colors placeholder:text-ink-soft/50 focus:bg-stabilo/30 focus:outline-none focus:ring-0 motion-reduce:transition-none',
                    error ? 'border-pen focus:border-pen' : 'border-ink-soft/70 focus:border-ink',
                    isPassword ? 'pr-16' : '',
                ]"
            />
            <button
                v-if="isPassword"
                type="button"
                class="absolute bottom-2 right-1 rounded px-1.5 py-1 font-legible text-sm font-bold text-ink-soft underline decoration-pen/50 decoration-2 underline-offset-4 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pen"
                :aria-pressed="isPasswordVisible"
                :aria-label="isPasswordVisible ? 'Sembunyikan password' : 'Tampilkan password'"
                @click="isPasswordVisible = !isPasswordVisible"
            >
                {{ isPasswordVisible ? 'Tutup' : 'Lihat' }}
            </button>
        </div>
        <p v-if="error" :id="`${id}-error`" class="mt-2 font-hand text-base font-semibold leading-snug text-pen">
            {{ error }}
        </p>
        <p v-else-if="hint" :id="`${id}-hint`" class="mt-2 font-legible text-sm text-ink-soft">
            {{ hint }}
        </p>
    </div>
</template>
