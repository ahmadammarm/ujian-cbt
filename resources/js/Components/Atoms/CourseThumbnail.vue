<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
    src: {
        type: String,
        default: null,
    },
    alt: {
        type: String,
        default: 'Thumbnail Kursus',
    },
    name: {
        type: String,
        default: 'Kursus Asesmen',
    },
    theme: {
        type: String,
        default: 'teacher', // 'teacher' (Terracotta) | 'student' (Cobalt)
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
const isLoaded = ref(false);

watch(() => props.src, () => {
    hasError.value = false;
    isLoaded.value = false;
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
    <div class="w-full h-full relative overflow-hidden flex items-center justify-center">
        <!-- Render Real Image if available and not error -->
        <img
            v-if="normalizedSrc && !hasError"
            :src="normalizedSrc"
            :alt="alt || name"
            :class="[imgClass]"
            @error="hasError = true"
            @load="isLoaded = true"
        />

        <!-- Fallback Monogram Card (Zero Blur / Zero Glow) -->
        <div
            v-else
            class="w-full h-full relative flex items-center justify-center select-none bg-slate-100 dark:bg-[#141419]"
        >
            <!-- Watermark Monogram Vector -->
            <div
                class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.06] dark:opacity-[0.1]"
                :class="theme === 'student' ? 'text-[#2B82FE]' : 'text-[#D95300]'"
            >
                <svg class="w-4/5 h-4/5 fill-current" viewBox="0 0 24 24">
                    <path d="M4 3.5H8.2L15.8 15.3V3.5H20V20.5H15.8L8.2 8.7V20.5H4V3.5Z" />
                </svg>
            </div>

            <!-- Initials Monogram -->
            <span
                :class="[
                    'relative z-10 font-black tracking-tight select-none',
                    theme === 'student' ? 'text-[#2B82FE]' : 'text-[#D95300]',
                    monogramClass
                ]"
            >
                {{ initials }}
            </span>
        </div>
    </div>
</template>
