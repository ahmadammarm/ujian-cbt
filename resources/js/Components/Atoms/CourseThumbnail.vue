<script setup>
import { ref, watch, computed } from 'vue';
import ApplicationLogo from '@/Components/Atoms/ApplicationLogo.vue';

const props = defineProps({
    src: {
        type: String,
        default: null,
    },
    alt: {
        type: String,
        default: 'Sampul kursus',
    },
    name: {
        type: String,
        default: 'Kursus',
    },
    imgClass: {
        type: String,
        default: 'w-full h-full object-cover',
    },
    monogramClass: {
        type: String,
        default: '',
    },
});

const hasError = ref(false);

watch(() => props.src, () => {
    hasError.value = false;
});

const initials = computed(() => {
    if (!props.name) return 'NJ';
    const words = props.name.trim().split(/\s+/).filter(Boolean);
    if (words.length >= 2) {
        return (words[0][0] + words[1][0]).toUpperCase();
    }
    return props.name.trim().substring(0, 2).toUpperCase();
});

const normalizedSrc = computed(() => {
    if (!props.src) return null;
    if (props.src.startsWith('http://') || props.src.startsWith('https://') || props.src.startsWith('blob:') || props.src.startsWith('data:')) {
        return props.src;
    }
    if (props.src.startsWith('/')) {
        return props.src;
    }
    return '/storage/' + props.src;
});
</script>

<template>
    <div class="relative flex h-full w-full items-center justify-center overflow-hidden">
        <img
            v-if="normalizedSrc && !hasError"
            :src="normalizedSrc"
            :alt="alt || name"
            :class="[imgClass]"
            @error="hasError = true"
        />

        <!-- Fallback: initials on notebook-blue paper -->
        <div v-else class="relative flex h-full w-full select-none items-center justify-center bg-rule/50">
            <ApplicationLogo class="pointer-events-none absolute size-4/5 text-ink opacity-[0.06]" />
            <span :class="['relative z-10 font-hand font-extrabold tracking-tight text-ink', monogramClass]">
                {{ initials }}
            </span>
        </div>
    </div>
</template>
